<?php

namespace App\Console\Commands;

use App\Models\Batch;
use App\Models\InvitedSupplierCategory;
use App\Services\MailService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CloseExpiredBatches extends Command
{
    protected $signature   = 'batches:close-expired';
    protected $description = 'Menutup batch yang sudah melewati deadline dan kirim notifikasi';

    public function handle(): int
    {
        $this->info('Memeriksa batch expired...');

        // Batch yang statusnya open/draft DAN deadline sudah lewat (deadline < hari ini)
        $expired = Batch::whereIn('status', ['open', 'draft'])
            ->whereNotNull('deadline')
            ->whereDate('deadline', '<', today())
            ->get();

        if ($expired->isEmpty()) {
            $this->info('Tidak ada batch yang perlu ditutup.');
            return self::SUCCESS;
        }

        $mail = new MailService();

        foreach ($expired as $batch) {
            $this->line("Menutup: {$batch->batch_number} — {$batch->title}");
            $batch->update(['status' => 'closed']);

            // Kirim email ke supplier yang diundang
            try {
                $invitations = InvitedSupplierCategory::with('supplier.user')
                    ->whereHas('batchCategory', fn($q) => $q->where('id_batch', $batch->id_batch))
                    ->get();

                foreach ($invitations as $inv) {
                    $user = $inv->supplier?->user;
                    if (!$user) continue;
                    try {
                        $mail->sendBatchClosed($user->email, $user->name, $batch->title, $batch->batch_number);
                        $this->line("  → Email ke: {$user->email}");
                    } catch (\Exception $e) {
                        Log::warning("Email batch-closed gagal ke {$user->email}: " . $e->getMessage());
                    }
                }
            } catch (\Exception $e) {
                Log::error("Error proses batch {$batch->id_batch}: " . $e->getMessage());
            }
        }

        $this->info("Selesai. {$expired->count()} batch ditutup.");
        return self::SUCCESS;
    }
}