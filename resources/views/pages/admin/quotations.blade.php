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
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4">
            <p id="stTotal" class="text-xl font-bold text-gray-900 dark:text-white">—</p>
            <p class="text-xs text-gray-500 mt-0.5">Total Penawaran</p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4">
            <p id="stPending" class="text-xl font-bold text-amber-500">—</p>
            <p class="text-xs text-gray-500 mt-0.5">Menunggu Review</p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4">
            <p id="stApproved" class="text-xl font-bold text-green-500">—</p>
            <p class="text-xs text-gray-500 mt-0.5">Disetujui</p>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 overflow-hidden">
        <div class="p-4 border-b border-gray-100 dark:border-gray-800">
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
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">#</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Supplier</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Batch RFQ</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Total Harga</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Tgl Submit</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Status</th>
                        <th class="text-right px-5 py-3.5 text-xs font-semibold text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody id="quotTable">
                    <tr><td colspan="7" class="px-5 py-8 text-center text-sm text-gray-400">Memuat...</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════════════
     DETAIL MODAL — Tabel 17 kolom sesuai file Excel + Download Excel
     ═══════════════════════════════════════════════════════════════════ -->
<div id="detailModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60" style="display:none!important">
    <div class="bg-white dark:bg-gray-900 rounded-2xl w-full max-w-[95vw] mx-4 shadow-2xl border border-gray-200 dark:border-gray-700 max-h-[92vh] flex flex-col">

        <!-- Header modal -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex-shrink-0">
            <div>
                <h3 id="detailTitle" class="font-semibold text-gray-800 dark:text-white">Detail Penawaran</h3>
                <p id="detailSub" class="text-xs text-gray-400 mt-0.5"></p>
            </div>
            <div class="flex items-center gap-3">
                <!-- Tombol Download Excel -->
                <a id="btnDownloadExcel" href="#" target="_blank"
                    class="hidden inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3M3 17v3a2 2 0 002 2h14a2 2 0 002-2v-3"/>
                    </svg>
                    Download Excel
                </a>
                <button onclick="hideModal('detailModal')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Info cards -->
        <div id="detailInfo" class="px-6 py-4 grid grid-cols-2 md:grid-cols-5 gap-4 border-b border-gray-100 dark:border-gray-800 flex-shrink-0 text-sm"></div>

        <!-- Tabel 17 kolom sesuai Excel -->
        <div class="overflow-auto flex-1 p-6">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    Detail Item — sesuai kolom file Excel
                </p>
                <span id="detailItemCount" class="text-xs text-gray-400"></span>
            </div>
            <div id="detailItemsWrapper" class="overflow-x-auto"></div>
        </div>

        <!-- Footer aksi -->
        <div id="detailFooter" class="px-6 pb-6 flex gap-3 flex-shrink-0 border-t border-gray-100 dark:border-gray-800 pt-4"></div>
    </div>
</div>

<!-- Compare Modal -->
<div id="compareModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60" style="display:none!important">
    <div class="bg-white dark:bg-gray-900 rounded-2xl w-full max-w-5xl mx-4 shadow-2xl border border-gray-200 dark:border-gray-700 max-h-[90vh] flex flex-col">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex-shrink-0">
            <div>
                <h3 class="font-semibold text-gray-800 dark:text-white">Perbandingan Harga</h3>
                <p class="text-xs text-gray-400 mt-0.5">Sistem otomatis mengurutkan dari harga terendah</p>
            </div>
            <button onclick="hideModal('compareModal')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div id="compareContent" class="overflow-auto flex-1 p-6"></div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60" style="display:none!important">
    <div class="bg-white dark:bg-gray-900 rounded-2xl w-full max-w-sm mx-4 p-6 shadow-2xl border border-gray-200 dark:border-gray-700">
        <h3 class="font-semibold text-gray-800 dark:text-white mb-4">Tolak Penawaran</h3>
        <input type="hidden" id="rejectId">
        <label class="block text-sm text-gray-600 dark:text-gray-400 mb-2">Alasan <span class="text-red-500">*</span></label>
        <textarea id="rejectNote" rows="3" placeholder="Tulis alasan penolakan..."
            class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 text-gray-800 dark:text-white resize-none mb-4"></textarea>
        <div class="flex gap-3">
            <button onclick="submitReject()" class="flex-1 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm font-medium">Tolak</button>
            <button onclick="hideModal('rejectModal')" class="flex-1 py-2.5 border border-gray-200 dark:border-gray-700 text-gray-600 rounded-xl text-sm">Batal</button>
        </div>
    </div>
</div>

<script>
const CSRF = () => document.querySelector('meta[name="csrf-token"]')?.content || '';
let allQ = [];

const statusCls = {
    pending:  'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
    approved: 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
    rejected: 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400'
};

function fmtRp(n)   { return n ? 'Rp ' + parseInt(n).toLocaleString('id-ID') : '—'; }
function fmtDate(d) { return d ? new Date(d).toLocaleDateString('id-ID', { day:'numeric', month:'short', year:'numeric' }) : '—'; }
function esc(v)     { return v == null ? '—' : String(v).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

function showModal(id) { const el = document.getElementById(id); el.style.removeProperty('display'); el.style.display = 'flex'; }
function hideModal(id) { document.getElementById(id).style.display = 'none'; }

// ─── Load semua quotation ─────────────────────────────────────────────
async function loadQuotations() {
    try {
        const res  = await fetch('/api/admin/quotations', { headers: { 'Accept': 'application/json' } });
        const json = await res.json();
        if (!res.ok) throw new Error(json.message || 'HTTP ' + res.status);
        allQ = json.quotations || [];
        document.getElementById('stTotal').textContent    = allQ.length;
        document.getElementById('stPending').textContent  = allQ.filter(q => q.status === 'pending').length;
        document.getElementById('stApproved').textContent = allQ.filter(q => q.status === 'approved').length;
        renderTable(allQ);
    } catch(e) {
        document.getElementById('quotTable').innerHTML =
            `<tr><td colspan="7" class="px-5 py-6 text-center text-sm text-red-400">Gagal memuat: ${e.message}</td></tr>`;
    }
}

function renderTable(list) {
    const tb = document.getElementById('quotTable');
    if (!list.length) {
        tb.innerHTML = '<tr><td colspan="7" class="px-5 py-6 text-center text-sm text-gray-400">Tidak ada data.</td></tr>';
        return;
    }
    tb.innerHTML = list.map((q, i) => `
        <tr class="border-t border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800/30">
            <td class="px-5 py-3.5 text-xs text-gray-400">${i+1}</td>
            <td class="px-5 py-3.5">
                <p class="font-medium text-gray-800 dark:text-white text-sm">${esc(q.invited_supplier?.supplier?.company_name)}</p>
                <p class="text-xs text-gray-400">${esc(q.invited_supplier?.supplier?.user?.name)}</p>
            </td>
            <td class="px-5 py-3.5">
                <p class="text-sm text-gray-700 dark:text-gray-300">${esc(q.invited_supplier?.batch_category?.batch?.title)}</p>
                <p class="text-xs text-gray-400">${esc(q.invited_supplier?.batch_category?.master_category?.name)}</p>
            </td>
            <td class="px-5 py-3.5 font-semibold text-sm ${q.status === 'approved' ? 'text-green-600' : 'text-gray-800 dark:text-white'}">${fmtRp(q.total_price)}</td>
            <td class="px-5 py-3.5 text-xs text-gray-500">${fmtDate(q.submitted_at)}</td>
            <td class="px-5 py-3.5">
                <span class="px-2.5 py-1 rounded-full text-xs font-medium ${statusCls[q.status] || 'bg-gray-100 text-gray-600'}">${q.status || '—'}</span>
            </td>
            <td class="px-5 py-3.5 text-right">
                <div class="flex items-center justify-end gap-1.5 flex-wrap">
                    <!-- Detail -->
                    <button onclick="viewDetail(${q.id_quotation})"
                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-gray-50 hover:bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 rounded-lg text-xs font-medium transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Detail
                    </button>
                    ${q.invited_supplier?.batch_category?.id_batch ? `
                    <button onclick="comparePrice(${q.invited_supplier.batch_category.id_batch})"
                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-purple-50 hover:bg-purple-100 text-purple-600 rounded-lg text-xs font-medium transition-colors">
                        Compare
                    </button>` : ''}
                    ${q.status === 'pending' ? `
                    <button onclick="doApprove(${q.id_quotation})"
                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-green-50 hover:bg-green-100 text-green-600 rounded-lg text-xs font-medium">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Approve
                    </button>
                    <button onclick="openReject(${q.id_quotation})"
                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg text-xs font-medium">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Reject
                    </button>` :
                    q.status === 'approved' && q.po_file_path ? `
                    <a href="/storage/${q.po_file_path}" target="_blank"
                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg text-xs font-medium">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17v3a2 2 0 002 2h14a2 2 0 002-2v-3"/></svg>
                        PO PDF
                    </a>` : ''}
                </div>
            </td>
        </tr>`).join('');
}

function doFilter() {
    const s = document.getElementById('statusFilter').value;
    renderTable(s ? allQ.filter(q => q.status === s) : allQ);
}

// ─── View Detail ─────────────────────────────────────────────────────
// Tabel 17 kolom sama persis dengan file Excel:
// Coll No. | RFQ No. | Vendor | No. Item | Material No. | Description | Qty | UoM |
// Currency | Net Price | Incoterm | Destination | Remark 1 | Remark 2 |
// Lead Time(Weeks) | Payment Term | Quotation Date
async function viewDetail(id) {
    try {
        const res  = await fetch(`/api/admin/quotations/${id}`, { headers: { 'Accept': 'application/json' } });
        const json = await res.json();
        if (!res.ok) throw new Error(json.message || 'Error');
        const q    = json.quotation;

        // Judul & subtitle
        document.getElementById('detailTitle').textContent =
            q.invited_supplier?.supplier?.company_name || 'Detail Penawaran';
        document.getElementById('detailSub').textContent =
            (q.invited_supplier?.batch_category?.batch?.batch_number || '') + ' — ' +
            (q.invited_supplier?.batch_category?.batch?.title || '');

        // Tombol Download Excel
        const btnExcel = document.getElementById('btnDownloadExcel');
        if (q.file_url || q.file_path) {
            btnExcel.href = q.file_url || `/storage/${q.file_path}`;
            btnExcel.classList.remove('hidden');
            // Nama file asli
            const fname = q.file_name || 'quotation.xlsx';
            btnExcel.querySelector('span') && (btnExcel.querySelector('span').textContent = fname);
            // Ganti teks tombol dengan nama file
            btnExcel.title = `Download: ${fname}`;
        } else {
            btnExcel.classList.add('hidden');
        }

        // Info cards — 5 kolom
        document.getElementById('detailInfo').innerHTML = `
            <div>
                <p class="text-xs text-gray-400 mb-1">No. RFQ / Batch</p>
                <p class="text-sm font-mono font-medium text-gray-800 dark:text-white">${esc(q.invited_supplier?.batch_category?.batch?.batch_number)}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-1">Kategori</p>
                <p class="text-sm text-gray-700 dark:text-gray-300">${esc(q.invited_supplier?.batch_category?.master_category?.name)}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-1">Total Harga</p>
                <p class="text-sm font-bold text-gray-800 dark:text-white">${fmtRp(q.total_price)}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-1">Tgl Submit</p>
                <p class="text-sm text-gray-700 dark:text-gray-300">${fmtDate(q.submitted_at)}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-1">Status</p>
                <span class="px-2.5 py-1 rounded-full text-xs font-medium ${statusCls[q.status] || ''}">${q.status || '—'}</span>
            </div>
        `;

        // ── Tabel 17 kolom sesuai Excel ──────────────────────────────
        const items = q.quotation_items || [];
        document.getElementById('detailItemCount').textContent = items.length ? `${items.length} item` : '';

        if (items.length) {
            const theadCols = [
                '#', 'Coll No.', 'RFQ No.', 'Vendor', 'No. Item', 'Material No.',
                'Description', 'Qty', 'UoM', 'Currency', 'Net Price',
                'Incoterm', 'Destination', 'Remark 1', 'Remark 2',
                'Lead Time(Weeks)', 'Payment Term', 'Quotation Date'
            ];
            const thead = theadCols.map(c =>
                `<th class="px-3 py-2.5 text-left text-xs font-semibold text-white whitespace-nowrap">${c}</th>`
            ).join('');

            const tbody = items.map((item, i) => `
                <tr class="border-b border-gray-100 dark:border-gray-800 ${i%2===0 ? 'bg-white dark:bg-gray-900' : 'bg-gray-50/60 dark:bg-gray-800/30'} hover:bg-blue-50/40 transition-colors">
                    <td class="px-3 py-2 text-xs text-gray-400 text-center">${i+1}</td>
                    <td class="px-3 py-2 text-xs text-gray-700 dark:text-gray-300 whitespace-nowrap">${esc(item.coll_no)}</td>
                    <td class="px-3 py-2 text-xs text-gray-700 dark:text-gray-300 whitespace-nowrap font-mono">${esc(item.rfq_no)}</td>
                    <td class="px-3 py-2 text-xs text-gray-700 dark:text-gray-300 whitespace-nowrap">${esc(item.vendor)}</td>
                    <td class="px-3 py-2 text-xs text-gray-700 dark:text-gray-300 text-center">${esc(item.no_item)}</td>
                    <td class="px-3 py-2 text-xs text-gray-700 dark:text-gray-300 font-mono whitespace-nowrap">${esc(item.material_no)}</td>
                    <td class="px-3 py-2 text-xs text-gray-700 dark:text-gray-300 max-w-[180px]" title="${esc(item.description)}">${esc(item.description)}</td>
                    <td class="px-3 py-2 text-xs text-center font-semibold text-gray-800 dark:text-white">${item.qty ?? '—'}</td>
                    <td class="px-3 py-2 text-xs text-center text-gray-600 dark:text-gray-400">${esc(item.uom)}</td>
                    <td class="px-3 py-2 text-xs text-center text-gray-600 dark:text-gray-400">${esc(item.currency)}</td>
                    <td class="px-3 py-2 text-xs text-right font-semibold text-gray-800 dark:text-white whitespace-nowrap">
                        ${item.net_price != null ? parseFloat(item.net_price).toLocaleString('id-ID', { minimumFractionDigits: 2 }) : '—'}
                    </td>
                    <td class="px-3 py-2 text-xs text-gray-600 dark:text-gray-400">${esc(item.incoterm)}</td>
                    <td class="px-3 py-2 text-xs text-gray-600 dark:text-gray-400 whitespace-nowrap">${esc(item.destination)}</td>
                    <td class="px-3 py-2 text-xs text-gray-600 dark:text-gray-400 max-w-[120px]" title="${esc(item.remark_1)}">${esc(item.remark_1)}</td>
                    <td class="px-3 py-2 text-xs text-gray-600 dark:text-gray-400 max-w-[120px]" title="${esc(item.remark_2)}">${esc(item.remark_2)}</td>
                    <td class="px-3 py-2 text-xs text-center text-gray-600 dark:text-gray-400">${esc(item.lead_time_weeks)}</td>
                    <td class="px-3 py-2 text-xs text-gray-600 dark:text-gray-400 whitespace-nowrap">${esc(item.payment_term)}</td>
                    <td class="px-3 py-2 text-xs text-gray-600 dark:text-gray-400 whitespace-nowrap">${esc(item.quotation_date)}</td>
                </tr>`).join('');

            document.getElementById('detailItemsWrapper').innerHTML = `
                <table class="w-full border-collapse text-xs min-w-max">
                    <thead class="bg-blue-700 dark:bg-blue-800 sticky top-0">
                        <tr>${thead}</tr>
                    </thead>
                    <tbody>${tbody}</tbody>
                </table>`;
        } else {
            // Belum ada item ter-parse
            document.getElementById('detailItemsWrapper').innerHTML = `
                <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl p-5">
                    <p class="text-amber-700 dark:text-amber-400 text-sm font-medium mb-1">Data item belum tersedia</p>
                    <p class="text-amber-600 dark:text-amber-500 text-xs mb-3">
                        File Excel belum ter-parse atau format header kolom tidak sesuai template.<br>
                        Pastikan header baris pertama file Excel sesuai:
                        <strong>Coll No. | RFQ No. | Vendor | No. Item | Material No. | Description | Qty | UoM | Currency | Net Price | Incoterm | Destination | Remark 1 | Remark 2 | Lead Time(Weeks) | Payment Term | Quotation Date</strong>
                    </p>
                    ${(q.file_url || q.file_path) ? `
                    <a href="${q.file_url || '/storage/' + q.file_path}" target="_blank"
                        class="inline-flex items-center gap-1.5 text-emerald-600 hover:underline text-xs font-semibold">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17v3a2 2 0 002 2h14a2 2 0 002-2v-3"/>
                        </svg>
                        Download File Excel Original
                    </a>` : ''}
                </div>`;
        }

        // ── Footer: aksi ─────────────────────────────────────────────
        let footer = '';
        if (q.status === 'pending') {
            footer = `
                <button onclick="hideModal('detailModal');doApprove(${q.id_quotation})"
                    class="flex-1 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl text-sm font-medium">
                    ✓ Approve & Generate PO
                </button>
                <button onclick="hideModal('detailModal');openReject(${q.id_quotation})"
                    class="flex-1 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm font-medium">
                    ✗ Reject
                </button>`;
        } else if (q.status === 'approved') {
            if (q.po_file_path || q.po_url) {
                footer = `
                    <a href="${q.po_url || '/storage/' + q.po_file_path}" target="_blank"
                        class="flex-1 flex items-center justify-center gap-2 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17v3a2 2 0 002 2h14a2 2 0 002-2v-3"/>
                        </svg>
                        Download PO PDF
                    </a>`;
            }
        }
        footer += `<button onclick="hideModal('detailModal')"
            class="flex-1 py-2.5 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 rounded-xl text-sm">
            Tutup
        </button>`;
        document.getElementById('detailFooter').innerHTML = footer;

        showModal('detailModal');
    } catch(e) { toast('Gagal memuat detail: ' + e.message, 'error'); }
}

// ─── Compare ──────────────────────────────────────────────────────────
async function comparePrice(batchId) {
    try {
        const res  = await fetch(`/api/admin/quotations/compare/${batchId}`, { headers: { 'Accept': 'application/json' } });
        const json = await res.json();
        const list = json.quotations || [];

        if (!list.length) { toast('Belum ada penawaran untuk dibandingkan.', 'error'); return; }

        const lowestPrice = parseFloat(list[0]?.total_price || 0);
        document.getElementById('compareContent').innerHTML = `
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-800/60">
                        <tr>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500">Rank</th>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500">Supplier</th>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500">File Excel</th>
                            <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500">Total Harga</th>
                            <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500">Status</th>
                            <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${list.map((q, i) => {
                            const isLowest = parseFloat(q.total_price) === lowestPrice && q.status !== 'rejected';
                            const fileUrl  = q.file_url || (q.file_path ? `/storage/${q.file_path}` : null);
                            return `<tr class="border-t border-gray-100 dark:border-gray-800 ${isLowest ? 'bg-green-50/50' : ''}">
                                <td class="px-4 py-3">
                                    <div class="w-7 h-7 rounded-lg flex items-center justify-center text-xs font-bold
                                        ${i===0 && q.status !== 'rejected' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-500'}">
                                        ${i===0 && q.status !== 'rejected' ? '🥇' : i+1}
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="font-medium text-gray-800 dark:text-white">${esc(q.invited_supplier?.supplier?.company_name)}</p>
                                    <p class="text-xs text-gray-400">${esc(q.invited_supplier?.supplier?.user?.email)}</p>
                                </td>
                                <td class="px-4 py-3">
                                    ${fileUrl
                                        ? `<a href="${fileUrl}" target="_blank"
                                            class="inline-flex items-center gap-1 text-emerald-600 hover:underline text-xs font-medium">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17v3a2 2 0 002 2h14a2 2 0 002-2v-3"/>
                                            </svg>
                                            ${esc(q.file_name) || 'Download Excel'}
                                           </a>`
                                        : '—'}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <p class="font-bold text-sm ${isLowest ? 'text-green-600' : 'text-gray-800 dark:text-white'}">${fmtRp(q.total_price)}</p>
                                    ${isLowest ? '<p class="text-green-500 text-xs">Terendah ✓</p>' : ''}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium ${statusCls[q.status] || 'bg-gray-100 text-gray-500'}">${q.status}</span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    ${q.status === 'pending' ? `
                                    <button onclick="hideModal('compareModal');doApprove(${q.id_quotation})" class="px-2.5 py-1 bg-green-50 hover:bg-green-100 text-green-600 rounded text-xs mr-1">Approve</button>
                                    <button onclick="hideModal('compareModal');openReject(${q.id_quotation})" class="px-2.5 py-1 bg-red-50 hover:bg-red-100 text-red-600 rounded text-xs">Reject</button>
                                    ` : q.status === 'approved' && (q.po_file_path || q.po_url) ? `
                                    <a href="${q.po_url || '/storage/' + q.po_file_path}" target="_blank"
                                        class="px-2.5 py-1 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded text-xs font-medium">PO PDF</a>
                                    ` : '—'}
                                </td>
                            </tr>`;
                        }).join('')}
                    </tbody>
                </table>
            </div>`;
        showModal('compareModal');
    } catch(e) { toast('Gagal memuat compare: ' + e.message, 'error'); }
}

// ─── Approve ──────────────────────────────────────────────────────────
async function doApprove(id) {
    if (!confirm('Setujui penawaran ini?\n\n• Penawaran lain yang pending akan ditolak otomatis\n• Batch akan ditutup\n• PO akan digenerate')) return;
    try {
        const res  = await fetch(`/api/admin/quotations/${id}/approve`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF() },
            body: JSON.stringify({ note: '' })
        });
        const json = await res.json();
        if (res.ok && json.success) { toast('Penawaran disetujui! PO digenerate.'); await loadQuotations(); }
        else toast(json.message || 'Gagal approve', 'error');
    } catch(e) { toast('Terjadi kesalahan', 'error'); }
}

// ─── Reject ───────────────────────────────────────────────────────────
function openReject(id) {
    document.getElementById('rejectId').value = id;
    document.getElementById('rejectNote').value = '';
    showModal('rejectModal');
}
async function submitReject() {
    const id   = document.getElementById('rejectId').value;
    const note = document.getElementById('rejectNote').value.trim();
    if (!note) { alert('Alasan penolakan wajib diisi.'); return; }
    try {
        const res  = await fetch(`/api/admin/quotations/${id}/reject`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF() },
            body: JSON.stringify({ note })
        });
        const json = await res.json();
        hideModal('rejectModal');
        if (res.ok && json.success) { toast('Penawaran ditolak.'); await loadQuotations(); }
        else toast(json.message || 'Gagal reject', 'error');
    } catch(e) { toast('Terjadi kesalahan', 'error'); }
}

function toast(msg, type = 'success') {
    const t = document.createElement('div');
    t.className = `fixed bottom-5 right-5 px-5 py-3 rounded-xl text-white text-sm z-[9999] shadow-lg ${type === 'success' ? 'bg-green-600' : 'bg-red-600'}`;
    t.textContent = msg; document.body.appendChild(t); setTimeout(() => t.remove(), 3000);
}

loadQuotations();
</script>
@endsection