@extends('layouts.admin')
@section('page-title', 'RFQ Management')

@section('content')
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-xl font-bold text-gray-800 dark:text-white">RFQ Management</h1>
                <p class="text-sm text-gray-500 mt-0.5">Kelola batch pengadaan</p>
            </div>
            <button onclick="openAddBatch()"
                class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Batch RFQ
            </button>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4 text-center">
                <p id="stTotal" class="text-xl font-bold text-gray-800 dark:text-white">—</p>
                <p class="text-xs text-gray-500 mt-0.5">Total Batch</p>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4 text-center">
                <p id="stDraft" class="text-xl font-bold text-gray-500">—</p>
                <p class="text-xs text-gray-500 mt-0.5">Draft</p>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4 text-center">
                <p id="stOpen" class="text-xl font-bold text-green-500">—</p>
                <p class="text-xs text-gray-500 mt-0.5">Open</p>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-800/60">
                        <tr>
                            <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">#</th>
                            <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">No. RFQ</th>
                            <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Judul</th>
                            <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Deadline</th>
                            <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Status</th>
                            <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Dibuat</th>
                            <th class="text-right px-5 py-3.5 text-xs font-semibold text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="batchTable">
                        <tr>
                            <td colspan="7" class="px-5 py-8 text-center text-sm text-gray-400">Memuat...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Buat/Edit Batch -->
    <div id="modalBatch" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60"
        style="display:none!important">
        <div
            class="bg-white dark:bg-gray-900 rounded-2xl w-full max-w-md mx-4 shadow-2xl border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-800">
                <h3 id="modalBatchTitle" class="font-semibold text-gray-800 dark:text-white">Buat Batch RFQ</h3>
                <button onclick="closeModalBatch()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div id="alertBatch" class="hidden p-3 rounded-xl text-sm bg-red-50 text-red-600 border border-red-100">
                </div>
                <input type="hidden" id="batchEditId">
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">Judul <span
                            class="text-red-500">*</span></label>
                    <input id="batchTitle" type="text" placeholder="Contoh: Pengadaan ATK Q2 2025"
                        class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 dark:text-white">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">Deskripsi</label>
                    <textarea id="batchDesc" rows="2" placeholder="Deskripsi pengadaan..."
                        class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 dark:text-white resize-none"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">
                        Deadline <span class="text-red-500">*</span>
                        <span class="text-gray-400 font-normal">(tidak bisa pilih tanggal lampau)</span>
                    </label>
                    <input id="batchDeadline" type="date"
                        class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 dark:text-white">
                </div>
                <div id="statusRow" class="hidden">
                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">Status</label>
                    <select id="batchStatus"
                        class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 dark:text-white">
                        <option value="draft">Draft (Belum dibuka ke supplier)</option>
                        <option value="open">Open (Supplier bisa mengajukan)</option>
                        <option value="closed">Closed (Ditutup)</option>
                    </select>
                </div>
            </div>
            <div class="px-6 pb-6 flex gap-3">
                <button onclick="saveBatch()"
                    class="flex-1 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-medium">Simpan</button>
                <button onclick="closeModalBatch()"
                    class="flex-1 py-2.5 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 rounded-xl text-sm">Batal</button>
            </div>
        </div>
    </div>

    <!-- Confirm Delete -->
    <div id="modalDel" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60"
        style="display:none!important">
        <div
            class="bg-white dark:bg-gray-900 rounded-2xl w-full max-w-sm mx-4 p-6 text-center shadow-2xl border border-gray-200 dark:border-gray-700">
            <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>
            <h3 class="font-bold text-gray-800 dark:text-white mb-2">Hapus Batch?</h3>
            <p class="text-sm text-gray-500 mb-5">Semua data terkait (kategori, item, undangan) akan terhapus.</p>
            <div class="flex gap-3">
                <button onclick="confirmDel()"
                    class="flex-1 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm font-medium">Hapus</button>
                <button onclick="closeDel()"
                    class="flex-1 py-2.5 border border-gray-200 dark:border-gray-700 text-gray-600 rounded-xl text-sm">Batal</button>
            </div>
        </div>
    </div>

    <script>
        let allBatches = [];
        let delId = null;

        const statusCls = {
            draft: 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400',
            open: 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
            closed: 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400',
        };

        function showModal(id) {
            const el = document.getElementById(id);
            el.style.removeProperty('display');
            el.style.display = 'flex';
        }

        function hideModal(id) {
            document.getElementById(id).style.display = 'none';
        }

        function CSRF() {
            return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        }

        function fmtDate(val) {
            if (!val) return '—';
            const d = new Date(val);
            if (isNaN(d)) return val;
            return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
        }

        function fmtRp(val) {
            if (val === null || val === undefined || val === '') return '—';
            return 'Rp ' + Number(val).toLocaleString('id-ID');
        }

        function closeModalBatch() {
            hideModal('modalBatch');
        }

        function closeDel() {
            hideModal('modalDel');
        }

        async function loadBatches() {
            try {
                const res = await fetch('/api/admin/batches', {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                const json = await res.json();
                if (!res.ok || !json.success) throw new Error(json.message || 'Error');
                allBatches = json.batches || [];

                document.getElementById('stTotal').textContent = allBatches.length;
                document.getElementById('stDraft').textContent = allBatches.filter(b => b.status === 'draft').length;
                document.getElementById('stOpen').textContent = allBatches.filter(b => b.status === 'open').length;

                renderTable(allBatches);
            } catch (e) {
                document.getElementById('batchTable').innerHTML =
                    `<tr><td colspan="7" class="px-5 py-6 text-center text-sm text-red-400">Gagal memuat: ${e.message}</td></tr>`;
            }
        }

        function renderTable(list) {
            const tb = document.getElementById('batchTable');
            if (!list.length) {
                tb.innerHTML =
                    '<tr><td colspan="7" class="px-5 py-6 text-center text-sm text-gray-400">Belum ada batch RFQ.</td></tr>';
                return;
            }
            tb.innerHTML = list.map((b, i) => `
        <tr class="border-t border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800/30">
            <td class="px-5 py-3.5 text-xs text-gray-400">${i+1}</td>
            <td class="px-5 py-3.5">
                <a href="/admin/batches/${b.id_batch}" class="font-mono text-sm font-bold text-blue-600 hover:underline">${b.batch_number}</a>
            </td>
            <td class="px-5 py-3.5 font-medium text-gray-800 dark:text-white text-sm">${b.title}</td>
            <td class="px-5 py-3.5 text-sm ${b.deadline && new Date(b.deadline) < new Date() ? 'text-red-500 font-medium' : 'text-gray-500'}">${fmtDate(b.deadline)}</td>
            <td class="px-5 py-3.5">
                <span class="px-2.5 py-1 rounded-full text-xs font-medium ${statusCls[b.status] || 'bg-gray-100 text-gray-600'}">${b.status}</span>
            </td>
            <td class="px-5 py-3.5 text-xs text-gray-500">${fmtDate(b.created_at)}</td>
            <td class="px-5 py-3.5 text-right">
                <div class="flex items-center justify-end gap-2">
                    <a href="/admin/batches/${b.id_batch}"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/20 text-blue-600 rounded-lg text-xs font-medium transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Detail
                    </a>
                    <button onclick="openEdit(${b.id_batch})"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 hover:bg-amber-100 dark:bg-amber-900/20 text-amber-600 rounded-lg text-xs font-medium transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit
                    </button>
                    <button onclick="askDel(${b.id_batch})"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 hover:bg-red-100 dark:bg-red-900/20 text-red-600 rounded-lg text-xs font-medium transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Hapus
                    </button>
                </div>
            </td>
        </tr>`).join('');
        }

        function openAddBatch() {
            document.getElementById('batchEditId').value = '';
            document.getElementById('batchTitle').value = '';
            document.getElementById('batchDesc').value = '';
            document.getElementById('batchDeadline').value = '';
            document.getElementById('batchDeadline').min = new Date().toISOString().split('T')[0];
            document.getElementById('statusRow').classList.add('hidden');
            document.getElementById('modalBatchTitle').textContent = 'Buat Batch RFQ';
            document.getElementById('alertBatch').classList.add('hidden');
            showModal('modalBatch');
        }

        function openEdit(id) {
            const b = allBatches.find(x => x.id_batch == id);
            if (!b) return;
            document.getElementById('batchEditId').value = id;
            document.getElementById('batchTitle').value = b.title;
            document.getElementById('batchDesc').value = b.description || '';
            document.getElementById('batchDeadline').value = b.deadline ? b.deadline.toString().substring(0, 10) : '';
            document.getElementById('batchDeadline').min = new Date().toISOString().split('T')[0];
            document.getElementById('batchStatus').value = b.status;
            document.getElementById('statusRow').classList.remove('hidden');
            document.getElementById('modalBatchTitle').textContent = 'Edit Batch';
            document.getElementById('alertBatch').classList.add('hidden');
            showModal('modalBatch');
        }

        async function saveBatch() {
            const id = document.getElementById('batchEditId').value;
            const title = document.getElementById('batchTitle').value.trim();
            const deadline = document.getElementById('batchDeadline').value;
            const desc = document.getElementById('batchDesc').value.trim();

            if (!title || !deadline) {
                showAlertBatch('Judul dan deadline wajib.');
                return;
            }

            const body = {
                title,
                description: desc,
                deadline
            };
            if (id) body.status = document.getElementById('batchStatus').value;

            const url = id ? `/api/admin/batches/${id}` : '/api/admin/batches';
            const method = id ? 'PUT' : 'POST';

            try {
                const res = await fetch(url, {
                    method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF()
                    },
                    body: JSON.stringify(body)
                });
                const json = await res.json();
                if (!res.ok || !json.success) {
                    showAlertBatch(json.message || 'Gagal.');
                    return;
                }
                closeModalBatch();
                toast(id ? 'Batch diperbarui' : 'Batch dibuat');
                await loadBatches();
            } catch (e) {
                showAlertBatch('Terjadi kesalahan.');
            }
        }

        function askDel(id) {
            delId = id;
            showModal('modalDel');
        }

        async function confirmDel() {
            try {
                const res = await fetch(`/api/admin/batches/${delId}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF()
                    }
                });
                const json = await res.json();
                closeDel();
                if (res.ok && json.success) {
                    toast('Batch dihapus');
                    await loadBatches();
                } else toast(json.message || 'Gagal', 'error');
            } catch (e) {
                toast('Kesalahan', 'error');
            }
        }

        function showAlertBatch(msg) {
            const el = document.getElementById('alertBatch');
            el.textContent = msg;
            el.classList.remove('hidden');
        }

        function toast(msg, type = 'success') {
            const t = document.createElement('div');
            t.className = `fixed bottom-5 right-5 px-5 py-3 rounded-xl text-white text-sm z-[9999] shadow-lg ${
        type === 'success' ? 'bg-green-600' : 'bg-red-600'
    }`;
            t.textContent = msg;
            document.body.appendChild(t);
            setTimeout(() => t.remove(), 3000);
        }

        loadBatches();
    </script>
@endsection