<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Dompdf\Dompdf;
use Dompdf\Options;

class PurchaseOrderController extends Controller
{
    /**
     * Generate PO PDF untuk quotation yang diapprove
     */
    public function generate($quotationId)
    {
        $quotation = Quotation::with([
            'invitedSupplier.supplier.user',
            'invitedSupplier.batchCategory.batch.creator',
            'invitedSupplier.batchCategory.masterCategory',
        ])->findOrFail($quotationId);

        if ($quotation->status !== 'approved') {
            return response()->json(['message' => 'Hanya quotation yang diapprove yang bisa di-generate PO.'], 422);
        }

        $html = $this->buildPoHtml($quotation);

        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $poNumber = 'PO-' . date('Ymd') . '-' . strtoupper(Str::random(6));
        $fileName = 'po_' . $quotation->id_quotation . '_' . time() . '.pdf';
        $filePath = 'po/' . $fileName;

        Storage::disk('public')->put($filePath, $dompdf->output());

        $quotation->update([
            'po_file_path' => $filePath,
        ]);

        return response()->json([
            'message'   => 'PO berhasil digenerate.',
            'po_number' => $poNumber,
            'file_path' => $filePath,
            'url'       => Storage::url($filePath),
        ]);
    }

    /**
     * Download PO PDF
     */
    public function download($quotationId)
    {
        $quotation = Quotation::findOrFail($quotationId);

        if (!$quotation->po_file_path || !Storage::disk('public')->exists($quotation->po_file_path)) {
            return response()->json(['message' => 'File PO tidak ditemukan.'], 404);
        }

        return response()->download(storage_path('app/public/' . $quotation->po_file_path));
    }

    private function buildPoHtml(Quotation $q): string
    {
        $supplier = $q->invitedSupplier->supplier ?? null;
        $user = $supplier?->user ?? null;
        $batch = $q->invitedSupplier->batchCategory->batch ?? null;
        $category = $q->invitedSupplier->batchCategory->masterCategory ?? null;
        $creator = $batch?->creator ?? null;

        $poNumber = 'PO-' . date('Ymd', strtotime($q->submitted_at ?? now())) . '-' . str_pad($q->id_quotation, 4, '0', STR_PAD_LEFT);
        $today = date('d F Y');

        return "
<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8'>
<style>
    body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #1a1a1a; margin: 0; padding: 20px; }
    .header { display: flex; justify-content: space-between; border-bottom: 3px solid #1e40af; padding-bottom: 15px; margin-bottom: 20px; }
    .company-name { font-size: 20px; font-weight: bold; color: #1e40af; }
    .po-title { font-size: 24px; font-weight: bold; color: #1e40af; text-align: right; }
    .po-number { font-size: 13px; color: #6b7280; text-align: right; margin-top: 4px; }
    .section { margin-bottom: 20px; }
    .section-title { font-size: 11px; font-weight: bold; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px; }
    .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
    .info-block p { margin: 3px 0; }
    .info-block .label { color: #6b7280; }
    .info-block .value { font-weight: 600; color: #111; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    thead { background-color: #1e40af; color: white; }
    th { padding: 8px 10px; text-align: left; font-size: 10px; text-transform: uppercase; letter-spacing: 0.05em; }
    td { padding: 8px 10px; border-bottom: 1px solid #e5e7eb; }
    tr:nth-child(even) td { background-color: #f9fafb; }
    .total-row td { font-weight: bold; background-color: #eff6ff; border-top: 2px solid #1e40af; }
    .footer { margin-top: 30px; display: grid; grid-template-columns: 1fr 1fr; gap: 40px; }
    .sign-block { text-align: center; }
    .sign-line { border-top: 1px solid #9ca3af; margin-top: 50px; padding-top: 8px; font-size: 11px; color: #374151; }
    .badge { display: inline-block; background: #dcfce7; color: #166534; padding: 3px 10px; border-radius: 20px; font-size: 10px; font-weight: bold; }
    .notes { background: #f0f9ff; border-left: 3px solid #1e40af; padding: 10px; border-radius: 4px; font-size: 10px; color: #374151; }
</style>
</head>
<body>
    <div class='header'>
        <div>
            <div class='company-name'>E-Quotation System</div>
            <p style='color:#6b7280; margin:4px 0 0;'>Procurement Department</p>
        </div>
        <div>
            <div class='po-title'>PURCHASE ORDER</div>
            <div class='po-number'>{$poNumber}</div>
            <div style='text-align:right; margin-top:4px;'><span class='badge'>APPROVED</span></div>
        </div>
    </div>

    <div class='section'>
        <div class='info-grid'>
            <div class='info-block'>
                <div class='section-title'>Informasi PO</div>
                <p><span class='label'>Tanggal PO:</span> <span class='value'>{$today}</span></p>
                <p><span class='label'>No. Batch:</span> <span class='value'>" . ($batch?->batch_number ?? '-') . "</span></p>
                <p><span class='label'>Judul RFQ:</span> <span class='value'>" . ($batch?->title ?? '-') . "</span></p>
                <p><span class='label'>Kategori:</span> <span class='value'>" . ($category?->name ?? '-') . "</span></p>
            </div>
            <div class='info-block'>
                <div class='section-title'>Supplier / Vendor</div>
                <p><span class='label'>Perusahaan:</span> <span class='value'>" . ($supplier?->company_name ?? '-') . "</span></p>
                <p><span class='label'>PIC:</span> <span class='value'>" . ($user?->name ?? '-') . "</span></p>
                <p><span class='label'>Email:</span> <span class='value'>" . ($user?->email ?? '-') . "</span></p>
                <p><span class='label'>Telepon:</span> <span class='value'>" . ($supplier?->phone ?? '-') . "</span></p>
                <p><span class='label'>NPWP:</span> <span class='value'>" . ($supplier?->npwp ?? '-') . "</span></p>
            </div>
        </div>
    </div>

    <div class='section'>
        <div class='section-title'>Detail Penawaran</div>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Keterangan</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>File Penawaran</td>
                    <td>" . ($q->file_name ?? 'Terlampir') . "</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Tanggal Submit</td>
                    <td>" . ($q->submitted_at ? date('d F Y', strtotime($q->submitted_at)) : '-') . "</td>
                </tr>
                <tr class='total-row'>
                    <td colspan='2'><strong>TOTAL NILAI PENAWARAN</strong></td>
                    <td><strong>Rp " . number_format($q->total_price ?? 0, 0, ',', '.') . "</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    " . ($q->note ? "<div class='section'><div class='section-title'>Catatan</div><div class='notes'>{$q->note}</div></div>" : "") . "

    <div class='footer'>
        <div class='sign-block'>
            <p style='font-size:11px; color:#6b7280; margin-bottom: 0;'>Disetujui oleh:</p>
            <div class='sign-line'>" . ($creator?->name ?? 'Admin') . "<br><span style='color:#6b7280;'>Admin Procurement</span></div>
        </div>
        <div class='sign-block'>
            <p style='font-size:11px; color:#6b7280; margin-bottom: 0;'>Diterima oleh:</p>
            <div class='sign-line'>" . ($user?->name ?? 'Supplier') . "<br><span style='color:#6b7280;'>" . ($supplier?->company_name ?? 'Supplier') . "</span></div>
        </div>
    </div>

    <div style='text-align:center; margin-top:25px; color:#9ca3af; font-size:9px; border-top:1px solid #e5e7eb; padding-top:10px;'>
        Dokumen ini digenerate secara otomatis oleh sistem E-Quotation pada {$today}. Dokumen sah tanpa tanda tangan basah.
    </div>
</body>
</html>";
    }
}