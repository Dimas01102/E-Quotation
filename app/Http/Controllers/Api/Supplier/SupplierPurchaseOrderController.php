<?php

namespace App\Http\Controllers\Api\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Quotation;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SupplierPurchaseOrderController extends Controller
{
    // ─── LIST semua PO milik supplier (quotation approved + po_file_path) ─
    public function index()
    {
        $user     = Auth::user();
        $supplier = Supplier::where('user_id', $user->id)->firstOrFail();

        $pos = Quotation::with([
            'invitedSupplier.batchCategory.batch',
            'invitedSupplier.batchCategory.masterCategory',
        ])
        ->whereHas('invitedSupplier', fn($q) => $q->where('id_supplier', $supplier->id))
        ->where('status', 'approved')
        ->whereNotNull('po_file_path')
        ->orderByDesc('updated_at')
        ->get()
        ->map(fn($q) => [
            'id_quotation'  => $q->id_quotation,
            'batch_title'   => $q->invitedSupplier?->batchCategory?->batch?->title,
            'batch_number'  => $q->invitedSupplier?->batchCategory?->batch?->batch_number,
            'category_name' => $q->invitedSupplier?->batchCategory?->masterCategory?->name,
            'total_price'   => $q->total_price,
            'note'          => $q->note,
            'po_file_path'  => $q->po_file_path,
            'po_url'        => Storage::url($q->po_file_path),
            'updated_at'    => $q->updated_at,
        ]);

        return response()->json(['purchase_orders' => $pos]);
    }

    // ─── DOWNLOAD PO PDF ──────────────────────────────────────────────
    public function download($id)
    {
        $user     = Auth::user();
        $supplier = Supplier::where('user_id', $user->id)->firstOrFail();

        $quotation = Quotation::whereHas('invitedSupplier', fn($q) => $q->where('id_supplier', $supplier->id))
            ->where('status', 'approved')
            ->findOrFail($id);

        if (!$quotation->po_file_path || !Storage::disk('public')->exists($quotation->po_file_path)) {
            return response()->json(['message' => 'File PO tidak tersedia.'], 404);
        }

        return response()->download(
            storage_path('app/public/' . $quotation->po_file_path),
            'PO_' . $quotation->id_quotation . '.pdf'
        );
    }
}