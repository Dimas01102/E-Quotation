@extends('layouts.admin')
@section('page-title', 'Dashboard')

@section('content')
    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6">
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-5">
            <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white" id="stat-suppliers">—</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Total Supplier</p>
            <p class="text-xs mt-1 font-medium">
                <span id="stat-active-s" class="text-green-600">—</span> aktif ·
                <span id="stat-pending-s" class="text-amber-600">—</span> pending
            </p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-5">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white" id="stat-batch">—</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Total Batch RFQ</p>
            <p class="text-xs mt-1 font-medium">
                <span id="stat-open-batch" class="text-emerald-600">—</span> open ·
                <span id="stat-draft-batch" class="text-gray-500">—</span> draft
            </p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-5">
            <div class="w-10 h-10 rounded-xl bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white" id="stat-quo">—</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Total Quotation</p>
            <p class="text-xs text-amber-600 mt-1 font-medium"><span id="stat-submitted">—</span> menunggu review</p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-5">
            <div class="w-10 h-10 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white" id="stat-approved">—</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Quotation Disetujui</p>
        </div>
    </div>

    <!-- Pending Alert -->
    <div id="pending-alert" style="display:none"
        class="mb-6 items-center gap-3 rounded-2xl border border-amber-200 bg-amber-50 p-4 dark:border-amber-700 dark:bg-amber-900/20">
        <svg class="h-5 w-5 flex-shrink-0 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        <p class="flex-1 text-sm text-amber-700 dark:text-amber-300">
            <span id="pending-count" class="font-bold"></span> supplier menunggu aktivasi.
            <a href="/admin/suppliers" class="font-semibold underline">Aktivasi sekarang →</a>
        </p>
    </div>

    <!-- Tables -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <!-- Recent Batches -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800">
            <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 px-5 py-4">
                <h3 class="text-sm font-bold text-gray-800 dark:text-white">Batch RFQ Terbaru</h3>
                <a href="/admin/batches" class="text-xs font-medium text-blue-500 hover:text-blue-600">Lihat semua →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500">No. Batch</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500">Judul</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500">Deadline</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500">Status</th>
                        </tr>
                    </thead>
                    <tbody id="recent-batch-body">
                        <tr>
                            <td colspan="4" class="px-5 py-8 text-center text-sm text-gray-400">Memuat...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Quotations -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800">
            <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 px-5 py-4">
                <h3 class="text-sm font-bold text-gray-800 dark:text-white">Quotation Terbaru</h3>
                <a href="/admin/quotations" class="text-xs font-medium text-blue-500 hover:text-blue-600">Lihat semua →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500">Supplier</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500">Batch</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500">Total Harga</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500">Status</th>
                        </tr>
                    </thead>
                    <tbody id="recent-quo-body">
                        <tr>
                            <td colspan="4" class="px-5 py-8 text-center text-sm text-gray-400">Memuat...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '';

        function statusBadge(s) {
            const map = {
                open: 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                draft: 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400',
                closed: 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400',
                awarded: 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                pending: 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                approved: 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                rejected: 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400',
            };
            return `<span class="px-2 py-0.5 rounded-full text-xs font-medium ${map[s] || 'bg-gray-100 text-gray-600'}">${s || '-'}</span>`;
        }

        function fmtDate(d) {
            if (!d) return '-';
            return new Date(d).toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            });
        }

        function fmtRp(n) {
            if (!n) return '-';
            return 'Rp ' + parseInt(n).toLocaleString('id-ID');
        }

        async function loadDashboard() {
            try {
                const res = await fetch('/api/admin/dashboard', {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF
                    }
                });

                if (!res.ok) throw new Error('HTTP ' + res.status);
                const data = await res.json();

                // Stats
                const s = data.suppliers || {};
                const b = data.batches || {};
                const q = data.quotations || {};

                document.getElementById('stat-suppliers').textContent = s.total ?? 0;
                document.getElementById('stat-active-s').textContent = s.active ?? 0;
                document.getElementById('stat-pending-s').textContent = s.pending ?? 0;
                document.getElementById('stat-batch').textContent = b.total ?? 0;
                document.getElementById('stat-open-batch').textContent = b.open ?? 0;
                document.getElementById('stat-draft-batch').textContent = b.draft ?? 0;
                document.getElementById('stat-quo').textContent = q.total ?? 0;
                document.getElementById('stat-submitted').textContent = q.pending ?? 0;
                document.getElementById('stat-approved').textContent = q.approved ?? 0;

                // Pending alert
                if ((s.pending ?? 0) > 0) {
                    document.getElementById('pending-count').textContent = s.pending;
                    document.getElementById('pending-alert').style.display = 'flex';
                }

                // Recent Batches
                const bBody = document.getElementById('recent-batch-body');
                const batches = data.recent_batches || [];
                bBody.innerHTML = batches.length ?
                    batches.map(b => `
                <tr class="border-b border-gray-50 dark:border-gray-800/50 hover:bg-gray-50 dark:hover:bg-gray-800/30">
                    <td class="px-5 py-3.5">
                        <a href="/admin/batches/${b.id_batch}" class="text-xs font-bold text-blue-600 hover:underline">${b.batch_number}</a>
                    </td>
                    <td class="px-5 py-3.5 text-xs text-gray-700 dark:text-gray-300 max-w-[140px] truncate">${b.title}</td>
                    <td class="px-5 py-3.5 text-xs text-gray-500">${fmtDate(b.deadline)}</td>
                    <td class="px-5 py-3.5">${statusBadge(b.status)}</td>
                </tr>`).join('') :
                    '<tr><td colspan="4" class="px-5 py-6 text-center text-sm text-gray-400">Belum ada batch RFQ.</td></tr>';

                // Recent Quotations
                const qBody = document.getElementById('recent-quo-body');
                const quotations = data.recent_quotations || [];
                qBody.innerHTML = quotations.length ?
                    quotations.map(q => `
                <tr class="border-b border-gray-50 dark:border-gray-800/50 hover:bg-gray-50 dark:hover:bg-gray-800/30">
                    <td class="px-5 py-3.5 text-sm font-medium text-gray-800 dark:text-white">${q.company_name || '-'}</td>
                    <td class="px-5 py-3.5 text-xs text-gray-500 max-w-[120px] truncate">${q.batch_title || '-'}</td>
                    <td class="px-5 py-3.5 text-sm font-bold text-gray-800 dark:text-white">${fmtRp(q.total_price)}</td>
                    <td class="px-5 py-3.5">${statusBadge(q.status)}</td>
                </tr>`).join('') :
                    '<tr><td colspan="4" class="px-5 py-6 text-center text-sm text-gray-400">Belum ada quotation.</td></tr>';

            } catch (e) {
                console.error('Dashboard load error:', e);
                document.getElementById('recent-batch-body').innerHTML =
                    '<tr><td colspan="4" class="px-5 py-6 text-center text-sm text-red-400">Gagal memuat data. Pastikan API berjalan.</td></tr>';
                document.getElementById('recent-quo-body').innerHTML =
                    '<tr><td colspan="4" class="px-5 py-6 text-center text-sm text-red-400">Gagal memuat data.</td></tr>';
            }
        }

        loadDashboard();
    </script>
@endsection
