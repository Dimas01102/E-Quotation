@extends('layouts.supplier')
@section('page-title', 'Dashboard')

@section('content')
    <div class="p-6">
        <div class="mb-6">
            <h1 class="text-xl font-bold text-gray-800 dark:text-white">Dashboard</h1>
            <p class="text-sm text-gray-500 mt-0.5">Selamat datang, <span id="welcomeName"
                    class="text-blue-500 font-medium">—</span></p>
        </div>

        <!-- Status belum aktif -->
        <div id="inactiveAlert" style="display:none"
            class="mb-6 flex items-start gap-3 rounded-2xl border border-amber-200 bg-amber-50 dark:border-amber-700 dark:bg-amber-900/20 p-5">
            <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <div>
                <p class="text-amber-700 dark:text-amber-300 font-semibold text-sm">Akun Menunggu Aktivasi</p>
                <p class="text-amber-600 dark:text-amber-400 text-xs mt-1">Akun Anda sedang diverifikasi oleh admin. Anda
                    akan mendapat notifikasi email setelah diaktifkan.</p>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-5">
                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <p id="statInv" class="text-2xl font-bold text-gray-800 dark:text-white">—</p>
                <p class="text-xs text-gray-500 mt-0.5">Undangan RFQ</p>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-5">
                <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                </div>
                <p id="statSubmitted" class="text-2xl font-bold text-gray-800 dark:text-white">—</p>
                <p class="text-xs text-gray-500 mt-0.5">Penawaran Dikirim</p>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-5">
                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                </div>
                <p id="statApproved" class="text-2xl font-bold text-gray-800 dark:text-white">—</p>
                <p class="text-xs text-gray-500 mt-0.5">Penawaran Menang</p>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-5">
                <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900/30 rounded-xl flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <p id="statPO" class="text-2xl font-bold text-gray-800 dark:text-white">—</p>
                <p class="text-xs text-gray-500 mt-0.5">Purchase Order</p>
            </div>
        </div>

        <!-- Two columns -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-5">
            <!-- Recent Invitations -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800">
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-gray-800">
                    <h3 class="font-semibold text-gray-800 dark:text-white text-sm">Undangan RFQ Terbaru</h3>
                    <a href="/supplier/rfq" class="text-xs text-blue-500 hover:text-blue-600 font-medium">Lihat semua →</a>
                </div>
                <div id="recentInv" class="divide-y divide-gray-100 dark:divide-gray-800">
                    <div class="px-5 py-6 text-center text-sm text-gray-400">Memuat...</div>
                </div>
            </div>

            <!-- Recent Quotations -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800">
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-gray-800">
                    <h3 class="font-semibold text-gray-800 dark:text-white text-sm">Status Penawaran Terbaru</h3>
                    <a href="/supplier/quotations" class="text-xs text-blue-500 hover:text-blue-600 font-medium">Lihat semua
                        →</a>
                </div>
                <div id="recentQuot" class="divide-y divide-gray-100 dark:divide-gray-800">
                    <div class="px-5 py-6 text-center text-sm text-gray-400">Memuat...</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        async function loadDashboard() {
            try {
                const res = await fetch('/api/supplier/dashboard', {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                if (res.status === 401) {
                    window.location.href = '/login';
                    return;
                }
                if (!res.ok) throw new Error('HTTP ' + res.status);

                const data = await res.json();

                document.getElementById('welcomeName').textContent = data.company_name || '—';

                // Show inactive alert jika belum aktif
                if (!data.is_active) {
                    document.getElementById('inactiveAlert').style.display = 'flex';
                }

                // Stats
                const s = data.stats || {};
                document.getElementById('statInv').textContent = s.invitations ?? 0;
                document.getElementById('statSubmitted').textContent = s.submitted ?? 0;
                document.getElementById('statApproved').textContent = s.approved ?? 0;
                document.getElementById('statPO').textContent = s.po ?? 0;

                // Recent invitations
                const invList = data.recent_invitations || [];
                document.getElementById('recentInv').innerHTML = invList.length ?
                    invList.map(inv => `
                <div class="px-5 py-3.5 hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-800 dark:text-white truncate">${inv.batch?.title || '—'}</p>
                            <p class="text-xs text-gray-400 mt-0.5">${inv.batch?.batch_number || ''} · Deadline: ${inv.batch?.deadline ? new Date(inv.batch.deadline).toLocaleDateString('id-ID') : '—'}</p>
                        </div>
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium flex-shrink-0 ${
                            inv.status === 'submitted' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700'
                        }">${inv.status || '—'}</span>
                    </div>
                </div>`).join('') :
                    '<div class="px-5 py-6 text-center text-sm text-gray-400">Belum ada undangan RFQ</div>';

                // Recent quotations
                const quotList = data.recent_quotations || [];
                document.getElementById('recentQuot').innerHTML = quotList.length ?
                    quotList.map(q => `
                <div class="px-5 py-3.5 hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-800 dark:text-white truncate">${q.batch_title || '—'}</p>
                            <p class="text-xs text-gray-400 mt-0.5">Rp ${parseInt(q.total_price||0).toLocaleString('id-ID')}</p>
                        </div>
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium flex-shrink-0 ${
                            q.status === 'approved' ? 'bg-green-100 text-green-700' :
                            q.status === 'rejected' ? 'bg-red-100 text-red-600' :
                            'bg-amber-100 text-amber-700'
                        }">${q.status || '—'}</span>
                    </div>
                </div>`).join('') :
                    '<div class="px-5 py-6 text-center text-sm text-gray-400">Belum ada penawaran dikirim</div>';

            } catch (e) {
                console.error('Dashboard supplier error:', e);
            }
        }

        loadDashboard();
    </script>
@endsection
