@extends('layouts.admin')
@section('page-title', 'Laporan')

@section('content')
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-xl font-bold text-gray-800 dark:text-white">Laporan & Statistik</h1>
                <p class="text-sm text-gray-500 mt-0.5">Ringkasan aktivitas pengadaan</p>
            </div>
            <a href="/api/admin/reports/export-pdf" target="_blank"
                class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3M3 17v3a2 2 0 002 2h14a2 2 0 002-2v-3" />
                </svg>
                Export PDF
            </a>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-5">
                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <p id="stBatch" class="text-2xl font-bold text-gray-800 dark:text-white">—</p>
                <p class="text-xs text-gray-500 mt-0.5">Total Batch RFQ</p>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-5">
                <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <p id="stApproved" class="text-2xl font-bold text-gray-800 dark:text-white">—</p>
                <p class="text-xs text-gray-500 mt-0.5">Penawaran Disetujui</p>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-5">
                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <p id="stSupplier" class="text-2xl font-bold text-gray-800 dark:text-white">—</p>
                <p class="text-xs text-gray-500 mt-0.5">Supplier Aktif</p>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-5">
                <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-xl flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p id="stPending" class="text-2xl font-bold text-gray-800 dark:text-white">—</p>
                <p class="text-xs text-gray-500 mt-0.5">Penawaran Pending</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">
            <!-- Status Batch -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6">
                <h3 class="font-semibold text-gray-800 dark:text-white mb-4">Distribusi Status Batch</h3>
                <div id="batchStatusChart" class="space-y-3 text-sm"></div>
            </div>

            <!-- Top Supplier -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6">
                <h3 class="font-semibold text-gray-800 dark:text-white mb-4">Supplier Paling Aktif</h3>
                <div id="topSuppliers" class="space-y-3"></div>
            </div>
        </div>

        <!-- Approved Table -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800">
                <h3 class="font-semibold text-gray-800 dark:text-white">Penawaran Disetujui Terbaru</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-800/60">
                        <tr>
                            <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">#</th>
                            <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Batch</th>
                            <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Supplier</th>
                            <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Total Harga</th>
                            <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Tgl Approve</th>
                            <th class="text-right px-5 py-3.5 text-xs font-semibold text-gray-500">PO</th>
                        </tr>
                    </thead>
                    <tbody id="approvedTable">
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-sm text-gray-400">Memuat...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        async function loadReports() {
            try {
                const res = await fetch('/api/admin/reports', {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                const data = await res.json();

                if (!res.ok || !data.success) throw new Error(data.message || 'Gagal memuat');

                document.getElementById('stBatch').textContent = data.total_batches ?? 0;
                document.getElementById('stApproved').textContent = data.total_approved ?? 0;
                document.getElementById('stSupplier').textContent = data.total_active_suppliers ?? 0;
                document.getElementById('stPending').textContent = data.total_pending ?? 0;

                // Status chart
                const statusColors = {
                    open: 'bg-green-500',
                    draft: 'bg-gray-400',
                    closed: 'bg-red-500',
                    awarded: 'bg-purple-500'
                };
                const total = (data.batch_by_status || []).reduce((s, x) => s + parseInt(x.count || 0), 0);
                document.getElementById('batchStatusChart').innerHTML = (data.batch_by_status || []).map(s => `
            <div>
                <div class="flex justify-between text-xs text-gray-500 mb-1">
                    <span class="capitalize font-medium">${s.status || 'unknown'}</span>
                    <span>${s.count} batch</span>
                </div>
                <div class="h-2 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
                    <div class="${statusColors[s.status] || 'bg-gray-400'} h-full rounded-full" style="width:${total ? (s.count/total*100).toFixed(1) : 0}%"></div>
                </div>
            </div>`).join('') || '<p class="text-gray-400 text-sm">Belum ada data</p>';

                // Top suppliers
                document.getElementById('topSuppliers').innerHTML = (data.top_suppliers || []).map((s, i) => `
            <div class="flex items-center gap-3">
                <div class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-xs font-bold flex items-center justify-center">${i+1}</div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 dark:text-white truncate">${s.company_name || '-'}</p>
                    <p class="text-xs text-gray-400">${s.quotation_count || 0} penawaran · ${s.approved_count || 0} menang</p>
                </div>
            </div>`).join('') || '<p class="text-gray-400 text-sm">Belum ada data</p>';

                // Approved table
                const tbody = document.getElementById('approvedTable');
                const approved = data.recent_approved || [];
                tbody.innerHTML = approved.length ? approved.map((q, i) => `
            <tr class="border-t border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800/30">
                <td class="px-5 py-3.5 text-xs text-gray-400">${i+1}</td>
                <td class="px-5 py-3.5">
                    <p class="text-sm font-medium text-gray-800 dark:text-white">${q.batch_title || '-'}</p>
                    <p class="text-xs text-gray-400">${q.batch_number || ''}</p>
                </td>
                <td class="px-5 py-3.5 text-sm text-gray-700 dark:text-gray-300">${q.company_name || '-'}</td>
                <td class="px-5 py-3.5 font-semibold text-green-600">Rp ${parseInt(q.total_price || 0).toLocaleString('id-ID')}</td>
                <td class="px-5 py-3.5 text-xs text-gray-500">${q.updated_at ? new Date(q.updated_at).toLocaleDateString('id-ID') : '-'}</td>
                <td class="px-5 py-3.5 text-right">
                    ${q.po_file_path ? `<a href="/storage/${q.po_file_path}" target="_blank" class="inline-flex items-center gap-1 text-blue-600 hover:underline text-xs font-medium">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17v3a2 2 0 002 2h14a2 2 0 002-2v-3"/></svg>
                            Download PO
                        </a>` : '—'}
                </td>
            </tr>`).join('') :
                    '<tr><td colspan="6" class="px-5 py-6 text-center text-sm text-gray-400">Belum ada penawaran disetujui.</td></tr>';

            } catch (e) {
                console.error('Report load error:', e);
            }
        }

        loadReports();
    </script>
@endsection
