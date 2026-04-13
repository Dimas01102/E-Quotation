<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Quotation;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Dompdf\Dompdf;
use Dompdf\Options;

class ReportController extends Controller
{
    public function index()
    {
        return response()->json([
            'success'                => true,
            'total_batches'          => Batch::count(),
            'total_approved'         => Quotation::where('status', 'approved')->count(),
            'total_pending'          => Quotation::where('status', 'pending')->count(),
            'total_rejected'         => Quotation::where('status', 'rejected')->count(),
            'total_active_suppliers' => Supplier::whereHas('user', fn($q) => $q->where('is_active', 1))->count(),
            'batch_by_status'        => Batch::select('status', DB::raw('count(*) as count'))->groupBy('status')->get(),
            'top_suppliers'          => $this->topSuppliers(),
            'recent_approved'        => $this->recentApproved(),
        ]);
    }

    // Export PDF laporan
    public function exportPdf()
    {
        $data = [
            'total_batches'          => Batch::count(),
            'total_approved'         => Quotation::where('status', 'approved')->count(),
            'total_pending'          => Quotation::where('status', 'pending')->count(),
            'total_active_suppliers' => Supplier::whereHas('user', fn($q) => $q->where('is_active', 1))->count(),
            'recent_approved'        => $this->recentApproved(),
            'today'                  => date('d F Y'),
        ];

        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($this->buildReportHtml($data));
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return response($dompdf->output(), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="laporan-' . date('Ymd') . '.pdf"',
        ]);
    }

    private function topSuppliers()
    {
        return Supplier::select('suppliers.id', 'suppliers.company_name')
            ->selectRaw('COUNT(quotations.id_quotation) as quotation_count')
            ->selectRaw('SUM(CASE WHEN quotations.status = "approved" THEN 1 ELSE 0 END) as approved_count')
            ->leftJoin('invited_supplier_categories', 'suppliers.id', '=', 'invited_supplier_categories.id_supplier')
            ->leftJoin('quotations', 'invited_supplier_categories.id_invited_supplier', '=', 'quotations.id_invited_supplier')
            ->groupBy('suppliers.id', 'suppliers.company_name')
            ->orderByDesc('quotation_count')
            ->limit(5)
            ->get();
    }

    private function recentApproved()
    {
        return Quotation::with([
            'invitedSupplier.supplier',
            'invitedSupplier.batchCategory.batch',
        ])
            ->where('status', 'approved')
            ->orderByDesc('updated_at')
            ->limit(10)
            ->get()
            ->map(fn($q) => [
                'id_quotation'  => $q->id_quotation,
                'batch_number'  => $q->invitedSupplier?->batchCategory?->batch?->batch_number,
                'batch_title'   => $q->invitedSupplier?->batchCategory?->batch?->title,
                'company_name'  => $q->invitedSupplier?->supplier?->company_name,
                'total_price'   => $q->total_price,
                'po_file_path'  => $q->po_file_path,
                'updated_at'    => $q->updated_at,
            ]);
    }

    private function buildReportHtml(array $d): string
    {
        $rows = collect($d['recent_approved'])->map(
            fn($q, $i) =>
            "<tr><td>" . ($i + 1) . "</td>
             <td>" . e($q['batch_title'] ?? '-') . "</td>
             <td>" . e($q['company_name'] ?? '-') . "</td>
             <td>Rp " . number_format($q['total_price'] ?? 0, 0, ',', '.') . "</td>
             <td>" . ($q['updated_at'] ? date('d/m/Y', strtotime($q['updated_at'])) : '-') . "</td>
             </tr>"
        )->join('');

        return "<!DOCTYPE html><html><head><meta charset='UTF-8'>
<style>
body{font-family:'DejaVu Sans',sans-serif;font-size:11px;padding:24px;color:#111}
h1{color:#1e40af;margin-bottom:4px}
.meta{color:#6b7280;font-size:10px;margin-bottom:20px}
.stat-grid{display:table;width:100%;margin-bottom:20px}
.stat{display:table-cell;padding:12px;background:#f0f9ff;border:1px solid #bfdbfe;text-align:center;width:25%}
.stat-num{font-size:22px;font-weight:bold;color:#1e40af}
.stat-lbl{font-size:9px;color:#6b7280;margin-top:4px}
table{width:100%;border-collapse:collapse;font-size:10px}
thead{background:#1e40af;color:white}
th{padding:6px 8px;text-align:left}
td{padding:6px 8px;border-bottom:1px solid #e5e7eb}
tr:nth-child(even) td{background:#f9fafb}
.footer{margin-top:24px;text-align:center;color:#9ca3af;font-size:9px}
</style></head><body>
<h1>Laporan E-Quotation System</h1>
<div class='meta'>Digenerate: {$d['today']}</div>
<div class='stat-grid'>
  <div class='stat'><div class='stat-num'>{$d['total_batches']}</div><div class='stat-lbl'>Total Batch RFQ</div></div>
  <div class='stat'><div class='stat-num'>{$d['total_approved']}</div><div class='stat-lbl'>Penawaran Disetujui</div></div>
  <div class='stat'><div class='stat-num'>{$d['total_pending']}</div><div class='stat-lbl'>Penawaran Pending</div></div>
  <div class='stat'><div class='stat-num'>{$d['total_active_suppliers']}</div><div class='stat-lbl'>Supplier Aktif</div></div>
</div>
<h3 style='margin-bottom:10px;color:#374151'>Penawaran Disetujui Terbaru</h3>
<table>
<thead><tr><th>#</th><th>Batch RFQ</th><th>Supplier</th><th>Total Harga</th><th>Tgl Approve</th></tr></thead>
<tbody>{$rows}</tbody>
</table>
<div class='footer'>E-Quotation System — {$d['today']}</div>
</body></html>";
    }
}
