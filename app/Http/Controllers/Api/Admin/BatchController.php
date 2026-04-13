<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\BatchCategory;
use App\Models\ItemBatchCategory;
use App\Models\InvitedSupplierCategory;
use App\Models\Quotation;
use App\Models\Supplier;
use App\Services\MailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BatchController extends Controller
{
    public function index()
    {
        $batches = Batch::with('creator')
            ->withCount('batchCategories as category_count')
            ->orderByDesc('created_at')
            ->get();

        return response()->json(['success' => true, 'batches' => $batches]);
    }

    public function show($id)
    {
        $batch = Batch::with([
            'creator',
            'batchCategories.masterCategory',
            'batchCategories.itemBatchCategories.masterItem',
            'batchCategories.invitedSupplierCategories.supplier.user',
        ])->findOrFail($id);

        $quotations = Quotation::with(['invitedSupplier.supplier.user'])
            ->whereHas('invitedSupplier', fn($q) =>
                $q->whereHas('batchCategory', fn($q2) => $q2->where('id_batch', $id))
            )->get();

        $invitedSuppliers = InvitedSupplierCategory::with([
            'supplier.user',
            'batchCategory.masterCategory',
        ])->whereHas('batchCategory', fn($q) => $q->where('id_batch', $id))->get();

        return response()->json([
            'success'           => true,
            'batch'             => $batch,
            'batch_categories'  => $batch->batchCategories,
            'invited_suppliers' => $invitedSuppliers,
            'quotations'        => $quotations,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline'    => 'required|date|after_or_equal:today',
        ]);

        $count  = Batch::whereDate('created_at', today())->count() + 1;
        $number = 'RFQ-' . date('Ymd') . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

        $batch = Batch::create([
            'batch_number' => $number,
            'title'        => $request->title,
            'description'  => $request->description,
            'deadline'     => $request->deadline,
            'status'       => 'draft',
            'created_by'   => Auth::id(),
        ]);

        return response()->json(['success' => true, 'message' => 'Batch RFQ berhasil dibuat.', 'batch' => $batch], 201);
    }

    public function update(Request $request, $id)
    {
        $batch = Batch::findOrFail($id);

        $request->validate([
            'title'       => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'deadline'    => 'sometimes|required|date|after_or_equal:today',
            'status'      => 'sometimes|required|in:draft,open,closed',
        ]);

        $oldStatus   = $batch->status;
        $oldDeadline = (string) $batch->deadline;

        $batch->update($request->only(['title', 'description', 'deadline', 'status']));

        $newDeadline     = $request->deadline;
        $deadlineChanged = $newDeadline && $newDeadline !== $oldDeadline;

        // ── Re-open: batch yang tadinya closed/awarded kembali ke open/draft ──
        $reopened = $request->has('status')
            && in_array($request->status, ['open', 'draft'])
            && in_array($oldStatus, ['closed', 'awarded']);

        if ($reopened) {
            // Hanya pemenang (approved) yang batch-nya kembali open
            // Supplier rejected TETAP closed — tidak perlu diubah
            $this->reopenForWinnersOnly($batch->fresh());
        }

        // Kirim notif jika di-reopen atau deadline diubah
        if ($reopened || $deadlineChanged) {
            $this->notifyWinnersOnReopen($batch->fresh(), $deadlineChanged ? $newDeadline : null);
        }

        return response()->json(['success' => true, 'message' => 'Batch berhasil diperbarui.', 'batch' => $batch->fresh()]);
    }

    public function destroy($id)
    {
        Batch::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Batch dihapus.']);
    }

    // ── Kategori ──────────────────────────────────────────────────────
    public function addCategory(Request $request, $id)
    {
        Batch::findOrFail($id);
        $request->validate(['id_master_category' => 'required|exists:master_category,id_master_category']);

        if (BatchCategory::where('id_batch', $id)->where('id_master_category', $request->id_master_category)->exists()) {
            return response()->json(['success' => false, 'message' => 'Kategori sudah ada.'], 422);
        }

        $bc = BatchCategory::create(['id_batch' => $id, 'id_master_category' => $request->id_master_category]);

        return response()->json(['success' => true, 'message' => 'Kategori ditambahkan.', 'batch_category' => $bc->load('masterCategory')], 201);
    }

    public function removeCategory($batchId, $catId)
    {
        BatchCategory::where('id_batch', $batchId)->where('id_batch_category', $catId)->firstOrFail()->delete();
        return response()->json(['success' => true, 'message' => 'Kategori dihapus.']);
    }

    // ── Item ──────────────────────────────────────────────────────────
    public function addItem(Request $request, $batchId, $catId)
    {
        BatchCategory::where('id_batch', $batchId)->where('id_batch_category', $catId)->firstOrFail();

        $request->validate([
            'id_item'  => 'required|exists:master_items,id_item',
            'quantity' => 'required|integer|min:1',
        ]);

        if (ItemBatchCategory::where('id_batch_category', $catId)->where('id_item', $request->id_item)->exists()) {
            return response()->json(['success' => false, 'message' => 'Item sudah ada.'], 422);
        }

        $item = ItemBatchCategory::create([
            'id_item'           => $request->id_item,
            'id_batch_category' => $catId,
            'quantity'          => $request->quantity,
        ]);

        return response()->json(['success' => true, 'message' => 'Item ditambahkan.', 'item' => $item->load('masterItem')], 201);
    }

    public function removeItem($batchId, $catId, $itemId)
    {
        ItemBatchCategory::where('id_batch_category', $catId)
            ->where('id_item_batch_category', $itemId)
            ->firstOrFail()
            ->delete();
        return response()->json(['success' => true, 'message' => 'Item dihapus.']);
    }

    // ── Invite Supplier ───────────────────────────────────────────────
    public function inviteSupplier(Request $request, $batchId)
    {
        $batch = Batch::findOrFail($batchId);

        $request->validate([
            'id_supplier'       => 'required|exists:suppliers,id',
            'id_batch_category' => 'required|exists:batch_categories,id_batch_category',
        ]);

        $supplier = Supplier::with('user')->findOrFail($request->id_supplier);
        if (!$supplier->user || !$supplier->user->is_active) {
            return response()->json(['success' => false, 'message' => 'Supplier belum aktif.'], 422);
        }

        if (InvitedSupplierCategory::where('id_supplier', $request->id_supplier)
            ->where('id_batch_category', $request->id_batch_category)->exists()) {
            return response()->json(['success' => false, 'message' => 'Supplier sudah diundang.'], 422);
        }

        $invitation = InvitedSupplierCategory::create([
            'id_supplier'       => $request->id_supplier,
            'id_batch_category' => $request->id_batch_category,
            'invited_at'        => now(),
            'status'            => 'invited',
        ]);

        try {
            (new MailService())->sendRfqInvitation(
                $supplier->user->email,
                $supplier->user->name,
                $batch->title,
                $batch->deadline
            );
        } catch (\Exception $e) {
            Log::warning('Email undangan gagal: ' . $e->getMessage());
        }

        if ($batch->status === 'draft') {
            $batch->update(['status' => 'open']);
        }

        return response()->json(['success' => true, 'message' => 'Supplier diundang & email terkirim.', 'invitation' => $invitation->load('supplier.user')], 201);
    }

    // ── Compare ───────────────────────────────────────────────────────
    public function compare($id)
    {
        $batch = Batch::findOrFail($id);

        $quotations = Quotation::with([
            'invitedSupplier.supplier.user',
            'invitedSupplier.batchCategory.masterCategory',
        ])
        ->whereHas('invitedSupplier', fn($q) =>
            $q->whereHas('batchCategory', fn($q2) => $q2->where('id_batch', $id))
        )
        ->orderBy('total_price')
        ->get();

        return response()->json(['success' => true, 'batch' => $batch, 'quotations' => $quotations]);
    }

    // ── Send Winner Reminder ──────────────────────────────────────────
    /**
     * Kirim reminder ke supplier pemenang (approved).
     * Supplier yang rejected TIDAK mendapat reminder — mereka sudah closed.
     */
    public function sendWinnerReminder(Request $request, $id)
    {
        $batch = Batch::findOrFail($id);

        $approvedQuotations = Quotation::with(['invitedSupplier.supplier.user'])
            ->where('status', 'approved')
            ->whereHas('invitedSupplier', fn($q) =>
                $q->whereHas('batchCategory', fn($q2) => $q2->where('id_batch', $id))
            )
            ->get();

        if ($approvedQuotations->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada pemenang (approved) di batch ini untuk dikirim reminder.',
            ], 422);
        }

        $this->notifyWinnersOnReopen($batch, null);

        return response()->json(['success' => true, 'message' => 'Reminder terkirim ke supplier pemenang.']);
    }

    // ─── Private ──────────────────────────────────────────────────────

    /**
     * Saat batch di-reopen:
     * - Pemenang (approved) → status invitation kembali ke 'invited' supaya bisa submit ulang
     * - Rejected → TIDAK diubah, tetap closed/rejected
     */
    private function reopenForWinnersOnly(Batch $batch): void
    {
        // Ambil semua invitation yang pemenangnya approved di batch ini
        $winnerInvitations = InvitedSupplierCategory::whereHas('batchCategory', function ($q) use ($batch) {
                $q->where('id_batch', $batch->id_batch);
            })
            ->whereHas('quotations', function ($q) {
                // Hanya supplier yang memiliki quotation approved (pemenang)
                $q->where('status', 'approved');
            })
            ->get();

        foreach ($winnerInvitations as $invitation) {
            // Reset status invitation ke 'invited' agar pemenang bisa submit ulang
            $invitation->update(['status' => 'invited']);
        }

        // Supplier rejected: invitation mereka tetap 'submitted', quotation tetap 'rejected'
        // Batch status 'open' tidak membuka akses untuk mereka (dicek di store() SupplierQuotationController)
    }

    /**
     * Kirim email notifikasi ke supplier pemenang saat batch dibuka ulang atau deadline diubah.
     */
    private function notifyWinnersOnReopen(Batch $batch, ?string $newDeadline): void
    {
        $approved = Quotation::with(['invitedSupplier.supplier.user'])
            ->where('status', 'approved')
            ->whereHas('invitedSupplier', fn($q) =>
                $q->whereHas('batchCategory', fn($q2) => $q2->where('id_batch', $batch->id_batch))
            )
            ->get();

        if ($approved->isEmpty()) return;

        $mail = new MailService();

        foreach ($approved as $q) {
            $user     = $q->invitedSupplier?->supplier?->user;
            $supplier = $q->invitedSupplier?->supplier;
            if (!$user || !$supplier) continue;

            try {
                $mail->sendWinnerReminder(
                    $user->email,
                    $user->name,
                    $supplier->company_name,
                    $batch->title,
                    $batch->batch_number,
                    $newDeadline ?? $batch->deadline
                );
            } catch (\Exception $e) {
                Log::warning("Winner reminder gagal ke {$user->email}: " . $e->getMessage());
            }
        }
    }
}