@extends('layouts.supplier')
@section('page-title', 'Detail Undangan')

@section('content')
    <div class="mb-5">
        <a href="/supplier/invitations"
            class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-emerald-500 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Daftar Undangan
        </a>
    </div>

    <!-- Header -->
    <div id="inv-hdr" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-5 mb-5">
        <div class="animate-pulse space-y-2">
            <div class="h-6 bg-gray-200 dark:bg-gray-700 rounded w-1/3"></div>
        </div>
    </div>

    <!-- Template Download -->
    <div id="template-block"
        class="hidden bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-700 rounded-2xl p-5 mb-5">
        <div class="flex items-start gap-4">
            <div
                class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div class="flex-1">
                <h4 class="font-bold text-emerald-800 dark:text-emerald-300 text-sm mb-1">Template Penawaran Tersedia</h4>
                <p class="text-xs text-emerald-600 dark:text-emerald-400 mb-3">Admin telah menyiapkan template Excel.
                    Download, isi data penawaran Anda, lalu upload di form di bawah.</p>
                <a id="template-link" href="#" target="_blank"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold rounded-xl transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download Template Excel
                </a>
            </div>
        </div>
    </div>

    <!-- Items -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 overflow-hidden mb-5">
        <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800">
            <h3 class="font-bold text-sm text-gray-800 dark:text-white">Item yang Diminta</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-800/50">
                    <tr>
                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Kode
                        </th>
                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Nama
                            Item</th>
                        <th class="text-center px-5 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Qty
                        </th>
                        <th class="text-center px-5 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">
                            Satuan</th>
                    </tr>
                </thead>
                <tbody id="items-table">
                    <tr>
                        <td colspan="4" class="px-5 py-6 text-center text-gray-400 text-sm">Memuat...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Submit Form -->
    <div id="submit-form-wrap">
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-5">
            <h3 class="font-bold text-sm text-gray-800 dark:text-white mb-1">Submit Penawaran</h3>
            <p class="text-xs text-gray-400 dark:text-gray-500 mb-5">
                Upload file penawaran (Excel/PDF) dan isi total harga. Sistem akan otomatis membandingkan penawaran dari
                semua supplier.
            </p>

            <div id="form-error"
                class="hidden mb-4 p-3.5 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-xl text-sm text-red-600 dark:text-red-400">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">Total Harga Penawaran
                        (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" id="total-price" min="0" step="1000" placeholder="0"
                        class="h-10 w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-transparent px-4 text-sm text-gray-800 dark:text-white focus:outline-none focus:border-emerald-400 transition-colors"
                        oninput="document.getElementById('total-preview').textContent=fmtRp(this.value||0)" />
                    <p id="total-preview" class="text-xs text-emerald-600 font-semibold mt-1">Rp 0</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">Catatan /
                        Keterangan</label>
                    <input type="text" id="note" placeholder="Catatan tambahan opsional"
                        class="h-10 w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-transparent px-4 text-sm text-gray-800 dark:text-white focus:outline-none focus:border-emerald-400 transition-colors" />
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">
                        Upload File Penawaran <span class="text-red-500">*</span>
                    </label>
                    <div
                        class="border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-xl p-4 hover:border-emerald-400 transition-colors">
                        <input type="file" id="quo-file" accept=".xlsx,.xls,.csv,.pdf,.doc,.docx"
                            class="w-full text-sm text-gray-500 dark:text-gray-400
                   file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0
                   file:text-xs file:font-semibold file:bg-emerald-100 file:text-emerald-700
                   hover:file:bg-emerald-200 file:cursor-pointer" />
                        <p class="text-xs text-gray-400 mt-2">Format: Excel (.xlsx/.xls/.csv), PDF, atau Word. Maks 10MB.
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <button onclick="window.history.back()"
                    class="px-5 py-2.5 text-sm bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-medium transition-colors">Batal</button>
                <button id="submit-btn" onclick="submitQuotation()"
                    class="px-6 py-2.5 text-sm bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl font-bold transition-colors shadow-lg shadow-emerald-500/25">Kirim
                    Penawaran →</button>
            </div>
        </div>
    </div>

    <!-- Already Submitted -->
    <div id="already-wrap"
        class="hidden bg-white dark:bg-gray-900 rounded-2xl border border-emerald-200 dark:border-emerald-700 p-6 text-center">
        <div
            class="w-16 h-16 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center mx-auto mb-3">
            <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <h3 class="font-bold text-gray-800 dark:text-white mb-1">Penawaran Telah Dikirim</h3>
        <p id="submitted-info" class="text-sm text-gray-500 dark:text-gray-400 mb-3">Penawaran Anda sedang dalam proses
            review. Sistem membandingkan semua penawaran secara otomatis.</p>
        <a href="/supplier/quotations"
            class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 text-sm font-semibold rounded-xl transition-colors">
            Lihat Status Penawaran →
        </a>
    </div>
@endsection

@push('scripts')
    <script>
        const INVITE_ID = {{ $inviteId }};

        async function loadDetail() {
            const r = await API.get(`/supplier/invitations/${INVITE_ID}`);
            if (!r.success) {
                document.getElementById('inv-hdr').innerHTML =
                    `<p class="text-sm text-red-500">Undangan tidak ditemukan.</p>`;
                return;
            }
            const inv = r.data;
            const batch = inv.batch_category?.batch;
            const cat = inv.batch_category?.master_category;
            const items = inv.batch_category?.item_batch_categories || [];

            // Header
            document.getElementById('inv-hdr').innerHTML = `
    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
      <div>
        <div class="flex items-center gap-2 mb-2">
          <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/30 px-3 py-1 rounded-full">${batch?.batch_number||'-'}</span>
          ${badge(batch?.status||'draft')}
        </div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">${batch?.title||'-'}</h2>
        <p class="text-sm text-gray-500 mt-0.5">Kategori: ${cat?.name||'-'}</p>
      </div>
      <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-xl p-4 text-center flex-shrink-0">
        <p class="text-xs text-red-500 font-semibold mb-0.5">Deadline Submit</p>
        <p class="text-base font-bold text-red-600">${fmtDate(batch?.deadline)}</p>
      </div>
    </div>`;

            // Template
            if (inv.template?.file_url) {
                document.getElementById('template-block').classList.remove('hidden');
                document.getElementById('template-link').href = inv.template.file_url;
            }

            // Items table
            document.getElementById('items-table').innerHTML = !items.length ?
                `<tr><td colspan="4" class="px-5 py-6 text-center text-sm text-gray-400">Belum ada item terdaftar.</td></tr>` :
                items.map(i => `
      <tr class="border-b border-gray-50 dark:border-gray-800/50">
        <td class="px-5 py-3 text-xs font-mono font-bold text-brand-600 dark:text-brand-400">${i.master_item?.item_code||'-'}</td>
        <td class="px-5 py-3 text-sm font-medium text-gray-800 dark:text-white">${i.master_item?.item_name||'-'}</td>
        <td class="px-5 py-3 text-center font-bold text-gray-800 dark:text-white">${Number(i.quantity).toLocaleString('id-ID')}</td>
        <td class="px-5 py-3 text-center text-xs text-gray-500">${i.master_item?.unit||'-'}</td>
      </tr>`).join('');

            // Cek sudah submit
            const latestQuo = inv.latest_quotation;
            if (latestQuo && ['submitted', 'reviewed', 'approved'].includes(latestQuo.status) || batch?.status !==
                'open') {
                document.getElementById('submit-form-wrap').classList.add('hidden');
                document.getElementById('already-wrap').classList.remove('hidden');
                if (latestQuo) {
                    document.getElementById('submitted-info').textContent =
                        `Penawaran #${latestQuo.id_quotation} (Total: ${fmtRp(latestQuo.total_price)}) berhasil dikirim. Status: ${latestQuo.status}`;
                }
                if (batch?.status !== 'open') {
                    document.getElementById('submitted-info').textContent =
                        `Batch RFQ ini sudah ${batch?.status}. Penawaran tidak dapat disubmit.`;
                }
            }
        }

        async function submitQuotation() {
            const btn = document.getElementById('submit-btn');
            btn.disabled = true;
            btn.textContent = 'Mengirim...';

            const totalPrice = document.getElementById('total-price').value;
            const note = document.getElementById('note').value;
            const file = document.getElementById('quo-file').files[0];

            if (!totalPrice || parseFloat(totalPrice) <= 0) {
                document.getElementById('form-error').textContent = 'Total harga wajib diisi dan lebih dari 0.';
                document.getElementById('form-error').classList.remove('hidden');
                btn.disabled = false;
                btn.textContent = 'Kirim Penawaran →';
                return;
            }
            if (!file) {
                document.getElementById('form-error').textContent = 'File penawaran wajib diupload.';
                document.getElementById('form-error').classList.remove('hidden');
                btn.disabled = false;
                btn.textContent = 'Kirim Penawaran →';
                return;
            }

            const fd = new FormData();
            fd.append('id_invited_supplier', INVITE_ID);
            fd.append('total_price', totalPrice);
            fd.append('note', note || '');
            fd.append('file', file);

            const r = await API.upload('/supplier/quotations', fd);
            if (r.success) {
                showToast('Penawaran berhasil dikirim!');
                document.getElementById('submit-form-wrap').classList.add('hidden');
                document.getElementById('already-wrap').classList.remove('hidden');
                document.getElementById('submitted-info').textContent =
                    `Penawaran #${r.data.id_quotation} (Total: ${fmtRp(r.data.total_price)}) berhasil dikirim. Sistem membandingkan semua penawaran secara otomatis.`;
            } else {
                const msg = r.errors ? Object.values(r.errors).flat().join(', ') : r.message;
                document.getElementById('form-error').textContent = msg;
                document.getElementById('form-error').classList.remove('hidden');
            }
            btn.disabled = false;
            btn.textContent = 'Kirim Penawaran →';
        }

        loadDetail();
    </script>
@endpush
