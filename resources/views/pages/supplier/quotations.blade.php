@extends('layouts.supplier')
@section('page-title', 'Penawaran Saya')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-xl font-bold text-gray-800 dark:text-white">Penawaran Saya</h1>
        <p class="text-sm text-gray-500 mt-0.5">Upload penawaran, pantau status, dan download PO</p>
    </div>

    <!-- Template Download Section -->
    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-2xl p-5 mb-6">
        <div class="flex items-start gap-4">
            <div class="w-10 h-10 bg-blue-600/20 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17v3a2 2 0 002 2h14a2 2 0 002-2v-3"/></svg>
            </div>
            <div class="flex-1">
                <p class="font-semibold text-blue-800 dark:text-blue-300 text-sm mb-1">Template Excel dari Admin</p>
                <p class="text-blue-600 dark:text-blue-400 text-xs mb-3">Download template, isi dengan harga penawaran Anda, lalu upload di form di bawah.</p>
                <div id="templateList" class="flex flex-wrap gap-2">
                    <span class="text-blue-400 text-xs">Memuat template...</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Upload Penawaran -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 mb-6">
        <h3 class="font-semibold text-gray-800 dark:text-white mb-4">
            <svg class="w-5 h-5 inline mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
            Ajukan Penawaran
        </h3>

        <div id="alertForm" class="hidden mb-4 p-3 rounded-xl text-sm"></div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">
                    Pilih Undangan RFQ <span class="text-red-500">*</span>
                </label>
                <select id="inviteSelect"
                    class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 dark:text-white">
                    <option value="">-- Pilih undangan RFQ yang belum disubmit --</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">
                    Upload File Excel Penawaran <span class="text-red-500">*</span>
                </label>
                <input id="quotFile" type="file" accept=".xlsx,.xls,.csv"
                    class="w-full text-sm text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                <p class="text-xs text-gray-400 mt-1">Format: .xlsx / .xls / .csv, maks 10MB</p>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">
                    Total Harga Penawaran (Rp) <span class="text-red-500">*</span>
                </label>
                <input id="quotPrice" type="number" min="0" placeholder="Contoh: 15000000"
                    class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 dark:text-white">
            </div>
        </div>

        <div class="mt-5">
            <button onclick="submitQuotation()" id="btnSubmit"
                class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-sm font-medium transition-colors disabled:opacity-50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                <span id="btnSubmitLabel">Kirim Penawaran</span>
            </button>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-5">
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4">
            <p id="stTotal" class="text-xl font-bold text-gray-800 dark:text-white">—</p>
            <p class="text-xs text-gray-500 mt-0.5">Total</p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4">
            <p id="stPending" class="text-xl font-bold text-amber-500">—</p>
            <p class="text-xs text-gray-500 mt-0.5">Menunggu</p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4">
            <p id="stApproved" class="text-xl font-bold text-green-500">—</p>
            <p class="text-xs text-gray-500 mt-0.5">Disetujui</p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4">
            <p id="stRejected" class="text-xl font-bold text-red-500">—</p>
            <p class="text-xs text-gray-500 mt-0.5">Ditolak</p>
        </div>
    </div>

    <!-- Filter -->
    <div class="mb-4">
        <select id="statusFilter" onchange="doFilter()"
            class="text-sm bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2 focus:outline-none text-gray-800 dark:text-white">
            <option value="">Semua Status</option>
            <option value="pending">Pending</option>
            <option value="approved">Disetujui</option>
            <option value="rejected">Ditolak</option>
        </select>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-800/60">
                    <tr>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">#</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Batch RFQ</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">File</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Total Harga</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Tgl Submit</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Status</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Catatan</th>
                        <th class="text-right px-5 py-3.5 text-xs font-semibold text-gray-500">PO</th>
                    </tr>
                </thead>
                <tbody id="quotTable">
                    <tr><td colspan="8" class="px-5 py-8 text-center text-sm text-gray-400">Memuat...</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
let allQuotations  = [];
let allInvitations = [];

const statusCls = {
    pending:  'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
    approved: 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
    rejected: 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400',
};
function fmtRp(n)   { return n ? 'Rp ' + parseInt(n).toLocaleString('id-ID') : '—'; }
function fmtDate(d) { return d ? new Date(d).toLocaleDateString('id-ID', { day:'numeric', month:'short', year:'numeric' }) : '—'; }

// ─── Load templates dari admin ─────────────────────────────────────────
async function loadTemplates() {
    try {
        const res  = await fetch('/api/supplier/rfq-templates', { headers: { 'Accept': 'application/json' } });
        const json = await res.json();
        const tpls = json.templates || [];
        const el   = document.getElementById('templateList');

        if (!tpls.length) {
            el.innerHTML = '<span class="text-blue-400 text-xs">Belum ada template dari admin.</span>';
            return;
        }
        el.innerHTML = tpls.map(t => `
            <a href="${t.file_url}" target="_blank"
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-medium transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17v3a2 2 0 002 2h14a2 2 0 002-2v-3"/></svg>
                ${t.title}
            </a>`).join('');
    } catch(e) {
        document.getElementById('templateList').innerHTML = '<span class="text-red-400 text-xs">Gagal memuat template.</span>';
    }
}

// ─── Load invitations (undangan yang belum submit) ─────────────────────
async function loadInvitations() {
    try {
        const res  = await fetch('/api/supplier/rfq', { headers: { 'Accept': 'application/json' } });
        const json = await res.json();
        allInvitations = (json.invitations || []).filter(inv => !inv.has_submitted);
        populateInviteSelect();
    } catch(e) {}
}

function populateInviteSelect() {
    const sel = document.getElementById('inviteSelect');
    sel.innerHTML = '<option value="">-- Pilih undangan RFQ yang belum disubmit --</option>';
    if (!allInvitations.length) {
        sel.innerHTML += '<option disabled>Tidak ada undangan yang belum disubmit</option>';
        return;
    }
    allInvitations.forEach(inv => {
        const batch = inv.batch || {};
        const cat   = inv.category || {};
        sel.innerHTML += `<option value="${inv.id_invited_supplier}">${batch.batch_number || ''} — ${batch.title || '—'} (${cat.name || ''})</option>`;
    });
}

// ─── Submit penawaran ──────────────────────────────────────────────────
async function submitQuotation() {
    const invId = document.getElementById('inviteSelect').value;
    const file  = document.getElementById('quotFile').files[0];
    const price = document.getElementById('quotPrice').value;

    if (!invId)  { showFormAlert('Pilih undangan RFQ terlebih dahulu.'); return; }
    if (!file)   { showFormAlert('Upload file Excel penawaran.'); return; }
    if (!price)  { showFormAlert('Masukkan total harga penawaran.'); return; }
    if (parseFloat(price) <= 0) { showFormAlert('Total harga harus lebih dari 0.'); return; }

    const btn = document.getElementById('btnSubmit');
    document.getElementById('btnSubmitLabel').textContent = 'Mengirim...';
    btn.disabled = true;

    const fd = new FormData();
    fd.append('id_invited_supplier', invId);
    fd.append('file', file);
    fd.append('total_price', price);

    try {
        const res  = await fetch('/api/supplier/quotations', {
            method: 'POST',
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF() },
            body: fd
        });
        const json = await res.json();

        if (res.ok && json.success) {
            showFormAlert('Penawaran berhasil dikirim! Menunggu review admin.', 'success');
            // Reset form
            document.getElementById('inviteSelect').value = '';
            document.getElementById('quotFile').value = '';
            document.getElementById('quotPrice').value = '';
            // Reload data
            await loadQuotations();
            await loadInvitations();
        } else {
            const errMsg = json.errors ? Object.values(json.errors).flat().join(' ') : (json.message || 'Gagal mengirim.');
            showFormAlert(errMsg);
        }
    } catch(e) { showFormAlert('Terjadi kesalahan. Coba lagi.'); }
    finally {
        document.getElementById('btnSubmitLabel').textContent = 'Kirim Penawaran';
        btn.disabled = false;
    }
}

function showFormAlert(msg, type = 'error') {
    const el = document.getElementById('alertForm');
    el.className = `mb-4 p-3 rounded-xl text-sm ${
        type === 'success'
            ? 'bg-green-50 text-green-700 border border-green-200 dark:bg-green-900/20 dark:text-green-400'
            : 'bg-red-50 text-red-700 border border-red-200 dark:bg-red-900/20 dark:text-red-400'
    }`;
    el.textContent = msg;
    el.classList.remove('hidden');
    if (type === 'success') setTimeout(() => el.classList.add('hidden'), 5000);
}

// ─── Load quotations ───────────────────────────────────────────────────
async function loadQuotations() {
    try {
        const res  = await fetch('/api/supplier/quotations', { headers: { 'Accept': 'application/json' } });
        if (res.status === 401) { window.location.href = '/login'; return; }
        const json = await res.json();
        allQuotations = json.quotations || [];

        document.getElementById('stTotal').textContent    = allQuotations.length;
        document.getElementById('stPending').textContent  = allQuotations.filter(q => q.status === 'pending').length;
        document.getElementById('stApproved').textContent = allQuotations.filter(q => q.status === 'approved').length;
        document.getElementById('stRejected').textContent = allQuotations.filter(q => q.status === 'rejected').length;

        renderTable(allQuotations);
    } catch(e) {
        document.getElementById('quotTable').innerHTML = '<tr><td colspan="8" class="px-5 py-6 text-center text-sm text-red-400">Gagal memuat.</td></tr>';
    }
}

function renderTable(list) {
    const tb = document.getElementById('quotTable');
    if (!list.length) { tb.innerHTML = '<tr><td colspan="8" class="px-5 py-6 text-center text-sm text-gray-400">Belum ada penawaran dikirim.</td></tr>'; return; }
    tb.innerHTML = list.map((q, i) => `
        <tr class="border-t border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800/30 ${q.status === 'approved' ? 'bg-green-50/20 dark:bg-green-900/5' : ''}">
            <td class="px-5 py-3.5 text-xs text-gray-400">${i+1}</td>
            <td class="px-5 py-3.5">
                <p class="font-medium text-gray-800 dark:text-white text-sm">${q.batch_title || '—'}</p>
                <p class="text-xs text-gray-400 mt-0.5">${q.batch_number || ''} ${q.category_name ? '· ' + q.category_name : ''}</p>
            </td>
            <td class="px-5 py-3.5">
                ${q.file_url ? `<a href="${q.file_url}" target="_blank" class="inline-flex items-center gap-1 text-blue-600 hover:underline text-xs font-medium">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z"/></svg>
                    ${q.file_name || 'Download'}
                </a>` : '—'}
            </td>
            <td class="px-5 py-3.5 font-semibold text-sm ${q.status === 'approved' ? 'text-green-600' : 'text-gray-800 dark:text-white'}">${fmtRp(q.total_price)}</td>
            <td class="px-5 py-3.5 text-xs text-gray-500">${fmtDate(q.submitted_at)}</td>
            <td class="px-5 py-3.5">
                <span class="px-2.5 py-1 rounded-full text-xs font-medium ${statusCls[q.status] || 'bg-gray-100 text-gray-600'}">
                    ${q.status === 'pending' ? 'Menunggu Review' : q.status === 'approved' ? '✓ Disetujui' : 'Ditolak'}
                </span>
            </td>
            <td class="px-5 py-3.5 text-xs text-gray-500 max-w-xs">${q.note || '—'}</td>
            <td class="px-5 py-3.5 text-right">
                ${q.status === 'approved' && q.po_url ? `
                <a href="${q.po_url}" target="_blank"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-lg text-xs font-medium transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17v3a2 2 0 002 2h14a2 2 0 002-2v-3"/></svg>
                    Download PO
                </a>` : '<span class="text-gray-300 text-xs">—</span>'}
            </td>
        </tr>`).join('');
}

function doFilter() {
    const s = document.getElementById('statusFilter').value;
    renderTable(s ? allQuotations.filter(q => q.status === s) : allQuotations);
}

// Init
loadTemplates();
loadInvitations();
loadQuotations();
</script>
@endsection