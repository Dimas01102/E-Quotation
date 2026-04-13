<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MailService
{
    private $mailer;
    private bool $phpMailerAvailable;

    public function __construct()
    {
        $this->phpMailerAvailable = class_exists(\PHPMailer\PHPMailer\PHPMailer::class);

        if ($this->phpMailerAvailable) {
            $mailer = new \PHPMailer\PHPMailer\PHPMailer(true);
            $mailer->isSMTP();
            $mailer->Host       = config('mail.mailers.smtp.host', 'smtp.gmail.com');
            $mailer->SMTPAuth   = true;
            $mailer->Username   = config('mail.mailers.smtp.username');
            $mailer->Password   = config('mail.mailers.smtp.password');
            $mailer->SMTPSecure = config('mail.mailers.smtp.encryption', 'tls');
            $mailer->Port       = config('mail.mailers.smtp.port', 587);
            $mailer->setFrom(config('mail.from.address'), config('mail.from.name'));
            $mailer->CharSet    = 'UTF-8';
            $this->mailer       = $mailer;
        }
    }

    // 1. Supplier register
    public function sendSupplierRegistered(string $toEmail, string $toName): void
    {
        $subject = 'Registrasi Supplier Berhasil - E-Quotation System';
        $body    = $this->wrap("Registrasi Berhasil", "
            <p>Halo <strong>{$toName}</strong>,</p>
            <p>Terima kasih telah mendaftar sebagai supplier di sistem E-Quotation kami.</p>
            <p>Akun Anda sedang dalam proses verifikasi oleh tim admin. Anda akan mendapatkan email notifikasi setelah akun diaktifkan.</p>
        ");
        $this->send($toEmail, $toName, $subject, $body);
        $this->log($toEmail, $subject, 'supplier_registered');
    }

    // 2. Admin aktifkan supplier
    public function sendSupplierActivated(string $toEmail, string $toName): void
    {
        $subject = 'Akun Supplier Anda Telah Diaktifkan - E-Quotation System';
        $body    = $this->wrap("Akun Diaktifkan 🎉", "
            <p>Halo <strong>{$toName}</strong>,</p>
            <p>Selamat! Akun supplier Anda telah <strong>diaktifkan</strong> oleh admin.</p>
            <a href='" . url('/login') . "' style='background:#2563eb;color:white;padding:10px 24px;border-radius:8px;text-decoration:none;display:inline-block;margin-top:12px'>Login Sekarang</a>
        ");
        $this->send($toEmail, $toName, $subject, $body);
        $this->log($toEmail, $subject, 'supplier_activated');
    }

    // 3. Undangan RFQ
    public function sendRfqInvitation(string $toEmail, string $toName, string $batchTitle, $deadline): void
    {
        $dl      = $deadline ? (is_string($deadline) ? $deadline : date('d F Y', strtotime($deadline))) : '-';
        $subject = "Undangan RFQ: {$batchTitle} - E-Quotation System";
        $body    = $this->wrap("Undangan RFQ 📋", "
            <p>Halo <strong>{$toName}</strong>,</p>
            <p>Anda telah diundang untuk mengikuti pengadaan:</p>
            <table style='width:100%;border-collapse:collapse;margin:16px 0;border:1px solid #e5e7eb;border-radius:8px;overflow:hidden'>
                <tr style='background:#f3f4f6'><td style='padding:10px 14px;font-weight:bold;width:40%'>Nama RFQ</td><td style='padding:10px 14px'>{$batchTitle}</td></tr>
                <tr><td style='padding:10px 14px;font-weight:bold;background:#f3f4f6'>Deadline</td><td style='padding:10px 14px'><strong style='color:#dc2626'>{$dl}</strong></td></tr>
            </table>
            <p>Segera login dan ajukan penawaran sebelum deadline.</p>
            <a href='" . url('/supplier/quotations') . "' style='background:#2563eb;color:white;padding:10px 24px;border-radius:8px;text-decoration:none;display:inline-block;margin-top:12px'>Ajukan Penawaran</a>
        ");
        $this->send($toEmail, $toName, $subject, $body);
        $this->log($toEmail, $subject, 'rfq_invitation');
    }

    // 4. Supplier submit → notif admin
    public function sendQuotationSubmitted(string $toEmail, string $companyName, string $batchTitle): void
    {
        $subject = "Penawaran Baru: {$companyName} - {$batchTitle}";
        $body    = $this->wrap("Penawaran Baru Masuk 📥", "
            <p>Penawaran baru dikirim oleh: <strong>{$companyName}</strong></p>
            <p>Batch RFQ: <strong>{$batchTitle}</strong></p>
            <p>Waktu: " . now()->format('d F Y H:i') . "</p>
            <a href='" . url('/admin/quotations') . "' style='background:#2563eb;color:white;padding:10px 24px;border-radius:8px;text-decoration:none;display:inline-block;margin-top:12px'>Review Penawaran</a>
        ");
        $this->send($toEmail, 'Admin', $subject, $body);
        $this->log($toEmail, $subject, 'quotation_submitted');
    }

    // 5. Approve → notif supplier
    public function sendQuotationApproved(string $toEmail, string $toName, string $batchTitle): void
    {
        $subject = "🎉 Penawaran Anda Diterima - {$batchTitle}";
        $body    = $this->wrap("Penawaran Diterima 🎉", "
            <p>Halo <strong>{$toName}</strong>,</p>
            <p>Selamat! Penawaran Anda untuk RFQ <strong>{$batchTitle}</strong> telah <strong style='color:#16a34a'>DISETUJUI</strong>.</p>
            <p>Purchase Order (PO) telah digenerate. Download melalui dashboard supplier Anda.</p>
            <a href='" . url('/supplier/quotations') . "' style='background:#16a34a;color:white;padding:10px 24px;border-radius:8px;text-decoration:none;display:inline-block;margin-top:12px'>Download PO</a>
        ");
        $this->send($toEmail, $toName, $subject, $body);
        $this->log($toEmail, $subject, 'quotation_approved');
    }

    // 6. Reject → notif supplier
    public function sendQuotationRejected(string $toEmail, string $toName, string $batchTitle, string $reason): void
    {
        $subject = "Penawaran Tidak Diterima - {$batchTitle}";
        $body    = $this->wrap("Hasil Evaluasi Penawaran", "
            <p>Halo <strong>{$toName}</strong>,</p>
            <p>Mohon maaf, penawaran Anda untuk <strong>{$batchTitle}</strong> tidak diterima.</p>
            <div style='background:#fef2f2;border-left:4px solid #dc2626;padding:12px;border-radius:4px;margin:16px 0'>
                <strong>Alasan:</strong> {$reason}
            </div>
            <p>Terima kasih atas partisipasi Anda.</p>
        ");
        $this->send($toEmail, $toName, $subject, $body);
        $this->log($toEmail, $subject, 'quotation_rejected');
    }

    // 7.  Reminder deadline (H-3, H-1) 
    public function sendDeadlineReminder(
        string $toEmail,
        string $toName,
        string $companyName,
        string $batchTitle,
        string $batchNumber,
        $deadline,
        int $daysLeft
    ): void {
        $dl      = is_string($deadline) ? $deadline : date('d F Y', strtotime($deadline));
        $urgency = $daysLeft === 1 ? '🚨 BESOK DEADLINE!' : "⏰ {$daysLeft} Hari Lagi";
        $bg      = $daysLeft === 1 ? '#fef2f2' : '#fff7ed';
        $border  = $daysLeft === 1 ? '#fca5a5' : '#fed7aa';
        $color   = $daysLeft === 1 ? '#991b1b' : '#c2410c';

        $subject = "{$urgency} — Deadline RFQ: {$batchTitle}";
        $body    = $this->wrap("{$urgency} Deadline Pengadaan", "
            <p>Halo <strong>{$toName}</strong> dari <strong>{$companyName}</strong>,</p>
            <p>Anda <strong>belum mengirimkan penawaran</strong> untuk pengadaan berikut:</p>
            <table style='width:100%;border-collapse:collapse;margin:16px 0;border:1px solid #e5e7eb'>
                <tr style='background:#f3f4f6'><td style='padding:10px 14px;font-weight:bold;width:40%'>No. RFQ</td><td style='padding:10px 14px'>{$batchNumber}</td></tr>
                <tr><td style='padding:10px 14px;font-weight:bold;background:#f3f4f6'>Nama RFQ</td><td style='padding:10px 14px'>{$batchTitle}</td></tr>
                <tr style='background:#f3f4f6'><td style='padding:10px 14px;font-weight:bold'>Deadline</td><td style='padding:10px 14px'><strong style='color:{$color}'>{$dl}</strong></td></tr>
            </table>
            <div style='background:{$bg};border:1px solid {$border};border-radius:8px;padding:14px;margin:16px 0'>
                <p style='margin:0;color:{$color};font-weight:bold'>{$urgency}</p>
                <p style='margin:8px 0 0;color:{$color}'>Segera upload penawaran sebelum sistem menutup batch ini.</p>
            </div>
            <a href='" . url('/supplier/quotations') . "' style='background:#dc2626;color:white;padding:12px 28px;border-radius:8px;text-decoration:none;display:inline-block;font-weight:bold'>Upload Penawaran Sekarang</a>
        ");
        $this->send($toEmail, $toName, $subject, $body);
        $this->log($toEmail, $subject, 'deadline_reminder');
    }

    // 8. sendWinnerReminder — reminder ke supplier pemenang
    public function sendWinnerReminder(
        string $toEmail,
        string $toName,
        string $companyName,
        string $batchTitle,
        string $batchNumber,
        $newDeadline = null
    ): void {
        $dl      = $newDeadline
            ? (is_string($newDeadline) ? $newDeadline : date('d F Y', strtotime($newDeadline)))
            : null;
        $subject = "Informasi Pengadaan: {$batchTitle} - E-Quotation System";
        $body    = $this->wrap("Informasi Pengadaan 📢", "
            <p>Halo <strong>{$toName}</strong> dari <strong>{$companyName}</strong>,</p>
            <p>Kami menginformasikan bahwa pengadaan <strong>{$batchTitle}</strong> ({$batchNumber}) telah diperbarui.</p>
            " . ($dl ? "
            <div style='background:#fff7ed;border:1px solid #fed7aa;border-radius:8px;padding:14px;margin:16px 0'>
                <p style='margin:0;color:#c2410c;font-weight:bold'>📅 Deadline Diperbarui</p>
                <p style='margin:8px 0 0;color:#9a3412'>Deadline baru: <strong>{$dl}</strong></p>
            </div>" : "") . "
            <p>Jika Anda ingin mengajukan penawaran kembali, silakan login ke sistem.</p>
            <a href='" . url('/supplier/quotations') . "' style='background:#2563eb;color:white;padding:10px 24px;border-radius:8px;text-decoration:none;display:inline-block;margin-top:12px'>Buka Dashboard Supplier</a>
        ");
        $this->send($toEmail, $toName, $subject, $body);
        $this->log($toEmail, $subject, 'winner_reminder');
    }

    // 9. Batch ditutup otomatis
    public function sendBatchClosed(string $toEmail, string $toName, string $batchTitle, string $batchNumber): void
    {
        $subject = "Pengadaan Ditutup: {$batchTitle}";
        $body    = $this->wrap("Pengadaan Telah Ditutup", "
            <p>Halo <strong>{$toName}</strong>,</p>
            <p>Pengadaan berikut telah <strong>ditutup</strong> karena telah melewati batas waktu:</p>
            <table style='width:100%;border-collapse:collapse;margin:16px 0;border:1px solid #e5e7eb'>
                <tr style='background:#f3f4f6'><td style='padding:10px 14px;font-weight:bold;width:40%'>No. RFQ</td><td style='padding:10px 14px'>{$batchNumber}</td></tr>
                <tr><td style='padding:10px 14px;font-weight:bold;background:#f3f4f6'>Nama RFQ</td><td style='padding:10px 14px'>{$batchTitle}</td></tr>
            </table>
            <p>Terima kasih atas partisipasi Anda.</p>
        ");
        $this->send($toEmail, $toName, $subject, $body);
        $this->log($toEmail, $subject, 'batch_closed');
    }

    // ─── Private ──────────────────────────────────────────────────────
    private function send(string $toEmail, string $toName, string $subject, string $html): void
    {
        if (!$this->phpMailerAvailable) {
            Log::info("[MailService] PHPMailer tidak tersedia. Email ke {$toEmail} tidak terkirim.");
            return;
        }
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($toEmail, $toName);
            $this->mailer->Subject  = $subject;
            $this->mailer->isHTML(true);
            $this->mailer->Body     = $html;
            $this->mailer->AltBody  = strip_tags($html);
            $this->mailer->send();
        } catch (\Exception $e) {
            Log::error("[MailService] Gagal kirim ke {$toEmail}: " . $e->getMessage());
            throw $e;
        }
    }

    private function log(string $toEmail, string $subject, string $type): void
    {
        try {
            DB::table('email_logs')->insert([
                'to_email'   => $toEmail,
                'subject'    => $subject,
                'type'       => $type,
                'sent_at'    => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Exception $e) {
            Log::warning('[MailService] Gagal log email: ' . $e->getMessage());
        }
    }

    private function wrap(string $title, string $content): string
    {
        return "<!DOCTYPE html><html><head><meta charset='UTF-8'>
<style>
body{font-family:Arial,sans-serif;background:#f3f4f6;margin:0;padding:20px;color:#374151}
.w{max-width:600px;margin:0 auto;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 4px 16px rgba(0,0,0,.1)}
.h{background:linear-gradient(135deg,#1e40af,#1d4ed8);padding:24px 32px;color:#fff}
.h h1{margin:0;font-size:20px;font-weight:700}.h p{margin:4px 0 0;font-size:13px;opacity:.8}
.b{padding:28px 32px;line-height:1.65;font-size:14px}
.b h2{margin-top:0;color:#1e40af;font-size:18px;font-weight:700}
.f{background:#f9fafb;padding:16px 32px;text-align:center;font-size:11px;color:#9ca3af;border-top:1px solid #e5e7eb}
</style></head><body>
<div class='w'>
  <div class='h'><h1>E-Quotation System</h1><p>Procurement Management Platform</p></div>
  <div class='b'><h2>{$title}</h2>{$content}</div>
  <div class='f'>© " . date('Y') . " E-Quotation System &nbsp;·&nbsp; Email otomatis.</div>
</div></body></html>";
    }
}
