@extends('layouts.supplier')
@section('page-title', 'RFQ & Undangan')

@section('content')
    <div class="p-6">
        <div class="mb-6">
            <h1 class="text-xl font-bold text-gray-800 dark:text-white">RFQ &amp; Undangan</h1>
            <p class="text-sm text-gray-500 mt-0.5">Daftar undangan pengadaan yang Anda terima (status: Open)</p>
        </div>

        <!-- Filter -->
        <div class="mb-4">
            <select id="statusFilter" onchange="doFilter()"
                class="text-sm bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2 focus:outline-none text-gray-800 dark:text-white">
                <option value="">Semua Status</option>
                <option value="invited">Diundang</option>
                <option value="submitted">Sudah Submit</option>
            </select>
        </div>

        <!-- Loading -->
        <div id="loadingState"
            class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-12 text-center text-gray-400">
            <svg class="w-8 h-8 animate-spin mx-auto mb-3 text-gray-300" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
            </svg>
            Memuat undangan...
        </div>

        <!-- Error -->
        <div id="errorState"
            class="hidden bg-red-50 dark:bg-red-900/20 rounded-2xl border border-red-200 dark:border-red-800 p-8 text-center text-red-500 text-sm">
        </div>

        <!-- List -->
        <div id="listState" class="hidden space-y-4"></div>

        <!-- Empty -->
        <div id="emptyState"
            class="hidden bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-12 text-center">
            <div class="w-14 h-14 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
            </div>
            <p class="text-gray-500 text-sm">Belum ada undangan RFQ yang aktif</p>
            <p class="text-gray-400 text-xs mt-1">Undangan akan muncul saat batch berstatus Open</p>
        </div>
    </div>

    <!-- Detail Modal -->
    <div id="detailModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm"
        style="display:none!important">
        <div
            class="bg-white dark:bg-gray-900 rounded-2xl w-full max-w-2xl mx-4 shadow-2xl border border-gray-200 dark:border-gray-700 max-h-[90vh] flex flex-col">
            <div
                class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex-shrink-0">
                <h3 id="modalBatchTitle" class="font-semibold text-gray-800 dark:text-white">Detail Undangan</h3>
                <button onclick="closeDetail()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div id="modalContent" class="overflow-y-auto flex-1 p-6"></div>
            <div class="px-6 pb-6 flex-shrink-0">
                <button onclick="closeDetail()"
                    class="w-full py-2.5 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 rounded-xl text-sm">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        const CSRF = () => document.querySelector('meta[name="csrf-token"]')?.content || '';
        let allInvitations = [];

        function fmtDate(d) {
            return d ? new Date(d).toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            }) : '—';
        }

        function fmtRp(n) {
            return n ? 'Rp ' + parseInt(n).toLocaleString('id-ID') : '—';
        }

        const statusCls = {
            invited: 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
            submitted: 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
        };

        function showModal(id) {
            const el = document.getElementById(id);
            el.style.removeProperty('display');
            el.style.display = 'flex';
        }

        function closeDetail() {
            document.getElementById('detailModal').style.display = 'none';
        }

        async function loadInvitations() {
            try {
                const res = await fetch('/api/supplier/rfq', {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                if (res.status === 401) {
                    window.location.href = '/login';
                    return;
                }
                if (!res.ok) throw new Error('HTTP ' + res.status);
                const json = await res.json();
                allInvitations = json.invitations || [];
                showList(allInvitations);
            } catch (e) {
                document.getElementById('loadingState').classList.add('hidden');
                document.getElementById('errorState').classList.remove('hidden');
                document.getElementById('errorState').textContent = 'Gagal memuat undangan: ' + e.message;
            }
        }

        function showList(list) {
            document.getElementById('loadingState').classList.add('hidden');
            document.getElementById('errorState').classList.add('hidden');

            if (!list.length) {
                document.getElementById('listState').classList.add('hidden');
                document.getElementById('emptyState').classList.remove('hidden');
                return;
            }

            document.getElementById('emptyState').classList.add('hidden');
            document.getElementById('listState').classList.remove('hidden');

            document.getElementById('listState').innerHTML = list.map(inv => {
                const batch = inv.batch || {};
                const category = inv.category || {};
                const quotation = inv.quotation;
                const deadline = batch.deadline ? new Date(batch.deadline) : null;
                const isExpired = deadline && deadline < new Date();

                return `
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-5 hover:border-blue-300 dark:hover:border-blue-700 transition-colors">
            <div class="flex items-start justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 flex-wrap mb-1">
                        <!-- ✅ FIX 2: label "No. RFQ" bukan "No. Batch" -->
                        <span class="text-xs text-gray-400 font-mono">No. RFQ: ${batch.batch_number || '—'}</span>
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium ${statusCls[inv.status] || 'bg-gray-100 text-gray-600'}">${inv.status || '—'}</span>
                        ${isExpired ? '<span class="px-2 py-0.5 bg-red-100 text-red-600 rounded-full text-xs">Expired</span>' : ''}
                    </div>
                    <h3 class="font-semibold text-gray-800 dark:text-white">${batch.title || '—'}</h3>
                    <p class="text-sm text-gray-500 mt-0.5">Kategori: ${category.name || '—'}</p>
                    <div class="flex items-center gap-4 mt-2 text-xs text-gray-400">
                        <span>Deadline: <strong class="${isExpired ? 'text-red-500' : 'text-gray-600 dark:text-gray-300'}">${fmtDate(batch.deadline)}</strong></span>
                        <span>Diundang: ${fmtDate(inv.invited_at)}</span>
                    </div>
                    ${quotation ? `
                        <div class="mt-3 inline-flex items-center gap-2 px-3 py-1.5 bg-green-50 dark:bg-green-900/20 rounded-xl text-xs text-green-700 dark:text-green-400 font-medium">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Penawaran sudah dikirim · ${fmtRp(quotation.total_price)}
                        </div>` : ''}
                </div>
                <div class="flex flex-col gap-2 flex-shrink-0">
                    <!-- ✅ FIX 6: HANYA tombol Detail, tidak ada Submit di sini -->
                    <button onclick="showDetail(${inv.id_invited_supplier})"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-50 hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-400 rounded-lg text-xs font-medium transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Lihat Detail
                    </button>
                    <!-- Jika belum submit dan masih bisa ajukan, arahkan ke halaman penawaran -->
                    ${!quotation && inv.can_submit ? `
                        <a href="/supplier/quotations"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-medium transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            Ajukan Penawaran
                        </a>` : ''}
                    <!-- ✅ FIX 4: tampilkan info jika tidak bisa ajukan -->
                    ${!quotation && !inv.can_submit && isExpired ? `
                        <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-gray-100 dark:bg-gray-800 text-gray-400 rounded-lg text-xs">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Deadline lewat
                        </span>` : ''}
                </div>
            </div>
        </div>`;
            }).join('');
        }

        function doFilter() {
            const s = document.getElementById('statusFilter').value;
            const list = s ? allInvitations.filter(i => i.status === s) : allInvitations;
            showList(list);
        }

        function showDetail(id) {
            const inv = allInvitations.find(x => x.id_invited_supplier == id);
            if (!inv) return;
            const batch = inv.batch || {};
            const category = inv.category || {};
            const items = inv.items || [];

            document.getElementById('modalBatchTitle').textContent = batch.title || 'Detail';
            document.getElementById('modalContent').innerHTML = `
        <div class="space-y-5">
            <div class="grid grid-cols-2 gap-4 text-sm">
                <!-- ✅ FIX 2: label "No. RFQ" -->
                <div><p class="text-xs text-gray-400 mb-1">No. RFQ</p><p class="font-mono font-medium text-gray-800 dark:text-white">${batch.batch_number || '—'}</p></div>
                <div><p class="text-xs text-gray-400 mb-1">Status Batch</p>
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium ${batch.status === 'open' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600'}">${batch.status || '—'}</span>
                </div>
                <div class="col-span-2"><p class="text-xs text-gray-400 mb-1">Deskripsi</p><p class="text-gray-700 dark:text-gray-300">${batch.description || '—'}</p></div>
                <div><p class="text-xs text-gray-400 mb-1">Kategori</p><p class="font-medium text-gray-800 dark:text-white">${category.name || '—'}</p></div>
                <div><p class="text-xs text-gray-400 mb-1">Deadline</p><p class="font-medium text-gray-800 dark:text-white">${fmtDate(batch.deadline)}</p></div>
            </div>
            ${items.length ? `
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Daftar Item yang Diminta</p>
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-xl overflow-hidden">
                        <table class="w-full text-sm">
                            <thead><tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="text-left px-4 py-2.5 text-xs font-medium text-gray-500">Item</th>
                                <th class="text-left px-4 py-2.5 text-xs font-medium text-gray-500">Kode</th>
                                <th class="text-left px-4 py-2.5 text-xs font-medium text-gray-500">Satuan</th>
                                <th class="text-right px-4 py-2.5 text-xs font-medium text-gray-500">Qty</th>
                            </tr></thead>
                            <tbody>${items.map(item => `
                            <tr class="border-t border-gray-200 dark:border-gray-700">
                                <td class="px-4 py-2.5 text-gray-700 dark:text-gray-300">${item.item_name || '—'}</td>
                                <td class="px-4 py-2.5 text-gray-500 font-mono text-xs">${item.item_code || '—'}</td>
                                <td class="px-4 py-2.5 text-gray-500">${item.unit || '—'}</td>
                                <td class="px-4 py-2.5 text-right font-semibold text-gray-800 dark:text-white">${item.quantity}</td>
                            </tr>`).join('')}
                            </tbody>
                        </table>
                    </div>
                </div>` : ''}
            ${inv.quotation ? `
                <div class="bg-green-50 dark:bg-green-900/20 rounded-xl p-4 border border-green-200 dark:border-green-800">
                    <p class="text-xs font-semibold text-green-700 dark:text-green-400 uppercase mb-2">Status Penawaran Anda</p>
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div><p class="text-xs text-gray-400">Total Harga</p><p class="font-bold text-gray-800 dark:text-white">${fmtRp(inv.quotation.total_price)}</p></div>
                        <div><p class="text-xs text-gray-400">Status</p>
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium ${
                                inv.quotation.status === 'approved' ? 'bg-green-100 text-green-700' :
                                inv.quotation.status === 'rejected' ? 'bg-red-100 text-red-600' :
                                'bg-amber-100 text-amber-700'
                            }">${inv.quotation.status}</span>
                        </div>
                    </div>
                </div>` : `
                <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4 border border-blue-200 dark:border-blue-800 text-center">
                    <p class="text-sm text-blue-700 dark:text-blue-400 font-medium">Belum ada penawaran</p>
                    ${inv.can_submit ? `
                <a href="/supplier/quotations" class="inline-flex items-center gap-2 mt-3 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-medium transition-colors">
                    Ajukan Penawaran di halaman Penawaran Saya →
                </a>` : '<p class="text-xs text-blue-500 mt-1">Pengajuan tidak tersedia saat ini.</p>'}
                </div>`}
        </div>
    `;

            showModal('detailModal');
        }

        loadInvitations();
    </script>
@endsection
