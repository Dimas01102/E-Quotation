<?php

namespace App\Http\Controllers\Api\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Supplier;
use App\Models\InvitedSupplierCategory;
use App\Models\Quotation;

class SupplierDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user     = Auth::user();
        $supplier = Supplier::where('user_id', $user->id)->with('user')->first();

        if (!$supplier) {
            return response()->json(['message' => 'Profil supplier tidak ditemukan.'], 404);
        }

        // Stats
        $invitations = InvitedSupplierCategory::where('id_supplier', $supplier->id)->count();
        $submitted   = Quotation::whereHas('invitedSupplier', fn($q) => $q->where('id_supplier', $supplier->id))->count();
        $approved    = Quotation::whereHas('invitedSupplier', fn($q) => $q->where('id_supplier', $supplier->id))->where('status', 'approved')->count();
        $po          = Quotation::whereHas('invitedSupplier', fn($q) => $q->where('id_supplier', $supplier->id))->whereNotNull('po_file_path')->count();

        // Recent invitations
        $recentInvitations = InvitedSupplierCategory::with([
            'batchCategory.batch',
        ])
        ->where('id_supplier', $supplier->id)
        ->orderByDesc('invited_at')
        ->limit(5)
        ->get()
        ->map(fn($inv) => [
            'id'     => $inv->id_invited_supplier,
            'status' => $inv->status,
            'batch'  => [
                'title'        => $inv->batchCategory?->batch?->title,
                'batch_number' => $inv->batchCategory?->batch?->batch_number,
                'deadline'     => $inv->batchCategory?->batch?->deadline,
            ],
            'invited_at' => $inv->invited_at,
        ]);

        // Recent quotations
        $recentQuotations = Quotation::with([
            'invitedSupplier.batchCategory.batch',
        ])
        ->whereHas('invitedSupplier', fn($q) => $q->where('id_supplier', $supplier->id))
        ->orderByDesc('submitted_at')
        ->limit(5)
        ->get()
        ->map(fn($q) => [
            'id_quotation'  => $q->id_quotation,
            'total_price'   => $q->total_price,
            'status'        => $q->status,
            'batch_title'   => $q->invitedSupplier?->batchCategory?->batch?->title,
            'batch_number'  => $q->invitedSupplier?->batchCategory?->batch?->batch_number,
            'submitted_at'  => $q->submitted_at,
        ]);

        return response()->json([
            'company_name'       => $supplier->company_name,
            'is_active'          => $user->is_active,
            'stats' => [
                'invitations' => $invitations,
                'submitted'   => $submitted,
                'approved'    => $approved,
                'po'          => $po,
            ],
            'recent_invitations' => $recentInvitations,
            'recent_quotations'  => $recentQuotations,
        ]);
    }
}