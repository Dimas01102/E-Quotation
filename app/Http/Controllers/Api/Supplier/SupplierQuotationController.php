<?php

namespace App\Http\Controllers\Api\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\InvitedSupplierCategory;
use App\Models\Supplier;
use App\Services\MailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SupplierQuotationController extends Controller
{
    public function index()
    {
        $user     = Auth::user();
        $supplier = Supplier::where('user_id', $user->id)->firstOrFail();

        $quotations = Quotation::with([
            'invitedSupplier.batchCategory.batch',
            'invitedSupplier.batchCategory.masterCategory',
        ])
        ->whereHas('invitedSupplier', fn($q) => $q->where('id_supplier', $supplier->id))
        ->orderByDesc('submitted_at')
        ->get()
        ->map(fn($q) => [
            'id_quotation'  => $q->id_quotation,
            'file_name'     => $q->file_name,
            'file_url'      => $q->file_path ? Storage::url($q->file_path) : null,
            'total_price'   => $q->total_price,
            'status'        => $q->status,
            'note'          => $q->note,
            'submitted_at'  => $q->submitted_at,
            'po_url'        => $q->po_file_path ? Storage::url($q->po_file_path) : null,
            'batch_title'   => $q->invitedSupplier?->batchCategory?->batch?->title,
            'batch_number'  => $q->invitedSupplier?->batchCategory?->batch?->batch_number,
            'batch_status'  => $q->invitedSupplier?->batchCategory?->batch?->status,
            'category_name' => $q->invitedSupplier?->batchCategory?->masterCategory?->name,
        ]);

        return response()->json(['success' => true, 'quotations' => $quotations]);
    }

    /**
     * Submit quotation.
     * Batch harus 'open' DAN deadline belum lewat.
     * Supplier yang statusnya 'rejected' TIDAK bisa submit ulang — hanya 'approved' (winner) yang
     * batch-nya di-reopen yang boleh submit ulang.
     */
    public function store(Request $request)
    {
        $user     = Auth::user();
        $supplier = Supplier::where('user_id', $user->id)->firstOrFail();

        if (!$user->is_active) {
            return response()->json(['success' => false, 'message' => 'Akun belum aktif. Hubungi admin.'], 403);
        }

        $request->validate([
            'id_invited_supplier' => 'required|exists:invited_supplier_categories,id_invited_supplier',
            'file'                => 'required|file|mimes:xlsx,xls,csv|max:10240',
            'total_price'         => 'required|numeric|min:0',
        ]);

        $invitation = InvitedSupplierCategory::with('batchCategory.batch')
            ->where('id_invited_supplier', $request->id_invited_supplier)
            ->where('id_supplier', $supplier->id)
            ->firstOrFail();

        // Cek status batch
        $batch = $invitation->batchCategory?->batch;
        if (!$batch) {
            return response()->json(['success' => false, 'message' => 'Batch tidak ditemukan.'], 404);
        }

        if ($batch->status !== 'open') {
            return response()->json([
                'success' => false,
                'message' => 'Pengadaan ini tidak sedang dibuka. Status saat ini: ' . strtoupper($batch->status),
            ], 422);
        }

        // Cek deadline
        if ($batch->deadline && Carbon::parse($batch->deadline)->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'Deadline pengadaan ini sudah lewat. Tidak bisa mengajukan penawaran.',
            ], 422);
        }

        // ─── cek duplikat dengan mempertimbangkan re-open ─────────
        $existingQuotation = Quotation::where('id_invited_supplier', $invitation->id_invited_supplier)
            ->latest('submitted_at')
            ->first();

        if ($existingQuotation) {
            // Jika sudah ada quotation rejected → tidak boleh submit ulang (bukan pemenang)
            if ($existingQuotation->status === 'rejected') {
                return response()->json([
                    'success' => false,
                    'message' => 'Penawaran Anda sebelumnya telah ditolak. Anda tidak dapat mengajukan ulang.',
                ], 422);
            }

            // Jika masih pending/submitted → tidak boleh duplikat
            if (in_array($existingQuotation->status, ['pending', 'submitted'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah mengirim penawaran untuk undangan ini.',
                ], 422);
            }

            // Jika approved DAN batch di-reopen → boleh submit ulang (pemenang dikirim reminder)
            // Status approved tetap ada, kita buat entry baru
        }

        $file     = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $filePath = $file->store('quotations', 'public');

        DB::beginTransaction();
        try {
            $quotation = Quotation::create([
                'id_invited_supplier' => $invitation->id_invited_supplier,
                'file_name'           => $fileName,
                'file_path'           => $filePath,
                'total_price'         => $request->total_price,
                'submitted_at'        => now(),
                'status'              => 'pending',
            ]);

            // Parse Excel template excel
            $this->parseAndSaveExcel($quotation->id_quotation, storage_path('app/public/' . $filePath));

            $invitation->update(['status' => 'submitted']);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Storage::disk('public')->delete($filePath);
            Log::error('Gagal simpan quotation: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal memproses file.'], 500);
        }

        // Notif admin
        try {
            (new MailService())->sendQuotationSubmitted(
                config('mail.from.address'),
                $supplier->company_name,
                $batch->title
            );
        } catch (\Exception $e) {
            Log::warning('Email admin gagal: ' . $e->getMessage());
        }

        return response()->json(['success' => true, 'message' => 'Penawaran berhasil dikirim.', 'quotation' => $quotation], 201);
    }

    /**
     * Parse Excel dan simpan semua 17 kolom sesuai template:
     * Coll No. | RFQ No. | Vendor | No. Item | Material No. | Description | Qty | UoM |
     * Currency | Net Price | Incoterm | Destination | Remark 1 | Remark 2 |
     * Lead Time(Weeks) | Payment Term | Quotation Date
     */
    private function parseAndSaveExcel(int $quotationId, string $filePath): void
    {
        if (!class_exists(\PhpOffice\PhpSpreadsheet\IOFactory::class)) {
            Log::warning('PhpSpreadsheet tidak tersedia.');
            return;
        }
        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
            $sheet       = $spreadsheet->getActiveSheet();
            $rows        = $sheet->toArray(null, true, true, true);

            $headerMap = null;

            // ── Mapping kolom Excel → field DB (sesuai tabel quotation_items) ──
            $colMap = [
                'coll_no'         => ['Coll No.', 'Coll No', 'COLL NO', 'COLL NO.', 'COLL_NO'],
                'rfq_no'          => ['RFQ No.', 'RFQ No', 'RFQ NO', 'RFQ NO.', 'RFQ_NO'],
                'vendor'          => ['Vendor', 'VENDOR'],
                'no_item'         => ['No. Item', 'No Item', 'NO. ITEM', 'NO ITEM', 'NO_ITEM'],
                'material_no'     => ['Material No.', 'Material No', 'MATERIAL NO', 'MATERIAL NO.', 'MATERIAL_NO'],
                'description'     => ['Description', 'DESCRIPTION', 'DESC'],
                'qty'             => ['Qty', 'QTY', 'Quantity', 'QUANTITY'],
                'uom'             => ['UoM', 'UOM', 'Unit', 'UNIT', 'Satuan'],
                'currency'        => ['Currency', 'CURRENCY'],
                'net_price'       => ['Net Price', 'NET PRICE', 'NET_PRICE', 'Harga'],
                'incoterm'        => ['Incoterm', 'INCOTERM'],
                'destination'     => ['Destination', 'DESTINATION', 'Dest'],
                'remark_1'        => ['Remark 1', 'REMARK 1', 'REMARK1', 'Remark_1'],
                'remark_2'        => ['Remark 2', 'REMARK 2', 'REMARK2', 'Remark_2'],
                'lead_time_weeks' => ['Lead Time(Weeks)', 'Lead Time (Weeks)', 'LEAD TIME', 'LEAD TIME(WEEKS)', 'Lead Time'],
                'payment_term'    => ['Payment Term', 'PAYMENT TERM', 'PAYMENT_TERM'],
                'quotation_date'  => ['Quotation Date', 'QUOTATION DATE', 'QUOTATION_DATE', 'Tgl Penawaran'],
            ];

            foreach ($rows as $row) {
                if ($headerMap === null) {
                    $headerMap = [];
                    foreach ($row as $col => $val) {
                        if ($val === null) continue;
                        $norm = trim(strtoupper((string)$val));
                        foreach ($colMap as $field => $variants) {
                            foreach ($variants as $v) {
                                if (strtoupper(trim($v)) === $norm) {
                                    $headerMap[$col] = $field;
                                    break 2;
                                }
                            }
                        }
                    }
                    continue; // baris header, skip
                }

                // Skip baris kosong
                if (empty(array_filter($row, fn($v) => $v !== null && $v !== ''))) continue;

                $data = ['id_quotation' => $quotationId];
                foreach ($row as $col => $val) {
                    if (isset($headerMap[$col])) {
                        $data[$headerMap[$col]] = $val;
                    }
                }
                QuotationItem::create($data);
            }
        } catch (\Exception $e) {
            Log::warning('Parse Excel: ' . $e->getMessage());
        }
    }
}