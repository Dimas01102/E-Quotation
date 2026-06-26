@extends('layouts.admin')
@section('page-title', 'Manajemen Quotation')

@section('content')
    <div class="p-6">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-xl font-bold text-gray-800 dark:text-white">Manajemen Quotation</h1>
                <p class="text-sm text-gray-500 mt-0.5">Review, approve, reject, dan compare penawaran supplier</p>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-4 gap-4 mb-6">
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4">
                <p id="stTotal" class="text-2xl font-bold text-gray-800 dark:text-white">—</p>
                <p class="text-xs text-gray-500 mt-0.5">Total Penawaran</p>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4">
                <p id="stPending" class="text-2xl font-bold text-amber-500">—</p>
                <p class="text-xs text-gray-500 mt-0.5">Menunggu Review</p>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4">
                <p id="stApproved" class="text-2xl font-bold text-green-500">—</p>
                <p class="text-xs text-gray-500 mt-0.5">Disetujui</p>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4">
                <p id="stRejected" class="text-2xl font-bold text-red-500">—</p>
                <p class="text-xs text-gray-500 mt-0.5">Ditolak</p>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 overflow-hidden">
            <!-- Filter -->
            <div class="p-4 border-b border-gray-100 dark:border-gray-800 flex items-center gap-3">
                <div class="relative flex-1 max-w-xs">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input id="searchInput" type="text" placeholder="Cari supplier, no. RFQ..."
                        class="w-full pl-9 pr-4 py-2 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 dark:text-white"
                        oninput="doFilter()">
                </div>
                <select id="statusFilter" onchange="doFilter()"
                    class="text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2 focus:outline-none text-gray-800 dark:text-white">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-800/60">
                        <tr>
                            <th class="text-left px-4 py-3.5 text-xs font-semibold text-gray-500 whitespace-nowrap">#</th>
                            <th class="text-left px-4 py-3.5 text-xs font-semibold text-gray-500 whitespace-nowrap">Supplier
                            </th>
                            <th class="text-left px-4 py-3.5 text-xs font-semibold text-gray-500 whitespace-nowrap">No. RFQ
                            </th>
                            <th class="text-left px-4 py-3.5 text-xs font-semibold text-gray-500 whitespace-nowrap">Kategori
                            </th>
                            <th class="text-left px-4 py-3.5 text-xs font-semibold text-gray-500 whitespace-nowrap">File
                                Excel</th>
                            <th class="text-right px-4 py-3.5 text-xs font-semibold text-gray-500 whitespace-nowrap">Total
                                Harga</th>
                            <th class="text-left px-4 py-3.5 text-xs font-semibold text-gray-500 whitespace-nowrap">Tgl
                                Submit</th>
                            <th class="text-center px-4 py-3.5 text-xs font-semibold text-gray-500 whitespace-nowrap">Status
                            </th>
                            <th class="text-right px-4 py-3.5 text-xs font-semibold text-gray-500 whitespace-nowrap">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody id="quotTable">
                        <tr>
                            <td colspan="9" class="px-5 py-8 text-center text-sm text-gray-400">Memuat...</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination Component -->
            <x-pagination id="paginasiQuotation" />
        </div>
    </div>

    <!-- Detail Modal -->
    <div id="detailModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm"
        style="display:none">
        <div
            class="bg-white dark:bg-gray-900 rounded-2xl w-full max-w-[96vw] mx-4 shadow-2xl border border-gray-200 dark:border-gray-700 max-h-[95vh] flex flex-col">
            <div
                class="flex items-start justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex-shrink-0">
                <div>
                    <h3 id="dtTitle" class="font-semibold text-gray-800 dark:text-white text-base">Detail Penawaran</h3>
                    <p id="dtSub" class="text-xs text-gray-400 mt-0.5"></p>
                </div>
                <button onclick="hideModal('detailModal')" class="text-gray-400 hover:text-gray-600 mt-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div id="dtInfo"
                class="px-6 py-4 grid grid-cols-2 md:grid-cols-6 gap-4 border-b border-gray-100 dark:border-gray-800 flex-shrink-0 bg-gray-50 dark:bg-gray-800/30 text-sm">
            </div>
            <div id="dtActions"
                class="px-6 py-3 flex items-center gap-3 border-b border-gray-100 dark:border-gray-800 flex-shrink-0"></div>
            <div class="flex-1 overflow-auto">
                <div class="px-6 pt-4 pb-2 flex items-center justify-between">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Detail Item 17 kolom sesuai file
                        Excel</p>
                    <span id="dtCount" class="text-xs text-gray-400"></span>
                </div>
                <div class="px-6 pb-6 overflow-x-auto">
                    <div id="dtTable"></div>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800 flex gap-3 flex-shrink-0">
                <div id="dtFooterBtns" class="flex gap-3 flex-1"></div>
                <button onclick="hideModal('detailModal')"
                    class="px-5 py-2.5 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 rounded-xl text-sm hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Compare Modal -->
    <div id="compareModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm"
        style="display:none">
        <div
            class="bg-white dark:bg-gray-900 rounded-2xl w-full max-w-5xl mx-4 shadow-2xl border border-gray-200 dark:border-gray-700 max-h-[90vh] flex flex-col">
            <div
                class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex-shrink-0">
                <div>
                    <h3 class="font-semibold text-gray-800 dark:text-white">Perbandingan Harga</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Diurutkan dari harga terendah ke tertinggi</p>
                </div>
                <button onclick="hideModal('compareModal')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div id="compareContent" class="overflow-y-auto flex-1 p-6"></div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm"
        style="display:none">
        <div
            class="bg-white dark:bg-gray-900 rounded-2xl w-full max-w-sm mx-4 p-6 shadow-2xl border border-gray-200 dark:border-gray-700">
            <h3 class="font-semibold text-gray-800 dark:text-white mb-4">Tolak Penawaran</h3>
            <input type="hidden" id="rejectId">
            <label class="block text-sm text-gray-600 dark:text-gray-400 mb-2">Alasan penolakan <span
                    class="text-red-500">*</span></label>
            <textarea id="rejectNote" rows="3" placeholder="Tulis alasan penolakan..."
                class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 text-gray-800 dark:text-white resize-none mb-4"></textarea>
            <div class="flex gap-3">
                <button onclick="submitReject()"
                    class="flex-1 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm font-medium">Tolak</button>
                <button onclick="hideModal('rejectModal')"
                    class="flex-1 py-2.5 border border-gray-200 dark:border-gray-700 text-gray-600 rounded-xl text-sm">Batal</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let allQ = [];
        let filteredQ = [];

        const PAGINATION_ID = 'paginasiQuotation';

        const sCls = {
            pending: 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
            approved: 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
            rejected: 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400',
        };

        function esc(v) {
            if (v == null) return '—';
            return String(v).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
        }

        function capitalize(str) {
            return str ? str.charAt(0).toUpperCase() + str.slice(1) : '—';
        }

        function fmtDate(val) {
            if (!val) return '—';
            const d = new Date(val);
            return isNaN(d) ? val : d.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });
        }

        function fmtRp(val) {
            if (val === null || val === undefined || val === '') return '—';
            return 'Rp ' + Number(val).toLocaleString('id-ID');
        }

        function hideModal(id) {
            document.getElementById(id).style.display = 'none';
        }

        function showModal(id) {
            const el = document.getElementById(id);
            el.style.removeProperty('display');
            el.style.display = 'flex';
        }

        // ── Load ──────────────────────────────────────────────────────────
        async function loadQuotations() {
            try {
                const res = await fetch('/api/admin/quotations', {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                const json = await res.json();
                if (!res.ok) throw new Error(json.message || 'Error');
                allQ = json.quotations || [];

                document.getElementById('stTotal').textContent = allQ.length;
                document.getElementById('stPending').textContent = allQ.filter(q => q.status === 'pending').length;
                document.getElementById('stApproved').textContent = allQ.filter(q => q.status === 'approved').length;
                document.getElementById('stRejected').textContent = allQ.filter(q => q.status === 'rejected').length;

                filteredQ = allQ;
                Pagination.init(PAGINATION_ID, filteredQ.length, 10, renderPage);
                renderPage(1, 10);
            } catch (e) {
                document.getElementById('quotTable').innerHTML =
                    `<tr><td colspan="9" class="px-5 py-6 text-center text-sm text-red-400">Gagal memuat: ${e.message}</td></tr>`;
            }
        }

        function renderPage(page, perPage) {
            const start = (page - 1) * perPage;
            renderTable(filteredQ.slice(start, start + perPage), start);
        }

        function renderTable(list, offset = 0) {
            const tb = document.getElementById('quotTable');
            if (!list.length) {
                tb.innerHTML =
                    '<tr><td colspan="9" class="px-5 py-6 text-center text-sm text-gray-400">Tidak ada data penawaran.</td></tr>';
                return;
            }
            tb.innerHTML = list.map((q, i) => {
                const company = q.invited_supplier?.supplier?.company_name ?? '—';
                const picName = q.invited_supplier?.supplier?.user?.name ?? '';
                const batchNum = q.invited_supplier?.batch_category?.batch?.batch_number ?? '—';
                const catName = q.invited_supplier?.batch_category?.master_category?.name ?? '—';
                const batchId = q.invited_supplier?.batch_category?.id_batch ?? null;
                return `
<tr class="border-t border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800/30">
    <td class="px-4 py-3.5 text-xs text-gray-400">${offset + i + 1}</td>
    <td class="px-4 py-3.5">
        <p class="font-medium text-gray-800 dark:text-white text-sm">${esc(company)}</p>
        <p class="text-xs text-gray-400 mt-0.5">${esc(picName)}</p>
    </td>
    <td class="px-4 py-3.5">
        <span class="font-mono text-sm font-bold text-blue-600 dark:text-blue-400">${esc(batchNum)}</span>
    </td>
    <td class="px-4 py-3.5">
        <span class="px-2.5 py-1 bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400 rounded-full text-xs font-medium">${esc(catName)}</span>
    </td>
    <td class="px-4 py-3.5">
        ${q.file_path
            ? `<a href="/storage/${q.file_path}" target="_blank"
                    class="inline-flex items-center gap-1 text-blue-600 hover:underline text-xs font-medium">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    ${esc(q.file_name) || 'Download'}
                   </a>`
            : '<span class="text-gray-400 text-xs">—</span>'}
    </td>
    <td class="px-4 py-3.5 text-right">
        <span class="font-semibold text-sm ${q.status === 'approved' ? 'text-green-600' : 'text-gray-800 dark:text-white'}">${fmtRp(q.total_price)}</span>
    </td>
    <td class="px-4 py-3.5 text-xs text-gray-500 whitespace-nowrap">${fmtDate(q.submitted_at)}</td>
    <td class="px-4 py-3.5 text-center">
        <span class="px-2.5 py-1 rounded-full text-xs font-medium ${sCls[q.status] || 'bg-gray-100 text-gray-600'}">${capitalize(q.status)}</span>
    </td>
    <td class="px-4 py-3.5 text-right">
        <div class="flex items-center justify-end gap-1.5 flex-wrap">
            <button onclick="viewDetail(${q.id_quotation})"
                class="inline-flex items-center gap-1 px-3 py-1.5 bg-gray-50 hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-400 rounded-lg text-xs font-medium transition-colors whitespace-nowrap">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                Detail
            </button>
            ${batchId ? `
                <button onclick="comparePrice(${batchId})"
                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-purple-50 hover:bg-purple-100 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 rounded-lg text-xs font-medium transition-colors whitespace-nowrap">
                    Compare
                </button>` : ''}
            ${q.status === 'pending' ? `
                <button onclick="doApprove(${q.id_quotation})"
                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-green-50 hover:bg-green-100 dark:bg-green-900/20 text-green-600 dark:text-green-400 rounded-lg text-xs font-medium transition-colors whitespace-nowrap">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Approve
                </button>
                <button onclick="openReject(${q.id_quotation})"
                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 hover:bg-red-100 dark:bg-red-900/20 text-red-600 dark:text-red-400 rounded-lg text-xs font-medium transition-colors whitespace-nowrap">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Reject
                </button>` : ''}
            ${q.status === 'approved' && q.po_file_path ? `
                <a href="/storage/${q.po_file_path}" target="_blank"
                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg text-xs font-medium transition-colors whitespace-nowrap">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17v3a2 2 0 002 2h14a2 2 0 002-2v-3"/></svg>
                    PO PDF
                </a>` : ''}
        </div>
    </td>
</tr>`;
            }).join('');
        }

        function doFilter() {
            const s = document.getElementById('statusFilter').value;
            const q = document.getElementById('searchInput').value.toLowerCase().trim();
            filteredQ = allQ.filter(item => {
                const matchStatus = !s || item.status === s;
                const company = (item.invited_supplier?.supplier?.company_name || '').toLowerCase();
                const batchNum = (item.invited_supplier?.batch_category?.batch?.batch_number || '').toLowerCase();
                const matchQ = !q || company.includes(q) || batchNum.includes(q);
                return matchStatus && matchQ;
            });
            Pagination.update(PAGINATION_ID, filteredQ.length);
            renderPage(Pagination.currentPage(PAGINATION_ID), Pagination.currentPerPage(PAGINATION_ID));
        }

        // ── View Detail ───────────────────────────────────────────────────
        async function viewDetail(id) {
            document.getElementById('dtTitle').textContent = 'Memuat...';
            document.getElementById('dtSub').textContent = '';
            document.getElementById('dtInfo').innerHTML =
                '<div class="col-span-6 text-gray-400 text-sm animate-pulse">Memuat...</div>';
            document.getElementById('dtActions').innerHTML = '';
            document.getElementById('dtTable').innerHTML =
                '<div class="py-8 text-center text-gray-400 text-sm">Memuat item...</div>';
            document.getElementById('dtFooterBtns').innerHTML = '';
            showModal('detailModal');

            try {
                const res = await fetch(`/api/admin/quotations/${id}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                const json = await res.json();
                if (!res.ok) throw new Error(json.message || 'Error');
                const q = json.quotation;

                const company = q.invited_supplier?.supplier?.company_name ?? '—';
                const batchNum = q.invited_supplier?.batch_category?.batch?.batch_number ?? '—';
                const catName = q.invited_supplier?.batch_category?.master_category?.name ?? '—';

                document.getElementById('dtTitle').textContent = company;
                document.getElementById('dtSub').textContent = batchNum + ' — ' + (q.invited_supplier?.batch_category
                    ?.batch?.title ?? '');

                document.getElementById('dtInfo').innerHTML =
                    `
            <div><p class="text-xs text-gray-400 mb-0.5">Supplier</p><p class="text-sm font-medium text-gray-800 dark:text-white">${esc(company)}</p></div>
            <div><p class="text-xs text-gray-400 mb-0.5">No. RFQ</p><p class="text-sm font-mono font-bold text-blue-600">${esc(batchNum)}</p></div>
            <div><p class="text-xs text-gray-400 mb-0.5">Kategori</p><p class="text-sm font-medium text-gray-800 dark:text-white">${esc(catName)}</p></div>
            <div><p class="text-xs text-gray-400 mb-0.5">Total Harga</p><p class="text-sm font-bold ${q.status === 'approved' ? 'text-green-600' : 'text-gray-800 dark:text-white'}">${fmtRp(q.total_price)}</p></div>
            <div><p class="text-xs text-gray-400 mb-0.5">Tgl Submit</p><p class="text-sm text-gray-700 dark:text-gray-300">${fmtDate(q.submitted_at)}</p></div>
            <div><p class="text-xs text-gray-400 mb-0.5">Status</p><span class="px-2.5 py-1 rounded-full text-xs font-medium ${sCls[q.status] || 'bg-gray-100 text-gray-600'}">${capitalize(q.status)}</span></div>`;

                let acts = '';
                if (q.file_download_url || q.file_path) {
                    const url = q.file_download_url || `/storage/${q.file_path}`;
                    acts += `<a href="${url}" target="_blank"
                class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 hover:bg-green-100 dark:bg-green-900/20 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-800 rounded-xl text-xs font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Download File Excel
            </a>`;
                }
                if (q.status === 'approved' && (q.po_download_url || q.po_file_path)) {
                    const poUrl = q.po_download_url || `/storage/${q.po_file_path}`;
                    acts += `<a href="${poUrl}" target="_blank"
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 border border-blue-200 dark:border-blue-800 rounded-xl text-xs font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17v3a2 2 0 002 2h14a2 2 0 002-2v-3"/></svg>
                Download PO PDF
            </a>`;
                }
                document.getElementById('dtActions').innerHTML = acts;

                const items = q.quotation_items || [];
                document.getElementById('dtCount').textContent = items.length ? items.length + ' item' : '';

                if (items.length) {
                    const cols = ['#', 'Coll No.', 'RFQ No.', 'Vendor', 'No. Item', 'Material No.', 'Description',
                        'Qty', 'UoM', 'Currency', 'Net Price', 'Incoterm', 'Destination', 'Remark 1', 'Remark 2',
                        'Lead Time (Weeks)', 'Payment Term', 'Quotation Date'
                    ];
                    const thead = cols.map(c =>
                        `<th class="px-3 py-2.5 text-left text-xs font-semibold text-white whitespace-nowrap">${c}</th>`
                        ).join('');
                    const tbody = items.map((item, i) => `
                <tr class="border-b border-gray-100 dark:border-gray-800 ${i%2===0?'bg-white dark:bg-gray-900':'bg-gray-50 dark:bg-gray-800/40'} hover:bg-blue-50/30 dark:hover:bg-blue-900/10 transition-colors">
                    <td class="px-3 py-2 text-xs text-gray-400">${i+1}</td>
                    <td class="px-3 py-2 text-xs text-gray-700 dark:text-gray-300 whitespace-nowrap">${esc(item.coll_no)}</td>
                    <td class="px-3 py-2 text-xs font-mono text-gray-700 dark:text-gray-300 whitespace-nowrap">${esc(item.rfq_no)}</td>
                    <td class="px-3 py-2 text-xs text-gray-700 dark:text-gray-300 whitespace-nowrap">${esc(item.vendor)}</td>
                    <td class="px-3 py-2 text-xs text-gray-700 dark:text-gray-300">${esc(item.no_item)}</td>
                    <td class="px-3 py-2 text-xs font-mono text-gray-700 dark:text-gray-300 whitespace-nowrap">${esc(item.material_no)}</td>
                    <td class="px-3 py-2 text-xs text-gray-700 dark:text-gray-300 max-w-[180px]" title="${esc(item.description)}">${esc(item.description)}</td>
                    <td class="px-3 py-2 text-xs text-center font-semibold text-gray-800 dark:text-white">${item.qty ?? '—'}</td>
                    <td class="px-3 py-2 text-xs text-center text-gray-600 dark:text-gray-400">${esc(item.uom)}</td>
                    <td class="px-3 py-2 text-xs text-center text-gray-600 dark:text-gray-400">${esc(item.currency)}</td>
                    <td class="px-3 py-2 text-xs text-right font-semibold text-gray-800 dark:text-white whitespace-nowrap">${item.net_price != null ? parseFloat(item.net_price).toLocaleString('id-ID',{minimumFractionDigits:2,maximumFractionDigits:2}) : '—'}</td>
                    <td class="px-3 py-2 text-xs text-gray-600 dark:text-gray-400 whitespace-nowrap">${esc(item.incoterm)}</td>
                    <td class="px-3 py-2 text-xs text-gray-600 dark:text-gray-400 whitespace-nowrap">${esc(item.destination)}</td>
                    <td class="px-3 py-2 text-xs text-gray-600 dark:text-gray-400">${esc(item.remark_1)}</td>
                    <td class="px-3 py-2 text-xs text-gray-600 dark:text-gray-400">${esc(item.remark_2)}</td>
                    <td class="px-3 py-2 text-xs text-center text-gray-600 dark:text-gray-400">${esc(item.lead_time_weeks)}</td>
                    <td class="px-3 py-2 text-xs text-gray-600 dark:text-gray-400 whitespace-nowrap">${esc(item.payment_term)}</td>
                    <td class="px-3 py-2 text-xs text-gray-600 dark:text-gray-400 whitespace-nowrap">${esc(item.quotation_date)}</td>
                </tr>`).join('');
                    const totalRow = `<tr class="bg-blue-50 dark:bg-blue-900/20 border-t-2 border-blue-200 dark:border-blue-700">
                <td colspan="10" class="px-3 py-3 font-bold text-gray-700 dark:text-white text-xs">TOTAL NILAI PENAWARAN</td>
                <td class="px-3 py-3 text-right font-bold text-blue-700 dark:text-blue-300 text-sm whitespace-nowrap">${fmtRp(q.total_price)}</td>
                <td colspan="7"></td>
            </tr>`;
                    document.getElementById('dtTable').innerHTML = `
                <table class="w-full border-collapse text-xs min-w-max">
                    <thead class="bg-blue-700 dark:bg-blue-800 sticky top-0 z-10"><tr>${thead}</tr></thead>
                    <tbody>${tbody}${totalRow}</tbody>
                </table>`;
                } else {
                    const xlUrl = q.file_download_url || (q.file_path ? `/storage/${q.file_path}` : null);
                    document.getElementById('dtTable').innerHTML = `
                <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl p-6 text-center">
                    <p class="text-amber-700 dark:text-amber-400 font-semibold text-sm">Data item belum terparse</p>
                    <p class="text-amber-600 dark:text-amber-500 text-xs mt-1 mb-3">Pastikan header file Excel sesuai format yang ditentukan.</p>
                    ${xlUrl ? `<a href="${xlUrl}" target="_blank" class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-medium transition-colors">Download File Excel Original</a>` : ''}
                </div>`;
                }

                let footer = '';
                if (q.status === 'pending') {
                    footer =
                        `
                <button onclick="hideModal('detailModal');doApprove(${q.id_quotation})"
                    class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl text-sm font-medium transition-colors">✓ Approve &amp; Generate PO</button>
                <button onclick="hideModal('detailModal');openReject(${q.id_quotation})"
                    class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm font-medium transition-colors">✕ Reject</button>`;
                }
                document.getElementById('dtFooterBtns').innerHTML = footer;

            } catch (e) {
                document.getElementById('dtTitle').textContent = 'Error';
                document.getElementById('dtInfo').innerHTML =
                    `<div class="col-span-6 text-red-400 text-sm">Gagal memuat: ${e.message}</div>`;
                document.getElementById('dtTable').innerHTML = '';
            }
        }

        // ── Compare ───────────────────────────────────────────────────────
        async function comparePrice(batchId) {
            document.getElementById('compareContent').innerHTML =
                '<div class="text-center py-12 text-gray-400 text-sm animate-pulse">Memuat perbandingan...</div>';
            showModal('compareModal');
            try {
                const res = await fetch(`/api/admin/quotations/compare/${batchId}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                const json = await res.json();
                if (!res.ok) throw new Error(json.message || 'Error');
                const list = json.quotations || [];
                if (!list.length) {
                    document.getElementById('compareContent').innerHTML =
                        '<div class="text-center py-12 text-gray-400 text-sm">Belum ada penawaran.</div>';
                    return;
                }

                const lowestPrice = parseFloat(list[0]?.total_price ?? 0);
                const statusBadge = {
                    pending: 'bg-amber-50 text-amber-600 border border-amber-200',
                    approved: 'bg-green-50 text-green-600 border border-green-200',
                    rejected: 'bg-red-50 text-red-500 border border-red-200',
                };

                const cards = list.map((q, i) => {
                    const isLowest = parseFloat(q.total_price) === lowestPrice && q.status !== 'rejected';
                    const isFirst = i === 0 && q.status !== 'rejected';
                    const isRejected = q.status === 'rejected';
                    const priceClass = isRejected ? 'line-through text-gray-400' : isLowest ?
                        'text-green-600 dark:text-green-400' : 'text-gray-800 dark:text-white';
                    const cardBorder = isLowest ?
                        'border-green-300 dark:border-green-700 ring-1 ring-green-200 dark:ring-green-900' :
                        'border-gray-200 dark:border-gray-800';

                    const winnerBadge = isLowest ?
                        `<span class="text-xs px-2 py-0.5 rounded-full bg-green-50 text-green-600 border border-green-200 font-medium">Harga Terendah</span>` :
                        '';

                    const actions = q.status === 'pending' ?
                        `<button onclick="hideModal('compareModal');doApprove(${q.id_quotation})"
                        class="px-3 py-1.5 bg-green-50 hover:bg-green-100 text-green-600 border border-green-200 rounded-lg text-xs font-medium">Approve</button>
                   <button onclick="hideModal('compareModal');openReject(${q.id_quotation})"
                        class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-500 border border-red-200 rounded-lg text-xs font-medium">Reject</button>` :
                        q.status === 'approved' && q.po_file_path ?
                        `<a href="/storage/${q.po_file_path}" target="_blank" class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 border border-blue-200 rounded-lg text-xs font-medium">Download PO</a>` :
                        `<span class="text-gray-400 text-xs">—</span>`;

                    return `
            <div class="relative bg-white dark:bg-gray-900 rounded-xl border ${cardBorder} shadow-sm hover:shadow-md transition-shadow p-4 flex flex-col gap-3 ${isRejected ? 'opacity-55' : ''}">
                <div class="flex items-center justify-between gap-2">
                    <div class="flex items-center gap-2">
                        <span class="w-7 h-7 flex items-center justify-center rounded-lg bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400">
                            ${isFirst ? `
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4 text-amber-500"
                            fill="currentColor"
                            viewBox="0 0 24 24">
                            <path d="M18 2H6v3H3v2a5 5 0 005 5 5.98 5.98 0 003 2.65V17H8v2h8v-2h-3v-2.35A5.98 5.98 0 0016 12a5 5 0 005-5V5h-3V2zm-2 2v4a4 4 0 11-8 0V4h8zM5 7V7h1v2.83A3.01 3.01 0 015 7zm14 0a3.01 3.01 0 01-1 2.83V7h1z"/>
                        </svg>
                            ` : `<span class="text-xs font-semibold text-gray-500">${i + 1}</span>`}
                        </span>
                        ${winnerBadge}
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium ${statusBadge[q.status] || 'bg-gray-100 text-gray-500'}">${capitalize(q.status)}</span>
                </div>
                <div>
                    <p class="font-semibold text-sm text-gray-800 dark:text-white truncate">${esc(q.invited_supplier?.supplier?.company_name)}</p>
                    <p class="text-xs text-gray-400 mt-0.5 truncate">${esc(q.invited_supplier?.supplier?.user?.email)}</p>
                </div>
                <div class="border-t border-gray-100 dark:border-gray-800"></div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Total harga</p>
                    <p class="font-bold text-lg leading-tight ${priceClass}">${fmtRp(q.total_price)}</p>
                </div>
                ${q.file_path ? `<a href="/storage/${q.file_path}" target="_blank" class="text-xs text-blue-500 hover:underline truncate">File penawaran</a>` : ''}
                <div class="border-t border-gray-100 dark:border-gray-800"></div>
                <div class="flex items-center gap-2 flex-wrap">${actions}</div>
            </div>`;
                }).join('');

                document.getElementById('compareContent').innerHTML =
                    `<div class="grid grid-cols-3 gap-4">${cards}</div>`;
            } catch (e) {
                document.getElementById('compareContent').innerHTML =
                    `<div class="text-center py-8 text-red-400 text-sm">Gagal: ${e.message}</div>`;
            }
        }

        // ── Approve / Reject ─────────────────────────────────────────────
        async function doApprove(id) {
            if (!confirm(
                    'Setujui penawaran ini?\n\n• PO PDF akan digenerate otomatis\n• Penawaran lain di batch yang sama otomatis ditolak\n• Batch akan ditutup'
                    )) return;
            try {
                const res = await fetch(`/api/admin/quotations/${id}/approve`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF()
                    },
                    body: JSON.stringify({
                        note: ''
                    })
                });
                const json = await res.json();
                if (res.ok && json.success) {
                    toast('✓ Penawaran disetujui! PO digenerate.', 'success');
                    await loadQuotations();
                } else toast(json.message || 'Gagal approve', 'error');
            } catch (e) {
                toast('Terjadi kesalahan', 'error');
            }
        }

        function openReject(id) {
            document.getElementById('rejectId').value = id;
            document.getElementById('rejectNote').value = '';
            showModal('rejectModal');
        }
        async function submitReject() {
            const id = document.getElementById('rejectId').value;
            const note = document.getElementById('rejectNote').value.trim();
            if (!note) {
                alert('Alasan penolakan wajib diisi.');
                return;
            }
            try {
                const res = await fetch(`/api/admin/quotations/${id}/reject`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF()
                    },
                    body: JSON.stringify({
                        note
                    })
                });
                const json = await res.json();
                hideModal('rejectModal');
                if (res.ok && json.success) {
                    toast('Penawaran ditolak.', 'success');
                    await loadQuotations();
                } else toast(json.message || 'Gagal', 'error');
            } catch (e) {
                toast('Terjadi kesalahan', 'error');
            }
        }

        function toast(msg, type = 'success') {
            const t = document.createElement('div');
            t.className =
                `fixed bottom-5 right-5 px-5 py-3 rounded-xl text-white text-sm z-[9999] shadow-lg ${type === 'success' ? 'bg-green-600' : 'bg-red-600'}`;
            t.textContent = msg;
            document.body.appendChild(t);
            setTimeout(() => t.remove(), 3000);
        }

        loadQuotations();
    </script>
@endpush
