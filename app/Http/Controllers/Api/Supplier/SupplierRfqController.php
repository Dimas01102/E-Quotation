<?php

namespace App\Http\Controllers\Api\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\InvitedSupplierCategory;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SupplierRfqController extends Controller
{
    public function index()
    {
        $user     = Auth::user();
        $supplier = Supplier::where('user_id', $user->id)->firstOrFail();

        $invitations = InvitedSupplierCategory::with([
            'batchCategory.batch.creator',
            'batchCategory.masterCategory',
            'batchCategory.itemBatchCategories.masterItem',
            'quotations',
        ])
        ->where('id_supplier', $supplier->id)
        ->whereHas('batchCategory.batch', function ($q) {
            $q->where('status', 'open');
        })
        // Hanya tampilkan invitation yang statusnya 'invited' atau 'submitted'
        ->whereIn('status', ['invited', 'submitted'])
        ->orderByDesc('invited_at')
        ->get()
        ->map(function ($inv) {
            $batch    = $inv->batchCategory?->batch;
            $category = $inv->batchCategory?->masterCategory;
            $items    = $inv->batchCategory?->itemBatchCategories;

            $latestQuotation = $inv->quotations
                ->sortByDesc('submitted_at')
                ->first();

            $hasActivePendingQuotation = $inv->quotations
                ->whereIn('status', ['pending', 'submitted'])
                ->isNotEmpty();

            $canSubmit = $batch?->status === 'open'
                && $batch?->deadline
                && Carbon::parse($batch->deadline)->isFuture()
                && !$hasActivePendingQuotation
                && $inv->status === 'invited';

            return [
                'id_invited_supplier' => $inv->id_invited_supplier,
                'id_batch_category'   => $inv->id_batch_category,
                'status'              => $inv->status,
                'invited_at'          => $inv->invited_at,
                'can_submit'          => $canSubmit,
                'has_submitted'       => $hasActivePendingQuotation,
                'batch' => [
                    'id_batch'     => $batch?->id_batch,
                    'batch_number' => $batch?->batch_number,
                    'title'        => $batch?->title,
                    'description'  => $batch?->description,
                    'deadline'     => $batch?->deadline,
                    'status'       => $batch?->status,
                ],
                'category' => [
                    'id_master_category' => $category?->id_master_category,
                    'name'               => $category?->name,
                ],
                'items' => $items?->map(fn($i) => [
                    'id_item'   => $i->masterItem?->id_item,
                    'item_code' => $i->masterItem?->item_code,
                    'item_name' => $i->masterItem?->item_name,
                    'unit'      => $i->masterItem?->unit,
                    'quantity'  => $i->quantity,
                ]),
                'quotation' => $latestQuotation ? [
                    'id_quotation' => $latestQuotation->id_quotation,
                    'status'       => $latestQuotation->status,
                    'total_price'  => $latestQuotation->total_price,
                    'submitted_at' => $latestQuotation->submitted_at,
                ] : null,
            ];
        });

        return response()->json(['success' => true, 'invitations' => $invitations]);
    }

    public function show($id)
    {
        $user     = Auth::user();
        $supplier = Supplier::where('user_id', $user->id)->firstOrFail();

        $invitation = InvitedSupplierCategory::with([
            'batchCategory.batch',
            'batchCategory.masterCategory',
            'batchCategory.itemBatchCategories.masterItem',
            'quotations',
        ])
        ->where('id_invited_supplier', $id)
        ->where('id_supplier', $supplier->id)
        ->firstOrFail();

        return response()->json(['success' => true, 'invitation' => $invitation]);
    }
}