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

            // Cek apakah ada quotation pending/submitted (bukan approved)
            $hasActivePendingQuotation = $inv->quotations
                ->whereIn('status', ['pending', 'submitted'])
                ->isNotEmpty();

            // Apakah supplier ini adalah pemenang (ada quotation approved)?
            $isWinner = $inv->quotations
                ->where('status', 'approved')
                ->isNotEmpty();

            // Deadline masih valid selama belum lewat akhir hari (timezone Jakarta)
            $deadlineIsFuture = $batch?->deadline
                && Carbon::parse($batch->deadline)
                ->timezone('Asia/Jakarta')
                ->endOfDay()
                ->isFuture();

            /*
             * can_submit = true jika:
             * - Batch status 'open'
             * - Deadline belum lewat
             * - Tidak ada quotation pending/submitted aktif
             * - Status invitation adalah 'invited'
             *
             * Untuk pemenang (winner) yang batch-nya di-reopen:
             * - Admin sudah reset status invitation kembali ke 'invited'
             * - Quotation approved sebelumnya TIDAK menghalangi submit ulang
             * - Jadi logika can_submit di atas sudah cukup untuk menangani winner
             */
            $canSubmit = $batch?->status === 'open'
                && $deadlineIsFuture
                && !$hasActivePendingQuotation
                && $inv->status === 'invited';

            return [
                'id_invited_supplier' => $inv->id_invited_supplier,
                'id_batch_category'   => $inv->id_batch_category,
                'status'              => $inv->status,
                'invited_at'          => $inv->invited_at,
                'can_submit'          => $canSubmit,
                'has_submitted'       => $hasActivePendingQuotation,
                'is_winner'           => $isWinner,        // baru: flag pemenang untuk frontend
                'deadline_passed'     => !$deadlineIsFuture, // baru: flag deadline untuk frontend
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
                /*
                 * Untuk quotation yang ditampilkan di card:
                 * - Jika winner (is_winner=true) dan can_submit=true → tampilkan null
                 *   supaya frontend tahu bahwa winner perlu submit ulang (ada approved sebelumnya
                 *   tapi sekarang batch di-reopen)
                 * - Selain itu → tampilkan quotation terakhir seperti biasa
                 */
                'quotation' => ($isWinner && $canSubmit) ? null : ($latestQuotation ? [
                    'id_quotation' => $latestQuotation->id_quotation,
                    'status'       => $latestQuotation->status,
                    'total_price'  => $latestQuotation->total_price,
                    'submitted_at' => $latestQuotation->submitted_at,
                ] : null),
                // Quotation terakhir (selalu ada, untuk referensi di modal detail)
                'latest_quotation' => $latestQuotation ? [
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