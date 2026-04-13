<?php

namespace App\Console\Commands;

use App\Models\Batch;
use App\Models\InvitedSupplierCategory;
use App\Models\Quotation;
use App\Services\MailService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendDeadlineReminders extends Command
{
    protected $signature   = 'batches:send-reminders';
    protected $description = 'Kirim reminder email ke supplier yang belum submit (H-3 dan H-1 sebelum deadline)';

    public function handle(): int
    {
        $this->info('Mengirim reminder deadline...');

        $mail = new MailService();

        // Cari batch open yang deadlinenya H-3 atau H-1
        $batches = Batch::where('status', 'open')
            ->whereNotNull('deadline')
            ->whereIn(\Illuminate\Support\Facades\DB::raw('DATE(deadline)'), [
                today()->addDays(3)->format('Y-m-d'),
                today()->addDays(1)->format('Y-m-d'),
            ])
            ->get();

        if ($batches->isEmpty()) {
            $this->info('Tidak ada batch yang perlu diingatkan.');
            return self::SUCCESS;
        }

        foreach ($batches as $batch) {
            $daysLeft = today()->diffInDays($batch->deadline);
            $this->line("Batch: {$batch->batch_number} | H-{$daysLeft}");

            $invitations = InvitedSupplierCategory::with('supplier.user')
                ->whereHas('batchCategory', fn($q) => $q->where('id_batch', $batch->id_batch))
                ->get();

            foreach ($invitations as $inv) {
                $user     = $inv->supplier?->user;
                $supplier = $inv->supplier;
                if (!$user || !$supplier) continue;

                // Skip jika sudah submit
                if (Quotation::where('id_invited_supplier', $inv->id_invited_supplier)->exists()) {
                    $this->line("  → {$user->email} sudah submit, skip.");
                    continue;
                }

                try {
                    $mail->sendDeadlineReminder(
                        $user->email,
                        $user->name,
                        $supplier->company_name,
                        $batch->title,
                        $batch->batch_number,
                        $batch->deadline,
                        (int) $daysLeft
                    );
                    $this->line("  → Reminder terkirim ke: {$user->email} (H-{$daysLeft})");
                } catch (\Exception $e) {
                    Log::warning("Gagal kirim reminder ke {$user->email}: " . $e->getMessage());
                    $this->warn("  → Gagal: " . $e->getMessage());
                }
            }
        }

        $this->info('Selesai.');
        return self::SUCCESS;
    }
}