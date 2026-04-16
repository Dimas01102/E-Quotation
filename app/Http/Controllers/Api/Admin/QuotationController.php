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
    // ── List ──────────────────────────────────────────────────────────
    public function index()
    {
        $quotations = Quotation::with([
            'invitedSupplier.supplier.user',
            'invitedSupplier.batchCategory.batch',
            'invitedSupplier.batchCategory.masterCategory',
        ])->orderByDesc('submitted_at')->get();

        return response()->json(['success' => true, 'quotations' => $quotations]);
    }

    // ── Detail — 17 kolom + download URL ─────────────────────────────
    public function show($id)
    {
        $quotation = Quotation::with([
            'invitedSupplier.supplier.user',
            'invitedSupplier.batchCategory.batch',
            'invitedSupplier.batchCategory.masterCategory',
            'quotationItems',
        ])->findOrFail($id);

        $data = $quotation->toArray();
        $data['file_download_url'] = $quotation->file_path
            ? Storage::url($quotation->file_path) : null;
        $data['po_download_url'] = $quotation->po_file_path
            ? Storage::url($quotation->po_file_path) : null;

        return response()->json(['success' => true, 'quotation' => $data]);
    }

    // ── Compare — harga terendah dulu ─────────────────────────────────
    public function compare($batchId)
    {
        $quotations = Quotation::with([
            'invitedSupplier.supplier.user',
            'invitedSupplier.batchCategory.masterCategory',
        ])
        ->whereHas('invitedSupplier', fn($q) =>
            $q->whereHas('batchCategory', fn($q2) => $q2->where('id_batch', $batchId))
        )
        ->orderBy('total_price')
        ->get();

        return response()->json(['success' => true, 'quotations' => $quotations]);
    }

    // ── Approve + generate PO + kirim email ke semua pihak ───────────
    public function approve(Request $request, $id)
    {
        $quotation = Quotation::with([
            'invitedSupplier.supplier.user',
            'invitedSupplier.batchCategory.batch.creator',
            'invitedSupplier.batchCategory.masterCategory',
            'quotationItems',
        ])->findOrFail($id);

        if ($quotation->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya penawaran pending yang bisa di-approve.',
            ], 422);
        }

        // 1. Generate PO PDF via blade view
        $poFilePath = $this->generatePoPdf($quotation);

        // 2. Update pemenang
        $quotation->update([
            'status'       => 'approved',
            'note'         => $request->note ?? null,
            'po_file_path' => $poFilePath,
        ]);

        // 3. Invitation pemenang → 'winner'
        $quotation->invitedSupplier?->update(['status' => 'winner']);

        // 4. Ambil semua quotation pending lain di batch_category yang sama SEBELUM di-reject
        $pendingOthers = Quotation::with(['invitedSupplier.supplier.user'])
            ->where('id_quotation', '!=', $id)
            ->where('status', 'pending')
            ->whereHas('invitedSupplier', fn($q) =>
                $q->where('id_batch_category', $quotation->invitedSupplier->id_batch_category)
            )
            ->get();

        // 5. Auto-reject semua pending lain
        $pendingOthers->each(fn($q) => $q->update([
            'status' => 'rejected',
            'note'   => 'Penawaran lain telah dipilih.',
        ]));

        // 6. Batch → closed
        $batch = $quotation->invitedSupplier?->batchCategory?->batch;
        if ($batch) $batch->update(['status' => 'closed']);

        $batchTitle = $batch?->title ?? '';
        $mail       = new MailService();

        // 7.Email ke PEMENANG (approved)
        try {
            $winnerSupplier = $quotation->invitedSupplier?->supplier;
            if ($winnerSupplier?->user) {
                $mail->sendQuotationApproved(
                    $winnerSupplier->user->email,
                    $winnerSupplier->user->name,
                    $batchTitle
                );
            }
        } catch (\Exception $e) {
            Log::warning('Email pemenang gagal: ' . $e->getMessage());
        }

        // 8. Email ke semua supplier yang AUTO-REJECTED 
        foreach ($pendingOthers as $rejected) {
            try {
                $rejSupplier = $rejected->invitedSupplier?->supplier;
                if ($rejSupplier?->user) {
                    $mail->sendQuotationRejected(
                        $rejSupplier->user->email,
                        $rejSupplier->user->name,
                        $batchTitle,
                        'Telah terpilih penawaran dari supplier lain yang lebih sesuai. Terima kasih atas partisipasi Anda.'
                    );
                }
            } catch (\Exception $e) {
                Log::warning('Email auto-reject ke ' . ($rejSupplier?->user?->email ?? '?') . ' gagal: ' . $e->getMessage());
            }
        }

        return response()->json([
            'success'           => true,
            'message'           => 'Penawaran disetujui! PO digenerate & notifikasi terkirim ke semua supplier.',
            'po_url'            => $poFilePath ? Storage::url($poFilePath) : null,
            'notified_rejected' => $pendingOthers->count(),
        ]);
    }

    // ── Reject manual ─────────────────────────────────────────────────
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

        // Email ke supplier yang ditolak manual
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

        return response()->json(['success' => true, 'message' => 'Penawaran ditolak & notifikasi terkirim.']);
    }

    // ── Generate PO PDF via blade view ────────────────────────────────
    private function generatePoPdf(Quotation $quotation): ?string
    {
        try {
            $supplier = $quotation->invitedSupplier?->supplier;
            $user     = $supplier?->user;
            $batch    = $quotation->invitedSupplier?->batchCategory?->batch;
            $category = $quotation->invitedSupplier?->batchCategory?->masterCategory;
            $creator  = $batch?->creator;
            $items    = $quotation->quotationItems ?? collect();
            $poNumber = 'PO-' . date('Ymd') . '-' . str_pad($quotation->id_quotation, 4, '0', STR_PAD_LEFT);
            $today    = \Carbon\Carbon::now()->format('d F Y');

            // Pakai blade view — bukan string HTML di controller
            $html = view('pages.pdf.purchase-order', compact(
                'quotation', 'supplier', 'user', 'batch',
                'category', 'creator', 'items', 'poNumber', 'today'
            ))->render();

            $opts = new Options();
            $opts->set('defaultFont', 'DejaVu Sans');
            $opts->set('isRemoteEnabled', false);
            $opts->set('isHtml5ParserEnabled', true);

            $dompdf = new Dompdf($opts);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();

            $path = 'po/po_' . $quotation->id_quotation . '_' . time() . '.pdf';
            Storage::disk('public')->put($path, $dompdf->output());

            return $path;
        } catch (\Exception $e) {
            Log::error('Generate PO gagal: ' . $e->getMessage());
            return null;
        }
    }
}