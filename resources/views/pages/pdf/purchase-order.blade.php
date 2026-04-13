<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order - {{ $po->po_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #1f2937;
            background: #fff;
            padding: 40px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #1e40af;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-icon {
            width: 44px;
            height: 44px;
            background: #1e40af;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-name {
            font-size: 22px;
            font-weight: 900;
            color: #1e40af;
        }

        .po-info {
            text-align: right;
        }

        .po-number {
            font-size: 18px;
            font-weight: 900;
            color: #1e40af;
        }

        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 4px;
        }

        .badge-issued {
            background: #e0e7ff;
            color: #3730a3;
        }

        .badge-ack {
            background: #d1fae5;
            color: #065f46;
        }

        .section-title {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #6b7280;
            margin-bottom: 8px;
            margin-top: 20px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 20px;
        }

        .info-card {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 12px 16px;
        }

        .info-card p.label {
            font-size: 10px;
            color: #6b7280;
            margin-bottom: 2px;
        }

        .info-card p.value {
            font-weight: 700;
            color: #111827;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 16px 0;
        }

        thead th {
            background: #1e40af;
            color: #fff;
            padding: 10px 12px;
            text-align: left;
            font-size: 11px;
            font-weight: 700;
        }

        thead th:last-child,
        thead th:nth-child(3),
        thead th:nth-child(4) {
            text-align: right;
        }

        tbody td {
            padding: 10px 12px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 12px;
        }

        tbody td:last-child,
        tbody td:nth-child(3),
        tbody td:nth-child(4) {
            text-align: right;
        }

        tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        tfoot td {
            padding: 10px 12px;
            font-weight: 700;
            border-top: 2px solid #1e40af;
        }

        .total-row td {
            font-size: 14px;
            color: #1e40af;
        }

        .footer-info {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
        }

        .sign-block {
            text-align: center;
        }

        .sign-line {
            border-top: 1px solid #374151;
            margin-top: 50px;
            padding-top: 6px;
            font-size: 11px;
            color: #6b7280;
        }

        .stamp {
            margin-top: 30px;
            text-align: center;
            background: #f0fdf4;
            border: 2px solid #16a34a;
            border-radius: 12px;
            padding: 12px;
            color: #15803d;
            font-weight: 900;
            font-size: 13px;
            letter-spacing: 2px;
        }

        @media print {
            body {
                padding: 20px;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <!-- Print button -->
    <div class="no-print" style="text-align:right;margin-bottom:20px;">
        <button onclick="window.print()"
            style="padding:10px 24px;background:#1e40af;color:#fff;border:none;border-radius:10px;font-size:13px;font-weight:700;cursor:pointer;">
            🖨 Cetak / Download PDF
        </button>
    </div>

    <!-- Header -->
    <div class="header">
        <div class="brand">
            <div class="brand-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <div>
                <div class="brand-name">RFQSystem</div>
                <div style="font-size:10px;color:#6b7280;">E-Procurement Platform</div>
            </div>
        </div>
        <div class="po-info">
            <div style="font-size:11px;color:#6b7280;font-weight:600;text-transform:uppercase;letter-spacing:1px;">
                Purchase Order</div>
            <div class="po-number">{{ $po->po_number }}</div>
            <span
                class="badge {{ $po->status === 'issued' ? 'badge-issued' : 'badge-ack' }}">{{ strtoupper($po->status) }}</span>
        </div>
    </div>

    <!-- Info Grid -->
    <div class="info-grid">
        <div>
            <div class="section-title">Kepada (Supplier)</div>
            <div class="info-card">
                <p class="value" style="font-size:14px;">{{ $po->supplier->company_name ?? '-' }}</p>
                <p class="label" style="margin-top:4px;">{{ $po->supplier->user->email ?? '-' }}</p>
                <p class="label">{{ $po->supplier->phone ?? '' }}</p>
                @if ($po->supplier->address)
                    <p class="label" style="margin-top:4px;">{{ $po->supplier->address }}, {{ $po->supplier->city }}
                    </p>
                @endif
                @if ($po->supplier->npwp)
                    <p class="label">NPWP: {{ $po->supplier->npwp }}</p>
                @endif
            </div>
        </div>
        <div>
            <div class="section-title">Detail PO</div>
            <div class="info-card">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                    <div>
                        <p class="label">No. RFQ</p>
                        <p class="value" style="font-size:11px;">{{ $po->rfqBatch->rfq_number ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="label">Diterbitkan</p>
                        <p class="value" style="font-size:11px;">
                            {{ $po->issued_at ? $po->issued_at->format('d M Y') : '-' }}</p>
                    </div>
                    <div>
                        <p class="label">Syarat Bayar</p>
                        <p class="value" style="font-size:11px;">{{ $po->payment_terms ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="label">Batas Kirim</p>
                        <p class="value" style="font-size:11px;">
                            {{ $po->delivery_deadline ? $po->delivery_deadline->format('d M Y') : '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($po->delivery_address)
        <div style="margin-bottom:16px;">
            <div class="section-title">Alamat Pengiriman</div>
            <div class="info-card">
                <p class="value">{{ $po->delivery_address }}</p>
            </div>
        </div>
    @endif

    <!-- Items Table -->
    <div class="section-title">Detail Item</div>
    <table>
        <thead>
            <tr>
                <th style="width:40px;">#</th>
                <th>Nama Item</th>
                <th>Satuan</th>
                <th>Qty</th>
                <th>Harga Satuan</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($po->quotation->quotationItems ?? [] as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                        <strong>{{ $item->rfqItem->item->name ?? '-' }}</strong><br>
                        <span style="color:#6b7280;font-size:10px;">{{ $item->rfqItem->item->code ?? '' }}</span>
                    </td>
                    <td>{{ $item->rfqItem->item->unit ?? '-' }}</td>
                    <td>{{ number_format($item->qty, 2, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                    <td><strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong></td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="5" style="text-align:right;font-size:13px;">TOTAL PEMBAYARAN</td>
                <td style="font-size:16px;">Rp {{ number_format($po->total_amount, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    @if ($po->notes)
        <div style="margin:16px 0;padding:12px 16px;background:#fffbeb;border:1px solid #fcd34d;border-radius:10px;">
            <p style="font-size:10px;font-weight:700;color:#92400e;margin-bottom:4px;">CATATAN</p>
            <p style="color:#78350f;">{{ $po->notes }}</p>
        </div>
    @endif

    <!-- Signature -->
    <div class="footer-info">
        <div class="sign-block">
            <div class="sign-line">Dibuat oleh<br><strong>{{ $po->issuedBy->name ?? '-' }}</strong></div>
        </div>
        <div class="sign-block">
            <div class="stamp">✓ DITERBITKAN</div>
        </div>
        <div class="sign-block">
            <div class="sign-line">Diterima oleh<br><strong>{{ $po->supplier->company_name ?? '-' }}</strong></div>
        </div>
    </div>

    <div style="text-align:center;margin-top:30px;color:#9ca3af;font-size:10px;">
        Dokumen ini diterbitkan secara elektronik oleh sistem RFQ dan sah tanpa tanda tangan basah.<br>
        Dicetak pada: {{ now()->format('d M Y H:i') }} WIB
    </div>

</body>

</html>
