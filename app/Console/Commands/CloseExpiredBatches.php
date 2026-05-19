<?php

namespace App\Console\Commands;

use App\Models\Batch;
use App\Models\Quotation;
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

        $todayJakarta = now()->timezone('Asia/Jakarta')->startOfDay();

        $expired = Batch::whereIn('status', ['open', 'draft'])
            ->whereNotNull('deadline')
            ->whereDate('deadline', '<', now('Asia/Jakarta')->format('Y-m-d'))
            ->get();

        if ($expired->isEmpty()) {
            $this->info('Tidak ada batch yang perlu ditutup.');
            return self::SUCCESS;
        }

        $mail = new MailService();

        foreach ($expired as $batch) {
            $this->line("Menutup: {$batch->batch_number} — {$batch->title}");
            $batch->update(['status' => 'closed']);

            try {
                // Hanya ambil quotation yang approved (pemenang) di batch ini
                $approvedQuotations = Quotation::with(['invitedSupplier.supplier.user'])
                    ->where('status', 'approved')
                    ->whereHas(
                        'invitedSupplier',
                        fn($q) => $q->whereHas(
                            'batchCategory',
                            fn($q2) => $q2->where('id_batch', $batch->id_batch)
                        )
                    )
                    ->get();

                if ($approvedQuotations->isEmpty()) {
                    $this->line("  → Tidak ada pemenang di batch ini, tidak ada email dikirim.");
                    continue;
                }

                foreach ($approvedQuotations as $quotation) {
                    $user     = $quotation->invitedSupplier?->supplier?->user;
                    $supplier = $quotation->invitedSupplier?->supplier;
                    if (!$user || !$supplier) continue;

                    try {
                        $mail->sendBatchClosed(
                            $user->email,
                            $user->name,
                            $batch->title,
                            $batch->batch_number
                        );
                        $this->line("  → Email ke pemenang: {$user->email}");
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