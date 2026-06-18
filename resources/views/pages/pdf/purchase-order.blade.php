<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order {{ $poNumber }}</title>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, Helvetica, 'DejaVu Sans', sans-serif;
            font-size: 9px;
            color: #1a1a2e;
            background: #ffffff;
            padding: 24px 28px;
            line-height: 1.5;
        }

        /* ════════════════════════════════
           HEADER
        ════════════════════════════════ */
        .header {
            display: table;
            width: 100%;
            padding-bottom: 16px;
            margin-bottom: 18px;
            border-bottom: 2px solid #0e7490; 
        }
        .header-left  { display: table-cell; vertical-align: top; width: 60%; }
        .header-right { display: table-cell; vertical-align: top; text-align: right; }

        /* Company branding */
        .header-brand   { display: table; width: 100%; }
        .header-logo    { display: table-cell; vertical-align: middle; width: 52px; padding-right: 10px; }
        .header-logo img { width: 48px; height: 48px; object-fit: contain; display: block; }
        .header-brand-text { display: table-cell; vertical-align: middle; }

        .company-name {
            font-size: 22px;
            font-weight: 900;
            color: #0e7490;
            letter-spacing: -0.5px;
            margin-bottom: 3px;
        }
        .company-tagline { font-size: 8px; color: #64748b; margin-bottom: 6px; }
        .company-info    { font-size: 8px; color: #475569; line-height: 1.7; }

        /* Document title */
        .doc-title {
            font-size: 18px;
            font-weight: 900;
            color: #0e7490;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }
        .doc-badge {
            display: inline-block;
            background: #ccfbf1;
            color: #0f766e;
            font-size: 7px;
            font-weight: 700;
            padding: 2px 10px;
            border-radius: 20px;
            margin-top: 5px;
            letter-spacing: 0.5px;
        }

        /* ════════════════════════════════
           INFO GRID (TO kiri / PO detail kanan)
        ════════════════════════════════ */
        .info-section {
            display: table;
            width: 100%;
            margin-bottom: 16px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            overflow: hidden;
        }
        .info-col-to   { display: table-cell; width: 50%; padding: 10px 14px; vertical-align: top; border-right: 1px solid #e2e8f0; }
        .info-col-meta { display: table-cell; width: 50%; padding: 10px 14px; vertical-align: top; background: #f8fafc; }

        .info-group-title {
            font-size: 7.5px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 6px;
            padding-bottom: 4px;
            border-bottom: 1px solid #e2e8f0;
        }

        .info-row       { display: table; width: 100%; margin-bottom: 3px; }
        .info-key       { display: table-cell; width: 38%; font-size: 8px; color: #94a3b8; vertical-align: top; }
        .info-val       { display: table-cell; font-size: 8.5px; font-weight: 600; color: #1e293b; vertical-align: top; }
        .info-val.large { font-size: 11px; font-weight: 900; color: #0e7490; }

        /* ════════════════════════════════
           ITEMS TABLE
        ════════════════════════════════ */
        .table-title {
            font-size: 7.5px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 6px;
        }

        table.items {
            width: 100%;
            table-layout: fixed;     
            border-collapse: collapse;
            font-size: 6.5px;
            margin-bottom: 0;
        }

        table.items thead tr {
            background: #f1f5f9; 
            border-top: 2px solid #0e7490;
            border-bottom: 1px solid #cbd5e1;
        }
        table.items thead th {
            padding: 5px 4px;
            text-align: left;
            font-weight: 700;
            font-size: 6.5px;
            color: #334155;
            text-transform: uppercase;
            letter-spacing: 0.2px;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        table.items thead th.th-right  { text-align: right; }
        table.items thead th.th-center { text-align: center; }

        table.items tbody tr { border-bottom: 1px solid #f1f5f9; }
        table.items tbody tr:nth-child(even) { background: #f8fafc; }
        table.items tbody tr:nth-child(odd)  { background: #ffffff; }

        table.items tbody td {
            padding: 4px 4px;
            vertical-align: top;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        .td-right  { text-align: right; }
        .td-center { text-align: center; }
        .td-muted  { color: #94a3b8; }

        table.items tbody tr.empty-row td { height: 22px; }

        /* ════════════════════════════════
           TOTALS + NOTES 
        ════════════════════════════════ */
        .bottom-section {
            display: table;
            width: 100%;
            margin-top: 0;
            border: 1px solid #e2e8f0;
            border-top: none;
            border-radius: 0 0 6px 6px;
            overflow: hidden;
        }
        .notes-col  { display: table-cell; width: 55%; padding: 10px 14px; vertical-align: top; border-right: 1px solid #e2e8f0; }
        .totals-col { display: table-cell; width: 45%; padding: 10px 14px; vertical-align: top; background: #f8fafc; }

        .notes-title {
            font-size: 7.5px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 6px;
        }
        .notes-text { font-size: 8px; color: #475569; line-height: 1.6; }

        /* Total rows */
        .total-row {
            display: table;
            width: 100%;
            margin-bottom: 4px;
        }
        .total-label { display: table-cell; font-size: 8px; color: #64748b; text-align: right; padding-right: 12px; }
        .total-value { display: table-cell; font-size: 8.5px; font-weight: 600; color: #1e293b; text-align: right; width: 38%; }

        .total-divider {
            border: none;
            border-top: 1px solid #e2e8f0;
            margin: 6px 0;
        }

        /* Grand total highlight */
        .grand-total-row {
            display: table;
            width: 100%;
            background: #ccfbf1;
            border-radius: 5px;
            padding: 6px 8px;
            margin-top: 6px;
        }
        .grand-label { display: table-cell; font-size: 9px; font-weight: 700; color: #0f766e; text-align: right; padding-right: 12px; }
        .grand-value { display: table-cell; font-size: 11px; font-weight: 900; color: #0e7490; text-align: right; width: 55%; }

        /* ════════════════════════════════
           SIGNATURE 2 kolom
        ════════════════════════════════ */
        .sig-section { margin-top: 18px; }

        .sig-section-title {
            font-size: 7.5px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 8px;
            padding-bottom: 4px;
            border-bottom: 1px solid #e2e8f0;
        }

        /* Wrapper tabel 2 kolom */
        .sig-grid { display: table; width: 100%; border-collapse: separate; border-spacing: 16px 0; }
        .sig-col  {
            display: table-cell;
            width: 50%;
            text-align: center;
            padding: 12px 20px 10px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            background: #f8fafc;
            vertical-align: top;
        }

        .sig-role-label {
            font-size: 7.5px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            margin-bottom: 8px;
        }

        /* Area TTD kosong untuk tanda tangan fisik / digital */
        .sig-area {
            height: 44px;
            border: 1px dashed #cbd5e1;
            border-radius: 4px;
            background: #ffffff;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .sig-area img {
            max-height: 40px;
            max-width: 100%;
            object-fit: contain;
        }

        .sig-line {
            border-top: 1px solid #94a3b8;
            padding-top: 5px;
            font-size: 8.5px;
            font-weight: 700;
            color: #1e293b;
        }
        .sig-sub { font-size: 7.5px; color: #64748b; margin-top: 2px; }

        /* ════════════════════════════════
           FOOTER
        ════════════════════════════════ */
        .doc-footer {
            margin-top: 16px;
            padding-top: 10px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
        }
        .footer-thank {
            font-size: 9px;
            font-weight: 700;
            color: #0e7490;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        .footer-info {
            font-size: 7.5px;
            color: #94a3b8;
            line-height: 1.7;
        }

        /* ── Print overrides ── */
        @media print {
            body { padding: 14px 18px; }
            @page { size: A4 landscape; margin: 10mm 12mm; }
        }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <div class="header">
        <div class="header-left">
            <div class="header-brand">
                <div class="header-brand-text">
                    <div class="company-name">E-Quotation System</div>
                    <div class="company-tagline">Procurement Management Platform</div>
                    <div class="company-info">
                        {{ $supplier?->address ?? 'Jl. Procurement No. 1, Indonesia' }}<br>
                        Tel: {{ $supplier?->phone ?? '-' }}
                        @if($user?->email)
                            &nbsp;·&nbsp; {{ $user->email }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="header-right">
            <div class="doc-title">Purchase Order</div>
            <div><div class="doc-badge">✓ APPROVED</div></div>
        </div>
    </div>

     {{--  PO DETAIL  --}}
    <div class="info-section">
        {{-- Vendor / TO --}}
        <div class="info-col-to">
            <div class="info-group-title">To (Vendor / Supplier)</div>

            <div class="info-row">
                <span class="info-key">Perusahaan</span>
                <span class="info-val">{{ $supplier?->company_name ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">PIC</span>
                <span class="info-val">{{ $user?->name ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Alamat</span>
                <span class="info-val">{{ $supplier?->address ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Telepon</span>
                <span class="info-val">{{ $supplier?->phone ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Email</span>
                <span class="info-val">{{ $user?->email ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">NPWP</span>
                <span class="info-val">{{ $supplier?->npwp ?? '-' }}</span>
            </div>
        </div>

        {{-- Metadata PO --}}
        <div class="info-col-meta">
            <div class="info-group-title">Detail Dokumen</div>

            <div class="info-row">
                <span class="info-key">No. PO</span>
                <span class="info-val large">{{ $poNumber }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Tanggal PO</span>
                <span class="info-val">{{ $today }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">No. RFQ</span>
                <span class="info-val">{{ $batch?->batch_number ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Judul RFQ</span>
                <span class="info-val">{{ $batch?->title ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Kategori</span>
                <span class="info-val">{{ $category?->name ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Deadline RFQ</span>
                <span class="info-val">
                    {{ $batch?->deadline
                        ? \Carbon\Carbon::parse($batch->deadline)->translatedFormat('d F Y')
                        : '-' }}
                </span>
            </div>
            <div class="info-row">
                <span class="info-key">Prepared By</span>
                <span class="info-val">{{ $creator?->name ?? 'Admin Procurement' }}</span>
            </div>
        </div>
    </div>

    {{-- ITEMS TABLE--}}
    <div class="table-title">Detail Item Penawaran</div>
    <table class="items">
        <thead>
            <tr>
                <th style="width:2%;">#</th>
                <th style="width:5%;">Coll No.</th>
                <th style="width:6%;">RFQ No.</th>
                <th style="width:7%;">Vendor</th>
                <th class="th-center" style="width:4%;">No. Item</th>
                <th style="width:6%;">Material No.</th>
                <th style="width:14%;">Description</th>
                <th class="th-center" style="width:3%;">Qty</th>
                <th class="th-center" style="width:3%;">UoM</th>
                <th class="th-center" style="width:4%;">Currency</th>
                <th class="th-right" style="width:7%;">Net Price</th>
                <th style="width:5%;">Incoterm</th>
                <th style="width:6%;">Destination</th>
                <th style="width:6%;">Remark 1</th>
                <th style="width:6%;">Remark 2</th>
                <th class="th-center" style="width:5%;">Lead Time (Wks)</th>
                <th style="width:6%;">Payment Term</th>
                <th style="width:5%;">Quotation Date</th>
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
                <td colspan="18" class="td-center" style="padding:14px; color:#94a3b8;">
                    Data item tidak tersedia. File: {{ $quotation->file_name ?? 'Terlampir' }}
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- NOTES + TOTAL  --}}
    <div class="bottom-section">
        {{-- Notes / Instructions --}}
        <div class="notes-col">
            <div class="notes-title">Notes / Instructions</div>
            @if($quotation->note)
                <div class="notes-text">{{ $quotation->note }}</div>
            @else
                <div class="notes-text" style="color:#cbd5e1;">
                    Tidak ada catatan tambahan.
                </div>
            @endif
        </div>

        {{-- Total --}}
        <div class="totals-col">
            <div class="notes-title">Ringkasan Nilai</div>

            <div class="total-row">
                <span class="total-label">Sub Total</span>
                <span class="total-value">Rp {{ number_format($quotation->total_price ?? 0, 0, ',', '.') }}</span>
            </div>

            {{-- Tax & Discount--}}
            @if(isset($quotation->tax) && $quotation->tax > 0)
            <div class="total-row">
                <span class="total-label">Tax ({{ $quotation->tax_rate ?? '' }}%)</span>
                <span class="total-value">Rp {{ number_format($quotation->tax, 0, ',', '.') }}</span>
            </div>
            @endif

            @if(isset($quotation->discount) && $quotation->discount > 0)
            <div class="total-row">
                <span class="total-label">Discount</span>
                <span class="total-value">- Rp {{ number_format($quotation->discount, 0, ',', '.') }}</span>
            </div>
            @endif

            <hr class="total-divider">

            <div class="grand-total-row">
                <span class="grand-label">Grand Total</span>
                <span class="grand-value">
                    Rp {{ number_format($quotation->total_price ?? 0, 0, ',', '.') }}
                </span>
            </div>

            <div style="font-size:7px; color:#94a3b8; margin-top:6px; text-align:right;">
                Total {{ count($items) }} item penawaran
            </div>
        </div>
    </div>

    {{-- SIGNATURES 2 kolom--}}
    <div class="sig-section">
        <div class="sig-section-title">Tanda Tangan &amp; Persetujuan</div>
        <div class="sig-grid">

            {{-- Disetujui Oleh (Admin Procurement) --}}
            <div class="sig-col">
                <div class="sig-role-label">Disetujui Oleh</div>
                <div class="sig-area">
                    @if(isset($creatorSignature) && $creatorSignature)
                        <img src="{{ $creatorSignature }}" alt="Tanda Tangan Admin">
                    @endif
                </div>
                <div class="sig-line">{{ $creator?->name ?? 'Admin Procurement' }}</div>
                <div class="sig-sub">Admin Procurement</div>
            </div>

            {{-- Diterima Oleh (Vendor / PIC) --}}
            <div class="sig-col">
                <div class="sig-role-label">Diterima Oleh</div>
                <div class="sig-area">
                    @if(isset($vendorSignature) && $vendorSignature)
                        <img src="{{ $vendorSignature }}" alt="Tanda Tangan Vendor">
                    @endif
                </div>
                <div class="sig-line">{{ $user?->name ?? '-' }}</div>
                <div class="sig-sub">{{ $supplier?->company_name ?? '-' }}</div>
            </div>

        </div>
    </div>

    {{-- FOOTER --}}
    <div class="doc-footer">
        <div class="footer-thank">Thank You For Your Business</div>
        <div class="footer-info">
            E-Quotation System Procurement Management Platform<br>
            {{ $today }} &nbsp;·&nbsp; {{ $poNumber }}
            @if($user?->email)
                &nbsp;·&nbsp; {{ $user->email }}
            @endif
            <br>
            Dokumen ini digenerate otomatis &nbsp;·&nbsp; Sah tanpa tanda tangan basah
        </div>
    </div>

</body>
</html>