<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order — {{ $poNumber }}</title>

    <style>
        /* ── Reset ── */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', Arial, Helvetica, sans-serif;
            font-size: 8.5px;
            color: #111827;
            background: #ffffff;
            padding: 22px 28px;
            line-height: 1.4;
        }

        /* ── Header ── */
        .header {
            display: table;
            width: 100%;
            border-bottom: 3px solid #1d4ed8;
            padding-bottom: 14px;
            margin-bottom: 18px;
        }
        .header-left  { display: table-cell; vertical-align: middle; width: 60%; }
        .header-right { display: table-cell; vertical-align: middle; text-align: right; }

        .brand-name { font-size: 18px; font-weight: 900; color: #1d4ed8; letter-spacing: -0.5px; }
        .brand-sub  { font-size: 8px; color: #6b7280; margin-top: 2px; }

        .po-label  { font-size: 9px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 1px; }
        .po-number { font-size: 16px; font-weight: 900; color: #1d4ed8; margin-top: 2px; }
        .po-badge  {
            display: inline-block;
            background: #dcfce7;
            color: #166534;
            font-size: 7px;
            font-weight: 700;
            padding: 2px 10px;
            border-radius: 20px;
            margin-top: 4px;
            letter-spacing: 0.5px;
        }

        /* ── Section label ── */
        .section-label {
            font-size: 7px;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 3px;
            margin-bottom: 8px;
            margin-top: 16px;
        }

        /* ── Info grid (2 col) ── */
        .info-grid   { display: table; width: 100%; margin-bottom: 4px; }
        .info-col    { display: table-cell; width: 50%; vertical-align: top; padding-right: 14px; }
        .info-col:last-child { padding-right: 0; padding-left: 14px; }

        .info-row { margin-bottom: 4px; font-size: 8.5px; }
        .info-key { color: #9ca3af; }
        .info-val { font-weight: 600; color: #111827; }

        /* ── Summary box ── */
        .summary-box {
            display: table;
            width: 100%;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
            padding: 10px 14px;
            margin-bottom: 16px;
        }
        .summary-item       { display: table-cell; text-align: center; padding: 0 10px; border-right: 1px solid #bfdbfe; }
        .summary-item:last-child { border-right: none; }
        .summary-val        { font-size: 13px; font-weight: 900; color: #1d4ed8; }
        .summary-key        { font-size: 7px; color: #6b7280; margin-top: 2px; }

        /* ── Table ── */
        .section-label-table {
            font-size: 7px;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 6px;
        }

        table.items {
            width: 100%;
            border-collapse: collapse;
            font-size: 6.8px;
            margin-bottom: 16px;
        }
        table.items thead tr { background: #1d4ed8; color: #ffffff; }
        table.items thead th {
            padding: 5px 6px;
            text-align: left;
            font-weight: 700;
            white-space: nowrap;
        }
        table.items tbody tr:nth-child(even)  { background: #f8fafc; }
        table.items tbody tr:nth-child(odd)   { background: #ffffff; }
        table.items tbody td {
            padding: 4px 6px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: top;
        }
        table.items tfoot tr { background: #eff6ff; border-top: 2px solid #1d4ed8; }
        table.items tfoot td {
            padding: 6px 8px;
            font-weight: 700;
            font-size: 8px;
            color: #1d4ed8;
        }

        .td-right  { text-align: right; }
        .td-center { text-align: center; }

        /* ── Note box ── */
        .note-box {
            background: #fffbeb;
            border-left: 3px solid #f59e0b;
            padding: 8px 10px;
            border-radius: 4px;
            margin-bottom: 16px;
            font-size: 8px;
        }
        .note-box strong { color: #92400e; }

        /* ── Signatures ── */
        .sig-grid { display: table; width: 100%; margin-top: 24px; }
        .sig-col  { display: table-cell; width: 33.33%; text-align: center; padding: 0 12px; }
        .sig-label  { font-size: 8px; color: #6b7280; margin-bottom: 4px; }
        .sig-line   {
            border-top: 1px solid #9ca3af;
            margin-top: 40px;
            padding-top: 5px;
            font-size: 8px;
            font-weight: 700;
            color: #374151;
        }
        .sig-sub { font-size: 7px; color: #9ca3af; margin-top: 2px; }

        /* ── Footer ── */
        .doc-footer {
            text-align: center;
            margin-top: 18px;
            padding-top: 8px;
            border-top: 1px solid #e5e7eb;
            font-size: 7px;
            color: #9ca3af;
        }
    </style>
</head>
<body>

    {{-- ── HEADER ── --}}
    <div class="header">
        <div class="header-left">
            <div class="brand-name">E-Quotation System</div>
            <div class="brand-sub">Procurement Management Platform</div>
        </div>
        <div class="header-right">
            <div class="po-label">Purchase Order</div>
            <div class="po-number">{{ $poNumber }}</div>
            <div class="po-badge">✓ APPROVED</div>
        </div>
    </div>

    {{-- ── SUMMARY STATS ── --}}
    <div class="summary-box">
        <div class="summary-item">
            <div class="summary-val">{{ count($items) }}</div>
            <div class="summary-key">Total Item</div>
        </div>
        <div class="summary-item">
            <div class="summary-val">Rp {{ number_format($quotation->total_price ?? 0, 0, ',', '.') }}</div>
            <div class="summary-key">Total Nilai Penawaran</div>
        </div>
        <div class="summary-item">
            <div class="summary-val">{{ $today }}</div>
            <div class="summary-key">Tanggal Approve</div>
        </div>
    </div>

    {{-- ── INFO GRID ── --}}
    <div class="section-label">Informasi Dokumen</div>
    <div class="info-grid">
        <div class="info-col">
            <div class="info-row"><span class="info-key">No. PO: </span><span class="info-val">{{ $poNumber }}</span></div>
            <div class="info-row"><span class="info-key">No. RFQ: </span><span class="info-val">{{ $batch?->batch_number ?? '-' }}</span></div>
            <div class="info-row"><span class="info-key">Judul RFQ: </span><span class="info-val">{{ $batch?->title ?? '-' }}</span></div>
            <div class="info-row"><span class="info-key">Kategori: </span><span class="info-val">{{ $category?->name ?? '-' }}</span></div>
            <div class="info-row">
                <span class="info-key">Deadline RFQ: </span>
                <span class="info-val">
                    {{ $batch?->deadline ? \Carbon\Carbon::parse($batch->deadline)->translatedFormat('d F Y') : '-' }}
                </span>
            </div>
            <div class="info-row"><span class="info-key">Tanggal Dibuat: </span><span class="info-val">{{ $today }}</span></div>
        </div>
        <div class="info-col">
            <div class="info-row"><span class="info-key">Perusahaan: </span><span class="info-val">{{ $supplier?->company_name ?? '-' }}</span></div>
            <div class="info-row"><span class="info-key">PIC: </span><span class="info-val">{{ $user?->name ?? '-' }}</span></div>
            <div class="info-row"><span class="info-key">Email: </span><span class="info-val">{{ $user?->email ?? '-' }}</span></div>
            <div class="info-row"><span class="info-key">Telepon: </span><span class="info-val">{{ $supplier?->phone ?? '-' }}</span></div>
            <div class="info-row"><span class="info-key">NPWP: </span><span class="info-val">{{ $supplier?->npwp ?? '-' }}</span></div>
            <div class="info-row"><span class="info-key">Alamat: </span><span class="info-val">{{ $supplier?->address ?? '-' }}</span></div>
        </div>
    </div>

    {{-- ── ITEMS TABLE (17 kolom sesuai Excel) ── --}}
    <div class="section-label-table" style="margin-top:16px;">Detail Item Penawaran</div>
    <table class="items">
        <thead>
            <tr>
                <th>#</th>
                <th>Coll No.</th>
                <th>RFQ No.</th>
                <th>Vendor</th>
                <th>No. Item</th>
                <th>Material No.</th>
                <th>Description</th>
                <th>Qty</th>
                <th>UoM</th>
                <th>Currency</th>
                <th>Net Price</th>
                <th>Incoterm</th>
                <th>Destination</th>
                <th>Remark 1</th>
                <th>Remark 2</th>
                <th>Lead Time (Wks)</th>
                <th>Payment Term</th>
                <th>Quotation Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $i => $item)
            <tr>
                <td class="td-center">{{ $i + 1 }}</td>
                <td>{{ $item->coll_no ?? '-' }}</td>
                <td>{{ $item->rfq_no ?? '-' }}</td>
                <td>{{ $item->vendor ?? '-' }}</td>
                <td class="td-center">{{ $item->no_item ?? '-' }}</td>
                <td>{{ $item->material_no ?? '-' }}</td>
                <td>{{ $item->description ?? '-' }}</td>
                <td class="td-center">{{ $item->qty ?? 0 }}</td>
                <td class="td-center">{{ $item->uom ?? '-' }}</td>
                <td class="td-center">{{ $item->currency ?? '-' }}</td>
                <td class="td-right">
                    {{ $item->net_price ? number_format($item->net_price, 2, ',', '.') : '-' }}
                </td>
                <td>{{ $item->incoterm ?? '-' }}</td>
                <td>{{ $item->destination ?? '-' }}</td>
                <td>{{ $item->remark_1 ?? '-' }}</td>
                <td>{{ $item->remark_2 ?? '-' }}</td>
                <td class="td-center">{{ $item->lead_time_weeks ?? '-' }}</td>
                <td>{{ $item->payment_term ?? '-' }}</td>
                <td>{{ $item->quotation_date ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="18" class="td-center" style="padding:10px; color:#6b7280;">
                    Data item tidak tersedia. File Excel: {{ $quotation->file_name ?? 'Terlampir' }}
                </td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="10" class="td-right" style="font-size:8px;">TOTAL NILAI PENAWARAN</td>
                <td colspan="8" class="td-right" style="font-size:10px;">
                    Rp {{ number_format($quotation->total_price ?? 0, 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>

    {{-- ── NOTE ── --}}
    @if($quotation->note)
    <div class="note-box">
        <strong>Catatan:</strong> {{ $quotation->note }}
    </div>
    @endif

    {{-- ── SIGNATURES ── --}}
    <div class="sig-grid">
        <div class="sig-col">
            <div class="sig-label">Disetujui oleh</div>
            <div class="sig-line">{{ $creator?->name ?? 'Admin Procurement' }}</div>
            <div class="sig-sub">Admin Procurement</div>
        </div>

        <div class="sig-col">
            <div class="sig-label">Diterima oleh</div>
            <div class="sig-line">{{ $user?->name ?? '-' }}</div>
            <div class="sig-sub">{{ $supplier?->company_name ?? '-' }}</div>
        </div>
    </div>

    {{-- ── FOOTER ── --}}
    <div class="doc-footer">
        Dokumen ini digenerate otomatis oleh E-Quotation System &nbsp;·&nbsp;
        {{ $today }} &nbsp;·&nbsp; {{ $poNumber }} &nbsp;·&nbsp;
        Sah tanpa tanda tangan basah
    </div>

</body>
</html>