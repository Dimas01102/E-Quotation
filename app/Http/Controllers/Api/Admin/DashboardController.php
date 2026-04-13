<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Quotation;
use App\Models\Supplier;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSuppliers    = Supplier::count();
        $activeSuppliers   = Supplier::whereHas('user', fn($q) => $q->where('is_active', 1))->count();
        $pendingSuppliers  = Supplier::whereHas('user', fn($q) => $q->where('is_active', 0))->count();

        $totalBatches      = Batch::count();
        $openBatches       = Batch::where('status', 'open')->count();
        $draftBatches      = Batch::where('status', 'draft')->count();
        $awardedBatches    = Batch::where('status', 'awarded')->count();

        $totalQuotations   = Quotation::count();
        $pendingQuotations = Quotation::where('status', 'pending')->count();
        $approvedQuotations = Quotation::where('status', 'approved')->count();

        // Recent batches (5 terbaru)
        $recentBatches = Batch::with('creator')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        // Recent quotations pending (5 terbaru)
        $recentQuotations = Quotation::with([
            'invitedSupplier.supplier',
            'invitedSupplier.batchCategory.batch',
        ])
            ->where('status', 'pending')
            ->orderByDesc('submitted_at')
            ->limit(5)
            ->get()
            ->map(fn($q) => [
                'id_quotation'  => $q->id_quotation,
                'company_name'  => $q->invitedSupplier?->supplier?->company_name,
                'batch_title'   => $q->invitedSupplier?->batchCategory?->batch?->title,
                'total_price'   => $q->total_price,
                'submitted_at'  => $q->submitted_at,
                'status'        => $q->status,
            ]);

        return response()->json([
            // Struktur sesuai yang dibaca di dashboard.blade.php
            'suppliers' => [
                'total'   => $totalSuppliers,
                'active'  => $activeSuppliers,
                'pending' => $pendingSuppliers,
            ],
            'batches' => [
                'total'   => $totalBatches,
                'open'    => $openBatches,
                'draft'   => $draftBatches,
                'awarded' => $awardedBatches,
            ],
            'quotations' => [
                'total'    => $totalQuotations,
                'pending'  => $pendingQuotations,
                'approved' => $approvedQuotations,
            ],
            'recent_batches'    => $recentBatches,
            'recent_quotations' => $recentQuotations,
        ]);
    }
}
