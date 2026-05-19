<?php

namespace App\Console\Commands;

use App\Models\Batch;
use App\Models\InvitedSupplierCategory;
use App\Models\Quotation;
use App\Services\MailService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SendDeadlineReminders extends Command
{
    protected $signature   = 'batches:send-reminders';
    protected $description = 'Kirim reminder email ke supplier yang belum submit (H-3 dan H-1 sebelum deadline)';

    public function handle(): int
    {
        $this->info('Mengirim reminder deadline...');

        $mail = new MailService();

        $batches = Batch::where('status', 'open')
            ->whereNotNull('deadline')
            ->where(function ($q) {
                $q->whereDate('deadline', today('Asia/Jakarta')->addDays(3))
                    ->orWhereDate('deadline', today('Asia/Jakarta')->addDays(1));
            })
            ->get();

        if ($batches->isEmpty()) {
            $this->info('Tidak ada batch yang perlu diingatkan.');
            return self::SUCCESS;
        }

        foreach ($batches as $batch) {
            $daysLeft = today('Asia/Jakarta')->diffInDays($batch->deadline);

            $this->line("Batch: {$batch->batch_number} | H-{$daysLeft}");

            $invitations = InvitedSupplierCategory::with('supplier.user')
                ->whereHas('batchCategory', fn($q) => $q->where('id_batch', $batch->id_batch))
                ->get();

            foreach ($invitations as $inv) {
                $user     = $inv->supplier?->user;
                $supplier = $inv->supplier;
                if (!$user || !$supplier) continue;

                $invitedIds = InvitedSupplierCategory::whereHas(
                    'batchCategory',
                    fn($q) => $q->where('id_batch', $batch->id_batch)
                )
                    ->where('id_supplier', $supplier->id)
                    ->pluck('id_invited_supplier');

                $latestQuotation = Quotation::whereIn('id_invited_supplier', $invitedIds)
                    ->latest('submitted_at')
                    ->first();

                // Kalah (rejected) = skip
                if ($latestQuotation?->status === 'rejected') {
                    $this->line("  → {$user->email} rejected (kalah), skip.");
                    continue;
                }

                // Sudah submit tapi belum diproses = skip
                if (in_array($latestQuotation?->status, ['pending', 'submitted'])) {
                    $this->line("  → {$user->email} sudah submit ({$latestQuotation->status}), skip.");
                    continue;
                }

                // Approved (pemenang) dan belum submit = dapat reminder
                // NULL (belum pernah submit) = dapat reminder
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
