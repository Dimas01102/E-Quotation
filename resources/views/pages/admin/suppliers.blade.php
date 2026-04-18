@extends('layouts.admin')
@section('page-title', 'Manajemen Supplier')

@section('content')
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-xl font-bold text-gray-800 dark:text-white">Manajemen Supplier</h1>
                <p class="text-sm text-gray-500 mt-0.5">Kelola dan aktivasi supplier terdaftar</p>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div
                class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4 flex items-center gap-4">
                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <p id="statTotal" class="text-xl font-bold text-gray-900 dark:text-white">—</p>
                    <p class="text-xs text-gray-500">Total</p>
                </div>
            </div>
            <div
                class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4 flex items-center gap-4">
                <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p id="statActive" class="text-xl font-bold text-gray-900 dark:text-white">—</p>
                    <p class="text-xs text-gray-500">Aktif</p>
                </div>
            </div>
            <div
                class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4 flex items-center gap-4">
                <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p id="statPending" class="text-xl font-bold text-gray-900 dark:text-white">—</p>
                    <p class="text-xs text-gray-500">Menunggu Aktivasi</p>
                </div>
            </div>
        </div>

        <!-- Filter & Search -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 overflow-hidden">
            <div class="flex flex-col md:flex-row gap-3 p-4 border-b border-gray-100 dark:border-gray-800">
                <div class="relative flex-1 max-w-xs">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input id="searchInput" type="text" placeholder="Cari nama, perusahaan, email..."
                        class="w-full pl-9 pr-4 py-2 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 dark:text-white"
                        oninput="doFilter()">
                </div>
                <select id="statusFilter" onchange="doFilter()"
                    class="text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 dark:text-white">
                    <option value="">Semua Status</option>
                    <option value="1">Aktif</option>
                    <option value="0">Menunggu Aktivasi</option>
                </select>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-800/60">
                        <tr>
                            <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">#</th>
                            <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Nama / Perusahaan</th>
                            <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Email</th>
                            <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Telepon</th>
                            <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Status</th>
                            <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Tgl Daftar</th>
                            <th class="text-right px-5 py-3.5 text-xs font-semibold text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="supplierTable">
                        <tr>
                            <td colspan="7" class="px-5 py-8 text-center text-sm text-gray-400">Memuat...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div id="detailModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60"
        style="display:none!important">
        <div
            class="bg-white dark:bg-gray-900 rounded-2xl w-full max-w-lg mx-4 shadow-2xl border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-800">
                <h3 class="font-semibold text-gray-800 dark:text-white">Detail Supplier</h3>
                <button onclick="closeDetail()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div id="detailContent" class="p-6 grid grid-cols-2 gap-4 text-sm"></div>
            <div class="px-6 pb-6 flex gap-3">
                <button id="btnToggle" onclick="doToggle()"
                    class="flex-1 py-2.5 rounded-xl text-white text-sm font-medium transition-colors"></button>
                <button onclick="closeDetail()"
                    class="flex-1 py-2.5 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 rounded-xl text-sm">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        let allSuppliers = [];
        let currentId = null;
        let currentActive = null;

        async function loadSuppliers() {
            try {
                const res = await fetch('/api/admin/suppliers', {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                const json = await res.json();
                allSuppliers = json.suppliers || [];

                // Stats
                document.getElementById('statTotal').textContent = allSuppliers.length;
                document.getElementById('statActive').textContent = allSuppliers.filter(s => Number(s.user
                    ?.is_active) === 1).length;
                document.getElementById('statPending').textContent = allSuppliers.filter(s => Number(s.user
                    ?.is_active) === 0).length;

                renderTable(allSuppliers);
            } catch (e) {
                document.getElementById('supplierTable').innerHTML =
                    `<tr><td colspan="7" class="px-5 py-6 text-center text-sm text-red-400">Gagal memuat: ${e.message}</td></tr>`;
            }
        }

        function renderTable(list) {
            const tbody = document.getElementById('supplierTable');
            if (!list.length) {
                tbody.innerHTML =
                    '<tr><td colspan="7" class="px-5 py-6 text-center text-sm text-gray-400">Tidak ada data supplier.</td></tr>';
                return;
            }
            tbody.innerHTML = list.map((s, i) => {
                const isActive = Number(s.user?.is_active) === 1;
                return `
        <tr class="border-t border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800/30">
            <td class="px-5 py-3.5 text-xs text-gray-400">${i+1}</td>
            <td class="px-5 py-3.5">
                <p class="font-medium text-gray-800 dark:text-white text-sm">${s.user?.name || '-'}</p>
                <p class="text-xs text-gray-500 mt-0.5">${s.company_name || '-'}</p>
            </td>
            <td class="px-5 py-3.5 text-sm text-gray-600 dark:text-gray-400">${s.user?.email || '-'}</td>
            <td class="px-5 py-3.5 text-sm text-gray-600 dark:text-gray-400">${s.phone || '-'}</td>
            <td class="px-5 py-3.5">
                <span class="px-2.5 py-1 rounded-full text-xs font-medium ${isActive
                    ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400'
                    : 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400'}">
                    ${isActive ? 'Aktif' : 'Menunggu'}
                </span>
            </td>
            <td class="px-5 py-3.5 text-xs text-gray-500">${s.created_at ? new Date(s.created_at).toLocaleDateString('id-ID') : '-'}</td>
            <td class="px-5 py-3.5 text-right">
                <div class="flex items-center justify-end gap-2">
                    <button onclick="showDetail(${s.id})"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/20 dark:hover:bg-blue-900/40 text-blue-600 dark:text-blue-400 rounded-lg text-xs font-medium transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Detail
                    </button>
                    <button onclick="quickToggle(${s.id}, ${Number(s.user?.is_active)})"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors ${isActive
                            ? 'bg-red-50 hover:bg-red-100 dark:bg-red-900/20 text-red-600 dark:text-red-400'
                            : 'bg-green-50 hover:bg-green-100 dark:bg-green-900/20 text-green-600 dark:text-green-400'}">
                        ${isActive
                            ? `<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>Nonaktifkan`
                            : `<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>Aktifkan`}
                    </button>
                </div>
            </td>
        </tr>`;
            }).join('');
        }

        function doFilter() {
            const q = document.getElementById('searchInput').value.toLowerCase().trim();
            const status = document.getElementById('statusFilter').value; // '' | '1' | '0'

            const filtered = allSuppliers.filter(s => {
                const isActive = Number(s.user?.is_active);
                const matchStatus = status === '' ?
                    true :
                    Number(status) === isActive;

                const matchQ = !q ||
                    (s.user?.name || '').toLowerCase().includes(q) ||
                    (s.company_name || '').toLowerCase().includes(q) ||
                    (s.user?.email || '').toLowerCase().includes(q);

                return matchStatus && matchQ;
            });
            renderTable(filtered);
        }

        function showDetail(id) {
            const s = allSuppliers.find(x => x.id == id);
            if (!s) return;
            currentId = s.id;
            currentActive = Number(s.user?.is_active);

            document.getElementById('detailContent').innerHTML = `
        <div><p class="text-xs text-gray-400 mb-1">Nama PIC</p><p class="font-medium text-gray-800 dark:text-white">${s.user?.name || '-'}</p></div>
        <div><p class="text-xs text-gray-400 mb-1">Email</p><p class="text-gray-700 dark:text-gray-300">${s.user?.email || '-'}</p></div>
        <div class="col-span-2"><p class="text-xs text-gray-400 mb-1">Nama Perusahaan</p><p class="font-semibold text-gray-800 dark:text-white">${s.company_name || '-'}</p></div>
        <div><p class="text-xs text-gray-400 mb-1">Telepon</p><p class="text-gray-700 dark:text-gray-300">${s.phone || '-'}</p></div>
        <div><p class="text-xs text-gray-400 mb-1">NPWP</p><p class="text-gray-700 dark:text-gray-300">${s.npwp || '-'}</p></div>
        <div class="col-span-2"><p class="text-xs text-gray-400 mb-1">Alamat</p><p class="text-gray-700 dark:text-gray-300">${s.address || '-'}</p></div>
        <div><p class="text-xs text-gray-400 mb-1">Status</p>
            <span class="px-2.5 py-1 rounded-full text-xs font-medium ${currentActive === 1
                ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700'}">
                ${currentActive === 1 ? 'Aktif' : 'Menunggu Aktivasi'}
            </span>
        </div>
        <div><p class="text-xs text-gray-400 mb-1">Tgl Daftar</p><p class="text-gray-700 dark:text-gray-300">${s.created_at ? new Date(s.created_at).toLocaleDateString('id-ID') : '-'}</p></div>
    `;

            const btn = document.getElementById('btnToggle');
            btn.textContent = currentActive === 1 ? 'Nonaktifkan' : 'Aktifkan Supplier';
            btn.className = `flex-1 py-2.5 rounded-xl text-white text-sm font-medium transition-colors ${
        currentActive === 1 ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700'
    }`;

            document.getElementById('detailModal').style.removeProperty('display');
            document.getElementById('detailModal').style.display = 'flex';
        }

        function closeDetail() {
            document.getElementById('detailModal').style.display = 'none';
        }

        async function doToggle() {
            const newStatus = currentActive === 1 ? 0 : 1;
            await callToggle(currentId, newStatus);
            closeDetail();
        }

        async function quickToggle(id, currentVal) {
            await callToggle(id, currentVal === 1 ? 0 : 1);
        }

        async function callToggle(id, newStatus) {
            try {
                const res = await fetch(`/api/admin/suppliers/${id}/toggle-status`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF()
                    },
                    body: JSON.stringify({
                        is_active: newStatus
                    })
                });
                const json = await res.json();
                if (res.ok) {
                    toast(newStatus === 1 ? 'Supplier diaktifkan' : 'Supplier dinonaktifkan', 'success');
                    await loadSuppliers();
                } else {
                    toast(json.message || 'Gagal mengubah status', 'error');
                }
            } catch (e) {
                toast('Terjadi kesalahan', 'error');
            }
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

        loadSuppliers();
    </script>
@endsection
