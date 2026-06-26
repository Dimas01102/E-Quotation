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
        $body    = $this->wrap(
            'Registrasi Berhasil',
            'Akun Anda sedang diverifikasi',
            $this->iconCheck(),
            '#0f766e',
            "
            <p>Halo <strong>{$toName}</strong>,</p>
            <p>Terima kasih telah mendaftar sebagai supplier di sistem E-Quotation kami.</p>
            <p>Akun Anda sedang dalam proses verifikasi oleh tim admin. Anda akan mendapatkan notifikasi email setelah akun diaktifkan.</p>
            " . $this->infoBox('Proses verifikasi biasanya memerlukan 1x24 jam kerja.')
        );
        $this->send($toEmail, $toName, $subject, $body);
        $this->log($toEmail, $subject, 'supplier_registered');
    }

    // 2. Admin aktifkan supplier
    public function sendSupplierActivated(string $toEmail, string $toName): void
    {
        $subject = 'Akun Supplier Anda Telah Diaktifkan - E-Quotation System';
        $body    = $this->wrap(
            'Akun Diaktifkan',
            'Selamat, akun Anda sudah aktif',
            $this->iconShield(),
            '#1d4ed8',
            "
            <p>Halo <strong>{$toName}</strong>,</p>
            <p>Akun supplier Anda telah <strong>diaktifkan</strong> oleh admin. Anda sekarang dapat login dan mulai mengikuti proses pengadaan.</p>
            " . $this->btn('Login ke Dashboard', url('/login'), '#1d4ed8')
        );
        $this->send($toEmail, $toName, $subject, $body);
        $this->log($toEmail, $subject, 'supplier_activated');
    }

    // 3. Undangan RFQ
    public function sendRfqInvitation(string $toEmail, string $toName, string $batchTitle, $deadline): void
    {
        $dl      = $deadline ? (is_string($deadline) ? $deadline : date('d F Y', strtotime($deadline))) : '-';
        $subject = "Undangan RFQ: {$batchTitle} - E-Quotation System";
        $body    = $this->wrap(
            'Undangan Pengadaan',
            'Anda diundang untuk mengajukan penawaran',
            $this->iconDoc(),
            '#7c3aed',
            "
            <p>Halo <strong>{$toName}</strong>,</p>
            <p>Anda telah diundang untuk mengikuti proses pengadaan berikut:</p>
            " . $this->table([
                ['Nama RFQ',  $batchTitle],
                ['Deadline',  "<strong style='color:#dc2626'>{$dl}</strong>"],
            ]) . "
            <p>Segera login dan ajukan penawaran Anda sebelum batas waktu.</p>
            " . $this->btn('Ajukan Penawaran', url('/supplier/quotations'), '#7c3aed')
        );
        $this->send($toEmail, $toName, $subject, $body);
        $this->log($toEmail, $subject, 'rfq_invitation');
    }

    // 4. Supplier submit -> notif admin
    public function sendQuotationSubmitted(string $toEmail, string $companyName, string $batchTitle): void
    {
        $subject = "Penawaran Baru: {$companyName} - {$batchTitle}";
        $body    = $this->wrap(
            'Penawaran Baru Masuk',
            'Terdapat penawaran yang perlu ditinjau',
            $this->iconInbox(),
            '#0369a1',
            "
            <p>Penawaran baru telah dikirim dan menunggu persetujuan Anda.</p>
            " . $this->table([
                ['Perusahaan', $companyName],
                ['Batch RFQ',  $batchTitle],
                ['Waktu',      now()->format('d F Y, H:i') . ' WIB'],
            ]) . "
            " . $this->btn('Tinjau Penawaran', url('/admin/quotations'), '#0369a1')
        );
        $this->send($toEmail, 'Admin', $subject, $body);
        $this->log($toEmail, $subject, 'quotation_submitted');
    }

    // 5. Approve -> notif supplier
    public function sendQuotationApproved(string $toEmail, string $toName, string $batchTitle): void
    {
        $subject = "Penawaran Anda Diterima - {$batchTitle}";
        $body    = $this->wrap(
            'Penawaran Disetujui',
            'Selamat, penawaran Anda telah diterima',
            $this->iconCheck(),
            '#15803d',
            "
            <p>Halo <strong>{$toName}</strong>,</p>
            <p>Penawaran Anda untuk RFQ <strong>{$batchTitle}</strong> telah <strong style='color:#15803d'>DISETUJUI</strong>.</p>
            <p>Purchase Order (PO) telah digenerate dan dapat diunduh melalui dashboard supplier Anda.</p>
            " . $this->btn('Download PO', url('/supplier/quotations'), '#15803d')
        );
        $this->send($toEmail, $toName, $subject, $body);
        $this->log($toEmail, $subject, 'quotation_approved');
    }

    // 6. Reject -> notif supplier
    public function sendQuotationRejected(string $toEmail, string $toName, string $batchTitle, string $reason): void
    {
        $subject = "Penawaran Tidak Diterima - {$batchTitle}";
        $body    = $this->wrap(
            'Hasil Evaluasi Penawaran',
            'Penawaran Anda belum dapat diterima',
            $this->iconX(),
            '#b91c1c',
            "
            <p>Halo <strong>{$toName}</strong>,</p>
            <p>Mohon maaf, penawaran Anda untuk <strong>{$batchTitle}</strong> tidak dapat diterima pada tahap ini.</p>
            <div style='background:#fef2f2;border-left:4px solid #dc2626;padding:14px 16px;border-radius:0 6px 6px 0;margin:20px 0'>
                <p style='margin:0 0 4px;font-size:11px;font-weight:700;color:#991b1b;text-transform:uppercase;letter-spacing:.5px'>Alasan Penolakan</p>
                <p style='margin:0;color:#7f1d1d;font-size:14px'>{$reason}</p>
            </div>
            <p>Terima kasih atas partisipasi Anda dalam proses pengadaan ini.</p>
            "
        );
        $this->send($toEmail, $toName, $subject, $body);
        $this->log($toEmail, $subject, 'quotation_rejected');
    }

  // 7. Reminder deadline (H-3, H-1) bagi supplier yang menang
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
        $urgency = $daysLeft === 1 ? 'Batas Waktu Berakhir Besok' : "Sisa {$daysLeft} Hari Sebelum Deadline";
        $accent  = $daysLeft === 1 ? '#b91c1c' : '#c2410c';
        $bgAlert = $daysLeft === 1 ? '#fef2f2' : '#fff7ed';
        $bdAlert = $daysLeft === 1 ? '#fca5a5' : '#fed7aa';
        $txAlert = $daysLeft === 1 ? '#7f1d1d' : '#7c2d12';

        $subject = "[Reminder] {$urgency} - {$batchTitle}";
        $body    = $this->wrap(
            $urgency,
            'Masih ada waktu untuk mengirim atau memperbarui penawaran Anda',
            $this->iconClock(),
            $accent,
            "
            <p>Halo <strong>{$toName}</strong> dari <strong>{$companyName}</strong>,</p>

            <p>Ini adalah pengingat bahwa proses pengadaan berikut masih berlangsung dan batas waktu pengajuan penawaran akan segera berakhir.</p>

            " . $this->table([
                ['No. RFQ',  $batchNumber],
                ['Nama RFQ', $batchTitle],
                ['Deadline', "<strong style='color:{$accent}'>{$dl}</strong>"],
            ]) . "

            <div style='background:{$bgAlert};border:1px solid {$bdAlert};border-radius:8px;padding:14px 16px;margin:20px 0'>
                <p style='margin:0 0 6px;font-weight:700;color:{$accent};font-size:13px'>" .
                    ($daysLeft === 1
                        ? 'Batas waktu akan berakhir besok.'
                        : "Tersisa {$daysLeft} hari sebelum deadline.") .
                "</p>

                <p style='margin:0;color:{$txAlert};font-size:13px'>
                    Jika Anda belum mengajukan penawaran, silakan segera mengirimkannya.
                    Jika sebelumnya sudah mengirim penawaran dan periode pengajuan kembali telah dibuka,
                    Anda juga dapat mengajukan ulang penawaran sebelum batas waktu berakhir.
                </p>
            </div>

            " . $this->btn('Buka Halaman Penawaran', url('/supplier/quotations'), $accent)
        );

        $this->send($toEmail, $toName, $subject, $body);
        $this->log($toEmail, $subject, 'deadline_reminder');
    }

    // 8. sendWinnerReminder - pengajuan ulang dibuka kembali untuk supplier yang menang
    public function sendWinnerReminder(
        string $toEmail,
        string $toName,
        string $companyName,
        string $batchTitle,
        string $batchNumber,
        $newDeadline = null
    ): void {
        $dl = $newDeadline
            ? (is_string($newDeadline) ? $newDeadline : date('d F Y', strtotime($newDeadline)))
            : null;

        $subject = "Pengajuan Penawaran Dibuka Kembali - {$batchTitle}";

        $body = $this->wrap(
            'Pengajuan Penawaran Dibuka Kembali',
            'Anda dapat mengajukan atau memperbarui penawaran sebelum deadline berakhir',
            $this->iconBell(),
            '#1d4ed8',
            "
            <p>Halo <strong>{$toName}</strong> dari <strong>{$companyName}</strong>,</p>

            <p>Pengadaan <strong>{$batchTitle}</strong> ({$batchNumber}) kembali dibuka untuk pengajuan penawaran.</p>

            <p>Jika sebelumnya Anda sudah mengirim penawaran, Anda diperbolehkan mengajukan ulang atau memperbarui penawaran selama periode pengajuan masih dibuka.</p>

            " . ($dl ? "
            <div style='background:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;padding:14px 16px;margin:20px 0'>
                <p style='margin:0 0 4px;font-size:11px;font-weight:700;color:#1e40af;text-transform:uppercase;letter-spacing:.5px'>
                    Deadline Pengajuan
                </p>
                <p style='margin:0;color:#1e3a8a;font-size:14px'>
                    Penawaran dapat diajukan hingga <strong>{$dl}</strong>.
                </p>
            </div>
            " : "") . "

            <p>Pastikan penawaran terbaik Anda telah dikirim sebelum batas waktu berakhir.</p>

            " . $this->btn('Buka Halaman Penawaran', url('/supplier/quotations'), '#1d4ed8')
        );

        $this->send($toEmail, $toName, $subject, $body);
        $this->log($toEmail, $subject, 'winner_reminder');
    }

    // 9. Batch ditutup otomatis
    public function sendBatchClosed(string $toEmail, string $toName, string $batchTitle, string $batchNumber): void
    {
        $subject = "Pengadaan Ditutup: {$batchTitle}";
        $body    = $this->wrap(
            'Pengadaan Telah Ditutup',
            'Batas waktu pengadaan telah berakhir',
            $this->iconLock(),
            '#4b5563',
            "
            <p>Halo <strong>{$toName}</strong>,</p>
            <p>Pengadaan berikut telah <strong>ditutup</strong> karena telah melewati batas waktu yang ditetapkan:</p>
            " . $this->table([
                ['No. RFQ',  $batchNumber],
                ['Nama RFQ', $batchTitle],
            ]) . "
            <p>Terima kasih atas partisipasi Anda dalam proses pengadaan ini.</p>
            " . $this->infoBox('Jika ada pertanyaan, silakan hubungi tim pengadaan kami.')
        );
        $this->send($toEmail, $toName, $subject, $body);
        $this->log($toEmail, $subject, 'batch_closed');
    }

    // ─── Private helpers ──────────────────────────────────────────────────

    private function table(array $rows): string
    {
        $html = "<table style='width:100%;border-collapse:collapse;margin:20px 0;font-size:14px'>";
        foreach ($rows as $i => [$label, $value]) {
            $bg = $i % 2 === 0 ? '#f8fafc' : '#ffffff';
            $html .= "<tr style='background:{$bg}'>
                <td style='padding:10px 14px;font-weight:600;color:#374151;width:38%;border-bottom:1px solid #e5e7eb'>{$label}</td>
                <td style='padding:10px 14px;color:#111827;border-bottom:1px solid #e5e7eb'>{$value}</td>
            </tr>";
        }
        $html .= "</table>";
        return $html;
    }

    private function btn(string $label, string $url, string $color = '#1d4ed8'): string
    {
        return "<div style='margin:28px 0 8px'>
            <a href='{$url}' style='background:{$color};color:#ffffff;padding:12px 28px;border-radius:8px;
               text-decoration:none;display:inline-block;font-size:14px;font-weight:600;
               letter-spacing:.2px'>{$label}</a>
        </div>";
    }

    private function infoBox(string $msg): string
    {
        return "<div style='background:#f0f9ff;border-left:4px solid #0284c7;padding:12px 16px;
                border-radius:0 6px 6px 0;margin:20px 0;font-size:13px;color:#0c4a6e'>{$msg}</div>";
    }

    // ─── SVG Icons ────────────────────────────────────────────────────────

    private function iconCheck(): string
    {
        return "<svg width='28' height='28' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'><polyline points='20 6 9 17 4 12'/></svg>";
    }

    private function iconShield(): string
    {
        return "<svg width='28' height='28' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z'/></svg>";
    }

    private function iconDoc(): string
    {
        return "<svg width='28' height='28' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z'/><polyline points='14 2 14 8 20 8'/><line x1='16' y1='13' x2='8' y2='13'/><line x1='16' y1='17' x2='8' y2='17'/><polyline points='10 9 9 9 8 9'/></svg>";
    }

    private function iconInbox(): string
    {
        return "<svg width='28' height='28' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polyline points='22 12 16 12 14 15 10 15 8 12 2 12'/><path d='M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z'/></svg>";
    }

    private function iconX(): string
    {
        return "<svg width='28' height='28' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'><line x1='18' y1='6' x2='6' y2='18'/><line x1='6' y1='6' x2='18' y2='18'/></svg>";
    }

    private function iconClock(): string
    {
        return "<svg width='28' height='28' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><circle cx='12' cy='12' r='10'/><polyline points='12 6 12 12 16 14'/></svg>";
    }

    private function iconBell(): string
    {
        return "<svg width='28' height='28' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9'/><path d='M13.73 21a2 2 0 0 1-3.46 0'/></svg>";
    }

    private function iconLock(): string
    {
        return "<svg width='28' height='28' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><rect x='3' y='11' width='18' height='11' rx='2' ry='2'/><path d='M7 11V7a5 5 0 0 1 10 0v4'/></svg>";
    }

    // ─── Master template ──────────────────────────────────────────────────

    private function wrap(string $title, string $subtitle, string $icon, string $accent, string $content): string
    {
        $year    = date('Y');
        $appName = config('app.name', 'E-Quotation System');
        $appUrl  = url('/');

        return "<!DOCTYPE html>
<html lang='id'>
<head>
<meta charset='UTF-8'>
<meta name='viewport' content='width=device-width,initial-scale=1'>
<title>{$title}</title>
</head>
<body style='margin:0;padding:0;background:#f1f5f9;font-family:Arial,Helvetica,sans-serif;color:#1e293b'>

<table width='100%' cellpadding='0' cellspacing='0' style='background:#f1f5f9;padding:40px 16px'>
<tr><td align='center'>

  <!-- Card -->
  <table width='600' cellpadding='0' cellspacing='0' style='max-width:600px;width:100%;background:#ffffff;border-radius:12px;overflow:hidden;border:1px solid #e2e8f0'>

    <!-- Header bar -->
    <tr>
      <td style='background:{$accent};height:4px;font-size:0'>&nbsp;</td>
    </tr>

    <!-- Logo row -->
    <tr>
      <td style='padding:28px 36px 20px;border-bottom:1px solid #f1f5f9'>
        <table width='100%' cellpadding='0' cellspacing='0'>
          <tr>
            <td>
              <!-- Logo mark -->
              <table cellpadding='0' cellspacing='0'>
                <tr>
                  <td style='background:{$accent};width:36px;height:36px;border-radius:8px;text-align:center;vertical-align:middle'>
                    <span style='color:#ffffff;font-size:18px;font-weight:900;line-height:36px;display:block'>E</span>
                  </td>
                  <td style='padding-left:10px;vertical-align:middle'>
                    <p style='margin:0;font-size:15px;font-weight:700;color:#0f172a'>{$appName}</p>
                    <p style='margin:0;font-size:11px;color:#94a3b8;margin-top:1px'>Procurement Management Platform</p>
                  </td>
                </tr>
              </table>
            </td>
            <td align='right' style='vertical-align:middle'>
              <span style='font-size:11px;color:#94a3b8'>{$year}</span>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- Icon + Title block -->
    <tr>
      <td style='padding:32px 36px 0'>
        <table cellpadding='0' cellspacing='0'>
          <tr>
            <td style='background:{$accent}1a;width:52px;height:52px;border-radius:12px;text-align:center;vertical-align:middle;color:{$accent}'>
              {$icon}
            </td>
            <td style='padding-left:16px;vertical-align:middle'>
              <p style='margin:0;font-size:20px;font-weight:700;color:#0f172a'>{$title}</p>
              <p style='margin:4px 0 0;font-size:13px;color:#64748b'>{$subtitle}</p>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- Divider -->
    <tr>
      <td style='padding:20px 36px 0'>
        <div style='height:1px;background:#f1f5f9'></div>
      </td>
    </tr>

    <!-- Body content -->
    <tr>
      <td style='padding:24px 36px 32px;font-size:14px;line-height:1.75;color:#334155'>
        {$content}
      </td>
    </tr>

    <!-- Footer -->
    <tr>
      <td style='background:#f8fafc;border-top:1px solid #e2e8f0;padding:20px 36px'>
        <table width='100%' cellpadding='0' cellspacing='0'>
          <tr>
            <td style='font-size:11px;color:#94a3b8;line-height:1.6'>
              Email ini dikirim otomatis oleh sistem. Mohon tidak membalas email ini.<br>
              &copy; {$year} <a href='{$appUrl}' style='color:{$accent};text-decoration:none'>{$appName}</a>. Seluruh hak dilindungi.
            </td>
            <td align='right' style='vertical-align:top'>
              <div style='background:{$accent};width:6px;height:6px;border-radius:50%;display:inline-block'></div>
              <div style='background:{$accent};opacity:.5;width:6px;height:6px;border-radius:50%;display:inline-block;margin-left:3px'></div>
              <div style='background:{$accent};opacity:.25;width:6px;height:6px;border-radius:50%;display:inline-block;margin-left:3px'></div>
            </td>
          </tr>
        </table>
      </td>
    </tr>

  </table>
  <!-- /Card -->

</td></tr>
</table>

</body>
</html>";
    }

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
}