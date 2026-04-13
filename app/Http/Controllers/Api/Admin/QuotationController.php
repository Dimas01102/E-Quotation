<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quotation;
use App\Services\MailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Dompdf\Dompdf;
use Dompdf\Options;

class QuotationController extends Controller
{
    public function index()
    {
        $quotations = Quotation::with([
            'invitedSupplier.supplier.user',
            'invitedSupplier.batchCategory.batch',
            'invitedSupplier.batchCategory.masterCategory',
        ])->orderByDesc('submitted_at')->get();

        return response()->json(['success' => true, 'quotations' => $quotations]);
    }

    /**
     * Detail quotation — load semua 17 kolom dari quotationItems (sesuai file Excel)
     */
    public function show($id)
    {
        $quotation = Quotation::with([
            'invitedSupplier.supplier.user',
            'invitedSupplier.batchCategory.batch',
            'invitedSupplier.batchCategory.masterCategory',
            'quotationItems', 
        ])->findOrFail($id);

        // Url file excel
        $data = $quotation->toArray();
        $data['file_url'] = $quotation->file_path ? Storage::url($quotation->file_path) : null;
        $data['po_url']   = $quotation->po_file_path ? Storage::url($quotation->po_file_path) : null;

        return response()->json(['success' => true, 'quotation' => $data]);
    }

    // compare
    public function compare($batchId)
    {
        $quotations = Quotation::with([
            'invitedSupplier.supplier.user',
            'invitedSupplier.batchCategory.masterCategory',
            'quotationItems',
        ])
            ->whereHas(
                'invitedSupplier',
                fn($q) =>
                $q->whereHas('batchCategory', fn($q2) => $q2->where('id_batch', $batchId))
            )
            ->orderBy('total_price')
            ->get()
            ->map(function ($q) {
                $data = $q->toArray();
                $data['file_url'] = $q->file_path ? Storage::url($q->file_path) : null;
                return $data;
            });

        return response()->json(['success' => true, 'quotations' => $quotations]);
    }

    public function approve(Request $request, $id)
    {
        $quotation = Quotation::with([
            'invitedSupplier.supplier.user',
            'invitedSupplier.batchCategory.batch.creator',
            'invitedSupplier.batchCategory.masterCategory',
            'quotationItems',
        ])->findOrFail($id);

        if ($quotation->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Hanya penawaran pending yang bisa di-approve.'], 422);
        }

        $poFilePath = $this->generatePoPdf($quotation);

        $quotation->update([
            'status'       => 'approved',
            'note'         => $request->note ?? null,
            'po_file_path' => $poFilePath,
        ]);

        // Auto-reject lainnya di batch_category yang sama
        Quotation::where('id_quotation', '!=', $id)
            ->where('status', 'pending')
            ->whereHas(
                'invitedSupplier',
                fn($q) =>
                $q->where('id_batch_category', $quotation->invitedSupplier->id_batch_category)
            )
            ->update(['status' => 'rejected', 'note' => 'Penawaran lain telah dipilih.']);

        // Batch → closed setelah ada pemenang
        $batch = $quotation->invitedSupplier?->batchCategory?->batch;
        if ($batch) $batch->update(['status' => 'closed']);

        // Email ke supplier pemenang
        try {
            $supplier = $quotation->invitedSupplier?->supplier;
            if ($supplier?->user) {
                (new MailService())->sendQuotationApproved(
                    $supplier->user->email,
                    $supplier->user->name,
                    $batch?->title ?? ''
                );
            }
        } catch (\Exception $e) {
            Log::warning('Email approve gagal: ' . $e->getMessage());
        }

        return response()->json([
            'success'  => true,
            'message'  => 'Penawaran disetujui & PO digenerate.',
            'po_url'   => $poFilePath ? Storage::url($poFilePath) : null,
        ]);
    }

    public function reject(Request $request, $id)
    {
        $request->validate(['note' => 'required|string']);

        $quotation = Quotation::with([
            'invitedSupplier.supplier.user',
            'invitedSupplier.batchCategory.batch',
        ])->findOrFail($id);

        if ($quotation->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Hanya pending yang bisa ditolak.'], 422);
        }

        $quotation->update(['status' => 'rejected', 'note' => $request->note]);

        try {
            $supplier = $quotation->invitedSupplier?->supplier;
            if ($supplier?->user) {
                (new MailService())->sendQuotationRejected(
                    $supplier->user->email,
                    $supplier->user->name,
                    $quotation->invitedSupplier?->batchCategory?->batch?->title ?? '',
                    $request->note
                );
            }
        } catch (\Exception $e) {
            Log::warning('Email reject gagal: ' . $e->getMessage());
        }

        return response()->json(['success' => true, 'message' => 'Penawaran ditolak.']);
    }

    private function generatePoPdf(Quotation $q): ?string
    {
        try {
            $supplier = $q->invitedSupplier?->supplier;
            $user     = $supplier?->user;
            $batch    = $q->invitedSupplier?->batchCategory?->batch;
            $cat      = $q->invitedSupplier?->batchCategory?->masterCategory;
            $creator  = $batch?->creator;
            $items    = $q->quotationItems ?? collect();
            $today    = date('d F Y');
            $poNo     = 'PO-' . date('Ymd') . '-' . str_pad($q->id_quotation, 4, '0', STR_PAD_LEFT);

            $opts = new Options();
            $opts->set('defaultFont', 'DejaVu Sans');
            $opts->set('isRemoteEnabled', false);

            $dompdf = new Dompdf($opts);
            $dompdf->loadHtml($this->buildPo($q, $poNo, $today, $supplier, $user, $batch, $cat, $creator, $items));
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();

            $path = 'po/po_' . $q->id_quotation . '_' . time() . '.pdf';
            Storage::disk('public')->put($path, $dompdf->output());

            return $path;
        } catch (\Exception $e) {
            Log::error('Generate PO gagal: ' . $e->getMessage());
            return null;
        }
    }

    private function buildPo($q, $poNo, $today, $supplier, $user, $batch, $cat, $creator, $items): string
    {
        $rows = '';
        if ($items && count($items)) {
            foreach ($items as $i => $item) {
                $rows .= "<tr>
                    <td style='padding:4px 6px;border-bottom:1px solid #e5e7eb;text-align:center'>" . ($i + 1) . "</td>
                    <td style='padding:4px 6px;border-bottom:1px solid #e5e7eb'>" . e($item->coll_no ?? '-') . "</td>
                    <td style='padding:4px 6px;border-bottom:1px solid #e5e7eb'>" . e($item->rfq_no ?? '-') . "</td>
                    <td style='padding:4px 6px;border-bottom:1px solid #e5e7eb'>" . e($item->vendor ?? '-') . "</td>
                    <td style='padding:4px 6px;border-bottom:1px solid #e5e7eb'>" . e($item->no_item ?? '-') . "</td>
                    <td style='padding:4px 6px;border-bottom:1px solid #e5e7eb'>" . e($item->material_no ?? '-') . "</td>
                    <td style='padding:4px 6px;border-bottom:1px solid #e5e7eb'>" . e($item->description ?? '-') . "</td>
                    <td style='padding:4px 6px;border-bottom:1px solid #e5e7eb;text-align:center'>" . ($item->qty ?? 0) . "</td>
                    <td style='padding:4px 6px;border-bottom:1px solid #e5e7eb;text-align:center'>" . e($item->uom ?? '') . "</td>
                    <td style='padding:4px 6px;border-bottom:1px solid #e5e7eb;text-align:center'>" . e($item->currency ?? '') . "</td>
                    <td style='padding:4px 6px;border-bottom:1px solid #e5e7eb;text-align:right'>" . number_format($item->net_price ?? 0, 2) . "</td>
                    <td style='padding:4px 6px;border-bottom:1px solid #e5e7eb'>" . e($item->incoterm ?? '-') . "</td>
                    <td style='padding:4px 6px;border-bottom:1px solid #e5e7eb'>" . e($item->destination ?? '-') . "</td>
                    <td style='padding:4px 6px;border-bottom:1px solid #e5e7eb'>" . e($item->remark_1 ?? '-') . "</td>
                    <td style='padding:4px 6px;border-bottom:1px solid #e5e7eb'>" . e($item->remark_2 ?? '-') . "</td>
                    <td style='padding:4px 6px;border-bottom:1px solid #e5e7eb;text-align:center'>" . e($item->lead_time_weeks ?? '-') . "</td>
                    <td style='padding:4px 6px;border-bottom:1px solid #e5e7eb'>" . e($item->payment_term ?? '-') . "</td>
                    <td style='padding:4px 6px;border-bottom:1px solid #e5e7eb'>" . e($item->quotation_date ?? '-') . "</td>
                </tr>";
            }
        } else {
            $rows = "<tr><td colspan='18' style='padding:8px;text-align:center;color:#6b7280'>File: " . e($q->file_name ?? 'Terlampir') . "</td></tr>";
        }

        return "<!DOCTYPE html><html><head><meta charset='UTF-8'>
<style>body{font-family:'DejaVu Sans',sans-serif;font-size:8px;color:#111;padding:16px}
.hdr{border-bottom:3px solid #1e40af;padding-bottom:10px;margin-bottom:14px;display:table;width:100%}
.hl{display:table-cell;vertical-align:top}.hr{display:table-cell;vertical-align:top;text-align:right}
.cn{font-size:16px;font-weight:bold;color:#1e40af}.pt{font-size:18px;font-weight:bold;color:#1e40af}
.grid{display:table;width:100%;margin-bottom:12px}
.gc{display:table-cell;width:50%;vertical-align:top;padding-right:10px}
.st{font-size:7px;font-weight:bold;color:#6b7280;text-transform:uppercase;margin-bottom:4px}
.ir{margin-bottom:2px}.il{color:#6b7280}.iv{font-weight:600}
table.items{width:100%;border-collapse:collapse;font-size:7px}
table.items thead{background:#1e40af;color:#fff}
table.items th{padding:4px 6px;text-align:left;white-space:nowrap}
.tr td{font-weight:bold;background:#eff6ff;border-top:2px solid #1e40af}
.ft{display:table;width:100%;margin-top:16px}
.fc{display:table-cell;width:50%;text-align:center;padding:0 20px}
.sl{border-top:1px solid #9ca3af;margin-top:36px;padding-top:4px;font-size:7px}
.ff{text-align:center;margin-top:14px;color:#9ca3af;font-size:6px;border-top:1px solid #e5e7eb;padding-top:6px}
</style></head><body>
<div class='hdr'>
  <div class='hl'><div class='cn'>E-Quotation System</div><p style='color:#6b7280;margin:2px 0;font-size:7px'>Procurement Dept</p></div>
  <div class='hr'><div class='pt'>PURCHASE ORDER</div><div style='color:#6b7280;margin-top:2px'>{$poNo}</div>
    <div style='margin-top:4px;background:#dcfce7;color:#166534;padding:2px 8px;border-radius:16px;font-size:7px;font-weight:bold;display:inline-block'>APPROVED</div>
  </div>
</div>
<div class='grid'>
  <div class='gc'><div class='st'>Informasi PO</div>
    <div class='ir'><span class='il'>Tanggal: </span><span class='iv'>{$today}</span></div>
    <div class='ir'><span class='il'>No. RFQ: </span><span class='iv'>" . e($batch?->batch_number ?? '-') . "</span></div>
    <div class='ir'><span class='il'>RFQ: </span><span class='iv'>" . e($batch?->title ?? '-') . "</span></div>
    <div class='ir'><span class='il'>Kategori: </span><span class='iv'>" . e($cat?->name ?? '-') . "</span></div>
  </div>
  <div class='gc'><div class='st'>Supplier</div>
    <div class='ir'><span class='il'>Perusahaan: </span><span class='iv'>" . e($supplier?->company_name ?? '-') . "</span></div>
    <div class='ir'><span class='il'>PIC: </span><span class='iv'>" . e($user?->name ?? '-') . "</span></div>
    <div class='ir'><span class='il'>Email: </span><span class='iv'>" . e($user?->email ?? '-') . "</span></div>
    <div class='ir'><span class='il'>Telepon: </span><span class='iv'>" . e($supplier?->phone ?? '-') . "</span></div>
  </div>
</div>
<div class='st'>Detail Item (sesuai file Excel)</div>
<table class='items'>
  <thead><tr>
    <th>#</th><th>Coll No.</th><th>RFQ No.</th><th>Vendor</th><th>No. Item</th>
    <th>Material No.</th><th>Description</th><th>Qty</th><th>UoM</th><th>Currency</th>
    <th>Net Price</th><th>Incoterm</th><th>Destination</th><th>Remark 1</th><th>Remark 2</th>
    <th>Lead Time(Weeks)</th><th>Payment Term</th><th>Quotation Date</th>
  </tr></thead>
  <tbody>{$rows}
    <tr class='tr'><td colspan='10' style='padding:5px 6px'><strong>TOTAL</strong></td>
      <td colspan='8' style='padding:5px 6px'><strong>Rp " . number_format($q->total_price ?? 0, 0, ',', '.') . "</strong></td></tr>
  </tbody>
</table>
" . ($q->note ? "<div style='background:#f0f9ff;border-left:3px solid #1e40af;padding:6px;margin-top:8px;font-size:7px'><b>Catatan:</b> " . e($q->note) . "</div>" : "") . "
<div class='ft'>
  <div class='fc'><p style='font-size:7px;color:#6b7280'>Disetujui:</p><div class='sl'>" . e($creator?->name ?? 'Admin') . "<br><span style='color:#6b7280'>Admin Procurement</span></div></div>
  <div class='fc'><p style='font-size:7px;color:#6b7280'>Diterima:</p><div class='sl'>" . e($user?->name ?? '-') . "<br><span style='color:#6b7280'>" . e($supplier?->company_name ?? '-') . "</span></div></div>
</div>
<div class='ff'>E-Quotation System — {$today}</div>
</body></html>";
    }
}