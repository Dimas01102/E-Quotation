<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order - {{ $poNumber }}</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DejaVu Sans', Arial, Helvetica, sans-serif;
            font-size: 8px;
            color: #1f2937;
            background: #ffffff;
            padding: 20px 24px;
        }

        /* ── Header ── */
        .header {
            display: table;
            width: 100%;
            border-bottom: 3px solid #1e40af;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }

        .header-left {
            display: table-cell;
            vertical-align: middle;
        }

        .header-right {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
        }

        .company-name {
            font-size: 16px;
            font-weight: 700;
            color: #1e40af;
        }

        .company-sub {
            font-size: 8px;
            color: #6b7280;
            margin-top: 2px;
        }

        .po-label {
            font-size: 20px;
            font-weight: 700;
            color: #1e40af;
        }

        .po-number {
            font-size: 9px;
            color: #6b7280;
            margin-top: 2px;
        }

        .po-badge {
            display: inline-block;
            background: #dcfce7;
            color: #166534;
            font-size: 7px;
            font-weight: 700;
            padding: 2px 10px;
            border-radius: 20px;
            margin-top: 4px;
        }

        /* ── Info Grid ── */
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 16px;
        }

        .info-col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-right: 12px;
        }

        .info-col:last-child {
            padding-right: 0;
            padding-left: 12px;
        }

        .section-label {
            font-size: 7px;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 3px;
            margin-bottom: 6px;
        }

        .info-row {
            margin-bottom: 3px;
            font-size: 8px;
        }

        .info-key {
            color: #9ca3af;
            display: inline;
        }

        .info-val {
            color: #111827;
            font-weight: 600;
            display: inline;
        }

        /* ── Items Table ── */
        .table-label {
            font-size: 7px;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 6px;
        }

        table.items {
            width: 100%;
            border-collapse: collapse;
            font-size: 6.5px;
            margin-bottom: 14px;
        }

        table.items thead tr {
            background: #1e40af;
            color: #ffffff;
        }

        table.items thead th {
            padding: 5px 6px;
            text-align: left;
            white-space: nowrap;
            font-weight: 600;
        }

        table.items tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        table.items tbody tr:nth-child(odd) {
            background: #ffffff;
        }

        table.items tbody td {
            padding: 4px 6px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
        }

        .td-right {
            text-align: right;
        }

        .td-center {
            text-align: center;
        }

        .total-row td {
            background: #eff6ff !important;
            border-top: 2px solid #1e40af;
            font-weight: 700;
            font-size: 8px;
            padding: 6px 8px;
        }

        /* ── Note ── */
        .note-box {
            background: #eff6ff;
            border-left: 3px solid #1e40af;
            padding: 7px 10px;
            border-radius: 3px;
            margin-bottom: 16px;
            font-size: 8px;
        }

        .note-box strong {
            color: #1e40af;
        }

        /* ── Summary ── */
        .summary-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 6px;
            padding: 8px 12px;
            margin-bottom: 16px;
            display: table;
            width: 100%;
        }

        .summary-item {
            display: table-cell;
            text-align: center;
            padding: 0 8px;
            border-right: 1px solid #bbf7d0;
        }

        .summary-item:last-child {
            border-right: none;
        }

        .summary-val {
            font-size: 12px;
            font-weight: 700;
            color: #166534;
        }

        .summary-key {
            font-size: 7px;
            color: #6b7280;
            margin-top: 2px;
        }

        /* ── Signatures ── */
        .signature-grid {
            display: table;
            width: 100%;
            margin-top: 20px;
        }

        .signature-col {
            display: table-cell;
            width: 33%;
            text-align: center;
            padding: 0 10px;
        }

        .signature-label {
            font-size: 8px;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .signature-line {
            border-top: 1px solid #9ca3af;
            margin-top: 36px;
            padding-top: 5px;
            font-size: 8px;
            font-weight: 600;
            color: #374151;
        }

        .signature-sub {
            font-size: 7px;
            color: #9ca3af;
            margin-top: 2px;
        }

        /* ── Footer ── */
        .footer {
            text-align: center;
            margin-top: 16px;
            padding-top: 8px;
            border-top: 1px solid #e5e7eb;
            font-size: 7px;
            color: #9ca3af;
        }
    </style>
</head>

<body>

    {{-- ── Header ── --}}
    <div class="header">
        <div class="header-left">
            <div class="company-name">E-Quotation System</div>
            <div class="company-sub">Procurement Management Platform</div>
        </div>
        <div class="header-right">
            <div class="po-label">PURCHASE ORDER</div>
            <div class="po-number">{{ $poNumber }}</div>
            <div class="po-badge">✓ APPROVED</div>
        </div>
    </div>

    {{-- ── Info Grid ── --}}
    <div class="info-grid">
        <div class="info-col">
            <div class="section-label">Informasi PO</div>
            <div class="info-row"><span class="info-key">Tanggal Dibuat: </span><span
                    class="info-val">{{ $today }}</span></div>
            <div class="info-row"><span class="info-key">No. RFQ: </span><span
                    class="info-val">{{ $batch?->batch_number ?? '-' }}</span></div>
            <div class="info-row"><span class="info-key">Judul RFQ: </span><span
                    class="info-val">{{ $batch?->title ?? '-' }}</span></div>
            <div class="info-row"><span class="info-key">Kategori: </span><span
                    class="info-val">{{ $category?->name ?? '-' }}</span></div>
            <div class="info-row"><span class="info-key">Deadline RFQ: </span><span
                    class="info-val">{{ $batch?->deadline ? \Carbon\Carbon::parse($batch->deadline)->format('d F Y') : '-' }}</span>
            </div>
        </div>
        <div class="info-col">
            <div class="section-label">Informasi Supplier</div>
            <div class="info-row"><span class="info-key">Perusahaan: </span><span
                    class="info-val">{{ $supplier?->company_name ?? '-' }}</span></div>
            <div class="info-row"><span class="info-key">PIC: </span><span
                    class="info-val">{{ $user?->name ?? '-' }}</span></div>
            <div class="info-row"><span class="info-key">Email: </span><span
                    class="info-val">{{ $user?->email ?? '-' }}</span></div>
            <div class="info-row"><span class="info-key">Telepon: </span><span
                    class="info-val">{{ $supplier?->phone ?? '-' }}</span></div>
            <div class="info-row"><span class="info-key">NPWP: </span><span
                    class="info-val">{{ $supplier?->npwp ?? '-' }}</span></div>
            <div class="info-row"><span class="info-key">Alamat: </span><span
                    class="info-val">{{ $supplier?->address ?? '-' }}</span></div>
        </div>
    </div>

    {{-- ── Summary ── --}}
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

    {{-- ── Items Table (17 kolom sesuai Excel) ── --}}
    <div class="table-label">Detail Item Penawaran — sesuai file Excel yang diajukan</div>
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
                <th>Lead Time (Weeks)</th>
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
                    <td>{{ $item->no_item ?? '-' }}</td>
                    <td>{{ $item->material_no ?? '-' }}</td>
                    <td>{{ $item->description ?? '-' }}</td>
                    <td class="td-center">{{ $item->qty ?? 0 }}</td>
                    <td class="td-center">{{ $item->uom ?? '-' }}</td>
                    <td class="td-center">{{ $item->currency ?? '-' }}</td>
                    <td class="td-right">{{ $item->net_price ? number_format($item->net_price, 2) : '-' }}</td>
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
                    <td colspan="18" style="text-align:center; padding:10px; color:#6b7280;">
                        Data item tidak tersedia. File Excel: {{ $quotation->file_name ?? 'Terlampir' }}
                    </td>
                </tr>
            @endforelse

            {{-- Total Row --}}
            <tr class="total-row">
                <td colspan="10">TOTAL NILAI PENAWARAN</td>
                <td colspan="8" class="td-right">
                    Rp {{ number_format($quotation->total_price ?? 0, 0, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>

    {{-- ── Note ── --}}
    @if ($quotation->note)
        <div class="note-box">
            <strong>Catatan:</strong> {{ $quotation->note }}
        </div>
    @endif

    {{-- ── Signatures ── --}}
    <div class="signature-grid">
        <div class="signature-col">
            <div class="signature-label">Disetujui oleh:</div>
            <div class="signature-line">{{ $creator?->name ?? 'Admin Procurement' }}</div>
            <div class="signature-sub">Admin Procurement</div>
        </div>
        <div class="signature-col">
            <div class="signature-label">Diketahui oleh:</div>
            <div class="signature-line">Manager Procurement</div>
            <div class="signature-sub">Jabatan</div>
        </div>
        <div class="signature-col">
            <div class="signature-label">Diterima oleh:</div>
            <div class="signature-line">{{ $user?->name ?? '-' }}</div>
            <div class="signature-sub">{{ $supplier?->company_name ?? '-' }}</div>
        </div>
    </div>

    {{-- ── Footer ── --}}
    <div class="footer">
        Dokumen ini digenerate otomatis oleh E-Quotation System &nbsp;·&nbsp; {{ $today }} &nbsp;·&nbsp;
        {{ $poNumber }}
    </div>

</body>

</html>
