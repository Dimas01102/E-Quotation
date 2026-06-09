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

        // ── Siapkan variabel untuk Blade template ──────────────────────
        $supplier = $quotation->invitedSupplier->supplier ?? null;
        $user     = $supplier?->user ?? null;
        $batch    = $quotation->invitedSupplier->batchCategory->batch ?? null;
        $category = $quotation->invitedSupplier->batchCategory->masterCategory ?? null;
        $creator  = $batch?->creator ?? null;

        $poNumber = 'PO-' . date('Ymd', strtotime($quotation->submitted_at ?? now()))
            . '-' . str_pad($quotation->id_quotation, 4, '0', STR_PAD_LEFT);
        $today    = date('d F Y');
        $items    = collect(); // isi dari relasi items jika tersedia

        // ── Render Blade template ke HTML ──────────────────────────────
        $html = view('purchase-order', compact(
            'quotation',
            'supplier',
            'user',
            'batch',
            'category',
            'creator',
            'poNumber',
            'today',
            'items'
        ))->render();

        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $poNumber  = 'PO-' . date('Ymd') . '-' . strtoupper(Str::random(6));
        $fileName  = 'po_' . $quotation->id_quotation . '_' . time() . '.pdf';
        $filePath  = 'po/' . $fileName;

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
}
