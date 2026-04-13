@extends('layouts.admin')
@section('title', 'Perbandingan Penawaran')
@section('content')
    <div class="p-6">
        <div class="flex items-center gap-4 mb-6">
            <a id="backBtn" href="/admin/batches"
                class="w-10 h-10 bg-gray-700 hover:bg-gray-600 rounded-xl flex items-center justify-center text-gray-400 hover:text-white transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-white">Perbandingan Penawaran</h1>
                <p id="batchInfo" class="text-gray-400 text-sm mt-0.5">-</p>
            </div>
        </div>

        <!-- Winner Summary -->
        <div id="winnerCard"
            class="hidden mb-6 bg-gradient-to-r from-green-900/40 to-green-800/20 rounded-2xl border border-green-700/40 p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-600/30 rounded-xl flex items-center justify-center">
                    <i class="fas fa-trophy text-yellow-400 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Penawaran Terpilih</p>
                    <p id="winnerName" class="text-xl font-bold text-white">-</p>
                    <p id="winnerPrice" class="text-green-400 font-semibold">-</p>
                </div>
            </div>
        </div>

        <!-- Loading -->
        <div id="loadingState" class="bg-gray-800 rounded-2xl border border-gray-700 p-12 text-center text-gray-500">
            <i class="fas fa-spinner fa-spin text-2xl mb-3"></i>
            <p>Memuat data perbandingan...</p>
        </div>

        <!-- Compare Table -->
        <div id="compareContent" class="hidden">
            <div class="bg-gray-800 rounded-2xl border border-gray-700 overflow-hidden">
                <div class="p-5 border-b border-gray-700">
                    <h3 class="font-semibold text-white">Tabel Perbandingan Harga</h3>
                    <p class="text-gray-400 text-xs mt-1">Sistem otomatis menghitung penawaran terbaik berdasarkan total
                        harga terendah</p>
                </div>
                <div class="overflow-x-auto">
                    <div id="compareTableWrapper"></div>
                </div>
            </div>
        </div>

        <!-- No Data -->
        <div id="emptyState" class="hidden bg-gray-800 rounded-2xl border border-gray-700 p-12 text-center">
            <div class="w-16 h-16 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-inbox text-gray-500 text-2xl"></i>
            </div>
            <p class="text-white font-medium">Belum ada penawaran masuk</p>
            <p class="text-gray-500 text-sm mt-1">Tunggu supplier submit penawaran untuk melakukan perbandingan</p>
        </div>
    </div>

    <script>
        const pathParts = window.location.pathname.split('/');
        const batchId = pathParts[pathParts.indexOf('batches') + 1];

        async function loadCompare() {
            try {
                const res = await fetch(`/api/admin/batches/${batchId}/compare`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                const data = await res.json();

                document.getElementById('loadingState').classList.add('hidden');
                document.getElementById('backBtn').href = `/admin/batches/${batchId}`;

                const batch = data.batch || {};
                document.getElementById('batchInfo').textContent = `${batch.batch_number || ''} — ${batch.title || ''}`;

                const quotations = data.quotations || [];

                if (!quotations.length) {
                    document.getElementById('emptyState').classList.remove('hidden');
                    return;
                }

                document.getElementById('compareContent').classList.remove('hidden');

                // Show winner if any approved
                const winner = quotations.find(q => q.status === 'approved');
                if (winner) {
                    document.getElementById('winnerCard').classList.remove('hidden');
                    document.getElementById('winnerName').textContent = winner.invited_supplier?.supplier
                        ?.company_name || '-';
                    document.getElementById('winnerPrice').textContent = 'Rp ' + parseInt(winner.total_price || 0)
                        .toLocaleString('id-ID');
                }

                renderCompareTable(quotations);
            } catch (e) {
                document.getElementById('loadingState').classList.add('hidden');
                document.getElementById('loadingState').innerHTML =
                    '<p class="text-red-400">Gagal memuat data perbandingan</p>';
                document.getElementById('loadingState').classList.remove('hidden');
            }
        }

        function renderCompareTable(quotations) {
            // Sort by total_price ascending (lowest first = best)
            const sorted = [...quotations].sort((a, b) => (parseFloat(a.total_price) || 0) - (parseFloat(b.total_price) ||
                0));
            const lowest = sorted[0]?.total_price;

            const html = `
        <table class="w-full text-sm">
            <thead class="bg-gray-900/60">
                <tr>
                    <th class="text-left px-5 py-4 font-medium text-gray-400">Rank</th>
                    <th class="text-left px-5 py-4 font-medium text-gray-400">Supplier</th>
                    <th class="text-left px-5 py-4 font-medium text-gray-400">File Penawaran</th>
                    <th class="text-left px-5 py-4 font-medium text-gray-400">Catatan</th>
                    <th class="text-right px-5 py-4 font-medium text-gray-400">Total Harga</th>
                    <th class="text-center px-5 py-4 font-medium text-gray-400">Status</th>
                    <th class="text-right px-5 py-4 font-medium text-gray-400">Aksi</th>
                </tr>
            </thead>
            <tbody>
                ${sorted.map((q, i) => {
                    const isLowest = parseFloat(q.total_price) === parseFloat(lowest);
                    const statusMap = { pending: 'bg-yellow-500/20 text-yellow-400', approved: 'bg-green-500/20 text-green-400', rejected: 'bg-red-500/20 text-red-400' };
                    return ` <
                tr class =
                "border-t border-gray-700/50 hover:bg-gray-700/20 ${isLowest && q.status !== 'rejected' ? 'bg-green-900/10' : ''}" >
                <
                td class = "px-5 py-4" >
                <
                div class =
                "w-8 h-8 rounded-lg flex items-center justify-center text-sm font-bold ${i === 0 && q.status !== 'rejected' ? 'bg-yellow-500/20 text-yellow-400' : 'bg-gray-700 text-gray-400'}" >
                $ {
                    i === 0 && q.status !== 'rejected' ? '<i class="fas fa-crown text-xs"></i>' : i + 1
                } <
                /div> <
                /td> <
                td class = "px-5 py-4" >
                <
                p class = "font-medium text-white" > $ {
                    q.invited_supplier?.supplier?.company_name || '-'
                } < /p> <
                p class = "text-gray-500 text-xs" > $ {
                    q.invited_supplier?.supplier?.user?.email || '-'
                } < /p> <
                p class = "text-gray-600 text-xs" > $ {
                    q.submitted_at ? 'Submit: ' + new Date(q.submitted_at).toLocaleDateString('id-ID') : ''
                } < /p> <
                /td> <
                td class = "px-5 py-4" >
                $ {
                    q.file_path ? `<a href="/storage/${q.file_path}" target="_blank" class="flex items-center gap-2 text-blue-400 hover:text-blue-300 text-xs">
                                <i class="fas fa-file-excel"></i>${q.file_name || 'Download'}
                            </a>` : '<span class="text-gray-600">-</span>'
                } <
                /td> <
                td class = "px-5 py-4 text-gray-400 text-xs max-w-xs" > $ {
                    q.note || '-'
                } < /td> <
                td class = "px-5 py-4 text-right" >
                <
                p class = "text-white font-semibold ${isLowest && q.status !== 'rejected' ? 'text-green-400' : ''}" >
                $ {
                    q.total_price ? 'Rp ' + parseInt(q.total_price).toLocaleString('id-ID') : '-'
                } <
                /p>
            $ {
                isLowest && q.status !== 'rejected' ? '<p class="text-green-500 text-xs">Terendah</p>' : ''
            } <
            /td> <
            td class = "px-5 py-4 text-center" >
            <
            span class = "px-2.5 py-1 rounded-full text-xs ${statusMap[q.status] || 'bg-gray-500/20 text-gray-400'}" > $ {
                q.status || '-'
            } < /span> <
            /td> <
            td class = "px-5 py-4 text-right" >
            $ {
                q.status === 'pending' ? `
                            <button onclick="approve(${q.id_quotation})" class="bg-green-600/20 hover:bg-green-600/40 text-green-400 px-3 py-1.5 rounded-lg text-xs mr-1 transition-colors">
                                <i class="fas fa-check mr-1"></i>Approve
                            </button>
                            <button onclick="reject(${q.id_quotation})" class="bg-red-600/20 hover:bg-red-600/40 text-red-400 px-3 py-1.5 rounded-lg text-xs transition-colors">
                                <i class="fas fa-times mr-1"></i>Reject
                            </button>` :
                    q.status === 'approved' && q.po_file_path ? `
                            <a href="/storage/${q.po_file_path}" target="_blank" class="bg-blue-600/20 hover:bg-blue-600/40 text-blue-400 px-3 py-1.5 rounded-lg text-xs transition-colors">
                                <i class="fas fa-download mr-1"></i>Download PO
                            </a>` : '-'
            } <
            /td> <
            /tr>`;
    }).join('')
    } <
    /tbody> <
    /table>
    `;
        document.getElementById('compareTableWrapper').innerHTML = html;
    }

    async function approve(id) {
        if (!confirm('Setujui penawaran ini? Supplier lain yang masih pending akan ditolak secara otomatis.')) return;
        const note = prompt('Catatan untuk supplier (opsional):') || '';
        try {
            const res = await fetch(` / api / admin / quotations / $ {
        id
    }
    /approve`, {
        method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content || ''
            },
            body: JSON.stringify({
                note
            })
        });
        if (res.ok) {
            showToast('Penawaran disetujui & PO digenerate!', 'success');
            await loadCompare();
        } else showToast('Gagal approve', 'error');
        }
        catch (e) {
            showToast('Terjadi kesalahan', 'error');
        }
        }

        async function reject(id) {
            const note = prompt('Alasan penolakan (wajib):');
            if (!note) return;
            try {
                const res = await fetch(`/api/admin/quotations/${id}/reject`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content || ''
                    },
                    body: JSON.stringify({
                        note
                    })
                });
                if (res.ok) {
                    showToast('Penawaran ditolak', 'success');
                    await loadCompare();
                } else showToast('Gagal reject', 'error');
            } catch (e) {
                showToast('Terjadi kesalahan', 'error');
            }
        }

        function showToast(msg, type) {
            const t = document.createElement('div');
            t.className =
                `fixed bottom-5 right-5 px-5 py-3 rounded-xl text-white text-sm z-50 ${type === 'success' ? 'bg-green-600' : 'bg-red-600'}`;
            t.textContent = msg;
            document.body.appendChild(t);
            setTimeout(() => t.remove(), 3000);
        }

        loadCompare();
    </script>
@endsection
