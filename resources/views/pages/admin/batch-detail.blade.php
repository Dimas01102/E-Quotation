@extends('layouts.admin')
@section('page-title', 'Detail Batch RFQ')

@section('content')
    <div class="p-6" id="pageWrap">

        <!-- Header -->
        <div class="flex items-center gap-4 mb-6">
            <a href="/admin/batches"
                class="w-10 h-10 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl flex items-center justify-center text-gray-500 hover:text-gray-800 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div class="flex-1">
                <div class="flex items-center gap-3">
                    <h1 id="batchTitle" class="text-xl font-bold text-gray-800 dark:text-white">Memuat...</h1>
                    <span id="batchStatusBadge" class="px-2.5 py-1 rounded-full text-xs font-medium"></span>
                </div>
                <p id="batchNumber" class="text-xs text-gray-400 mt-0.5 font-mono"></p>
            </div>
            <div class="flex gap-2">
                <button onclick="openEditBatch()"
                    class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:text-gray-800 rounded-xl text-sm font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </button>
                <button onclick="sendReminder()"
                    class="flex items-center gap-2 px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-sm font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Kirim Reminder
                </button>
            </div>
        </div>

        <!-- Info Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4">
                <p class="text-xs text-gray-400 mb-1">Deadline</p>
                <p id="infoDeadline" class="font-semibold text-gray-800 dark:text-white text-sm">—</p>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4">
                <p class="text-xs text-gray-400 mb-1">Dibuat Oleh</p>
                <p id="infoCreator" class="font-semibold text-gray-800 dark:text-white text-sm">—</p>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4">
                <p class="text-xs text-gray-400 mb-1">Supplier Diundang</p>
                <p id="infoInvited" class="font-semibold text-gray-800 dark:text-white text-sm">—</p>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4">
                <p class="text-xs text-gray-400 mb-1">Penawaran Masuk</p>
                <p id="infoQuotations" class="font-semibold text-gray-800 dark:text-white text-sm">—</p>
            </div>
        </div>

        <!-- Tabs: 3 tab saja (hapus Template Excel) -->
        <div class="flex border-b border-gray-200 dark:border-gray-700 mb-6 gap-1">
            <button onclick="switchTab('cat')" id="tabCat" class="tab-btn active px-5 py-3 text-sm font-medium">Kategori
                &amp; Item</button>
            <button onclick="switchTab('sup')" id="tabSup" class="tab-btn px-5 py-3 text-sm font-medium">Supplier
                Diundang</button>
            <button onclick="switchTab('quot')" id="tabQuot" class="tab-btn px-5 py-3 text-sm font-medium">Penawaran
                Masuk</button>
        </div>

        <!-- Tab: Kategori & Item -->
        <div id="paneCat">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-800 dark:text-white text-sm">Daftar Kategori &amp; Item</h3>
                <button onclick="openAddCat()"
                    class="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Kategori
                </button>
            </div>
            <div id="catList" class="space-y-4">
                <div
                    class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6 text-center text-gray-400 text-sm">
                    Memuat...</div>
            </div>
        </div>

        <!-- Tab: Supplier Diundang -->
        <div id="paneSup" style="display:none">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-800 dark:text-white text-sm">Supplier yang Diundang</h3>
                <button onclick="openInvite()"
                    class="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Undang Supplier
                </button>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-800/60">
                        <tr>
                            <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">#</th>
                            <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Perusahaan</th>
                            <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Kategori</th>
                            <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Tgl Undang</th>
                            <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Status</th>
                        </tr>
                    </thead>
                    <tbody id="supTable">
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center text-gray-400 text-sm">Memuat...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab: Penawaran Masuk -->
        <div id="paneQuot" style="display:none">
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-800/60">
                        <tr>
                            <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">#</th>
                            <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Supplier</th>
                            <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">File</th>
                            <th class="text-right px-5 py-3.5 text-xs font-semibold text-gray-500">Total Harga</th>
                            <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Status</th>
                            <th class="text-right px-5 py-3.5 text-xs font-semibold text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="quotTable">
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-gray-400 text-sm">Memuat...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                <button onclick="compareAll()"
                    class="flex items-center gap-2 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-xl text-sm font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Bandingkan Semua Harga
                </button>
            </div>
        </div>
    </div>

    <!-- Compare Modal -->
    <div id="compareModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60"
        style="display:none!important">
        <div
            class="bg-white dark:bg-gray-900 rounded-2xl w-full max-w-4xl mx-4 shadow-2xl border border-gray-200 dark:border-gray-700 max-h-[90vh] flex flex-col">
            <div
                class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex-shrink-0">
                <div>
                    <h3 class="font-semibold text-gray-800 dark:text-white">Perbandingan Harga</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Diurutkan dari harga terendah (terbaik)</p>
                </div>
                <button onclick="hideModal('compareModal')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div id="compareContent" class="overflow-auto flex-1 p-6"></div>
        </div>
    </div>

    <!-- Edit Batch Modal -->
    <div id="modalEdit" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60"
        style="display:none!important">
        <div
            class="bg-white dark:bg-gray-900 rounded-2xl w-full max-w-md mx-4 shadow-2xl border border-gray-200 dark:border-gray-700">
            <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100 dark:border-gray-800">
                <h3 class="font-semibold text-gray-800 dark:text-white">Edit Batch</h3>
                <button onclick="hideModal('modalEdit')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div id="alertEdit" class="hidden p-3 rounded-xl text-sm bg-red-50 text-red-600 border border-red-100">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">Judul <span
                            class="text-red-500">*</span></label>
                    <input id="editTitle" type="text"
                        class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 dark:text-white">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">Deskripsi</label>
                    <textarea id="editDesc" rows="2"
                        class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 dark:text-white resize-none"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">
                        Deadline <span class="text-red-500">*</span>
                        <span class="text-gray-400 font-normal">(tidak bisa pilih tanggal lampau)</span>
                    </label>
                    <!-- ✅ FIX 7: min="today" diset via JS agar tidak bisa pilih tanggal lampau -->
                    <input id="editDeadline" type="date"
                        class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 dark:text-white">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">Status</label>
                    <!-- ✅ FIX 4: hapus awarded -->
                    <select id="editStatus"
                        class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 dark:text-white">
                        <option value="draft">Draft (Belum dibuka ke supplier)</option>
                        <option value="open">Open (Supplier bisa mengajukan)</option>
                        <option value="closed">Closed (Ditutup, supplier tidak bisa mengajukan)</option>
                    </select>
                </div>
            </div>
            <div class="px-6 pb-6 flex gap-3">
                <button onclick="saveBatch()"
                    class="flex-1 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-medium">Simpan</button>
                <button onclick="hideModal('modalEdit')"
                    class="flex-1 py-2.5 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 rounded-xl text-sm">Batal</button>
            </div>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div id="modalCat" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60"
        style="display:none!important">
        <div
            class="bg-white dark:bg-gray-900 rounded-2xl w-full max-w-md mx-4 shadow-2xl border border-gray-200 dark:border-gray-700">
            <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100 dark:border-gray-800">
                <h3 class="font-semibold text-gray-800 dark:text-white">Tambah Kategori ke Batch</h3>
                <button onclick="hideModal('modalCat')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div id="alertCat" class="hidden p-3 rounded-xl text-sm bg-red-50 text-red-600 border border-red-100">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">Pilih Kategori <span
                            class="text-red-500">*</span></label>
                    <select id="catSel"
                        class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 dark:text-white">
                        <option value="">-- Pilih --</option>
                    </select>
                </div>
            </div>
            <div class="px-6 pb-6 flex gap-3">
                <button onclick="addCat()"
                    class="flex-1 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-medium">Tambah</button>
                <button onclick="hideModal('modalCat')"
                    class="flex-1 py-2.5 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 rounded-xl text-sm">Batal</button>
            </div>
        </div>
    </div>

    <!-- Add Item Modal -->
    <div id="modalItem" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60"
        style="display:none!important">
        <div
            class="bg-white dark:bg-gray-900 rounded-2xl w-full max-w-md mx-4 shadow-2xl border border-gray-200 dark:border-gray-700">
            <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100 dark:border-gray-800">
                <h3 class="font-semibold text-gray-800 dark:text-white">Tambah Item ke Kategori</h3>
                <button onclick="hideModal('modalItem')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div id="alertItem" class="hidden p-3 rounded-xl text-sm bg-red-50 text-red-600 border border-red-100">
                </div>
                <input type="hidden" id="activeCatId">
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">Pilih Item <span
                            class="text-red-500">*</span></label>
                    <select id="itemSel"
                        class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 dark:text-white">
                        <option value="">-- Pilih Item --</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">Quantity <span
                            class="text-red-500">*</span></label>
                    <input id="itemQty" type="number" min="1" placeholder="Jumlah"
                        class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 dark:text-white">
                </div>
            </div>
            <div class="px-6 pb-6 flex gap-3">
                <button onclick="addItem()"
                    class="flex-1 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-medium">Tambah</button>
                <button onclick="hideModal('modalItem')"
                    class="flex-1 py-2.5 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 rounded-xl text-sm">Batal</button>
            </div>
        </div>
    </div>

    <!-- Invite Supplier Modal -->
    <div id="modalInvite" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60"
        style="display:none!important">
        <div
            class="bg-white dark:bg-gray-900 rounded-2xl w-full max-w-md mx-4 shadow-2xl border border-gray-200 dark:border-gray-700">
            <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100 dark:border-gray-800">
                <h3 class="font-semibold text-gray-800 dark:text-white">Undang Supplier</h3>
                <button onclick="hideModal('modalInvite')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div id="alertInvite" class="hidden p-3 rounded-xl text-sm bg-red-50 text-red-600 border border-red-100">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">Pilih Kategori Batch
                        <span class="text-red-500">*</span></label>
                    <select id="invCatSel"
                        class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 dark:text-white">
                        <option value="">-- Pilih kategori --</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">Pilih Supplier Aktif
                        <span class="text-red-500">*</span></label>
                    <select id="invSupSel"
                        class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 dark:text-white">
                        <option value="">-- Pilih supplier --</option>
                    </select>
                </div>
                <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-3 text-xs text-blue-600 dark:text-blue-400">
                    Email undangan akan dikirim otomatis ke supplier.
                </div>
            </div>
            <div class="px-6 pb-6 flex gap-3">
                <button onclick="doInvite()"
                    class="flex-1 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-medium">Undang
                    &amp; Kirim Email</button>
                <button onclick="hideModal('modalInvite')"
                    class="flex-1 py-2.5 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 rounded-xl text-sm">Batal</button>
            </div>
        </div>
    </div>

    <style>
        .tab-btn {
            color: #9ca3af;
            border-bottom: 2px solid transparent;
            transition: all .2s
        }

        .tab-btn:hover {
            color: #374151
        }

        .tab-btn.active {
            color: #2563eb;
            border-bottom-color: #2563eb;
            font-weight: 600
        }

        .dark .tab-btn:hover {
            color: #e5e7eb
        }

        .dark .tab-btn.active {
            color: #60a5fa;
            border-bottom-color: #60a5fa
        }
    </style>

    <script>
        const CSRF = () => document.querySelector('meta[name="csrf-token"]')?.content || '';
        const batchId = window.location.pathname.split('/').pop();
        let batchData = null;
        let allMasterCats = [],
            allMasterItems = [],
            allActiveSuppliers = [],
            batchCategories = [];

        const statusCls = {
            draft: 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400',
            open: 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
            closed: 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400'
        };
        const invCls = {
            invited: 'bg-blue-100 text-blue-700',
            submitted: 'bg-green-100 text-green-700'
        };
        const quotCls = {
            pending: 'bg-amber-100 text-amber-700',
            approved: 'bg-green-100 text-green-700',
            rejected: 'bg-red-100 text-red-600'
        };

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

        function showModal(id) {
            const el = document.getElementById(id);
            el.style.removeProperty('display');
            el.style.display = 'flex';
        }

        function hideModal(id) {
            document.getElementById(id).style.display = 'none';
        }

        async function loadBatch() {
            try {
                const res = await fetch(`/api/admin/batches/${batchId}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                const json = await res.json();
                if (!res.ok) throw new Error(json.message || 'Error');
                batchData = json;
                batchCategories = json.batch_categories || [];

                const b = json.batch;
                document.getElementById('batchTitle').textContent = b.title;
                // ✅ FIX 2: label "No. RFQ"
                document.getElementById('batchNumber').textContent = 'No. RFQ: ' + b.batch_number;
                document.getElementById('infoDeadline').textContent = fmtDate(b.deadline);
                document.getElementById('infoCreator').textContent = b.creator?.name || '—';
                document.getElementById('infoInvited').textContent = (json.invited_suppliers || []).length;
                document.getElementById('infoQuotations').textContent = (json.quotations || []).length;

                const badge = document.getElementById('batchStatusBadge');
                badge.textContent = b.status?.toUpperCase();
                badge.className = 'px-2.5 py-1 rounded-full text-xs font-medium ' + (statusCls[b.status] ||
                    'bg-gray-100 text-gray-600');

                renderCatList(batchCategories);
                renderSupTable(json.invited_suppliers || []);
                renderQuotTable(json.quotations || []);
            } catch (e) {
                document.getElementById('pageWrap').innerHTML =
                    `<div class="text-center py-10 text-red-400">Gagal memuat: ${e.message}</div>`;
            }
        }

        async function loadMasterData() {
            const [cr, ir, sr] = await Promise.all([
                fetch('/api/admin/master-categories', {
                    headers: {
                        'Accept': 'application/json'
                    }
                }),
                fetch('/api/admin/master-items', {
                    headers: {
                        'Accept': 'application/json'
                    }
                }),
                fetch('/api/admin/suppliers', {
                    headers: {
                        'Accept': 'application/json'
                    }
                }),
            ]);
            allMasterCats = (await cr.json()).categories || [];
            allMasterItems = (await ir.json()).items || [];
            allActiveSuppliers = ((await sr.json()).suppliers || []).filter(s => Number(s.user?.is_active) === 1);
        }

        // ─── Render ───────────────────────────────────────────────────────────
        function renderCatList(cats) {
            const el = document.getElementById('catList');
            if (!cats.length) {
                el.innerHTML =
                    '<div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6 text-center text-gray-400 text-sm">Belum ada kategori.</div>';
                return;
            }
            // ✅ FIX 3: HTML yang benar, tidak ada typo tag
            el.innerHTML = cats.map(function(c) {
                var items = c.item_batch_categories || c.itemBatchCategories || [];
                var catName = (c.master_category && c.master_category.name) || (c.masterCategory && c.masterCategory
                    .name) || '—';

                var itemRows = '';
                if (items.length > 0) {
                    items.forEach(function(item, i) {
                        var mi = item.master_item || item.masterItem || {};
                        itemRows +=
                            '<tr class="border-t border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800/30">' +
                            '<td class="px-5 py-3"><span class="font-mono text-xs bg-gray-100 dark:bg-gray-800 px-2 py-0.5 rounded">' +
                            (mi.item_code || '—') + '</span></td>' +
                            '<td class="px-5 py-3 font-medium text-gray-800 dark:text-white text-sm">' + (mi
                                .item_name || '—') + '</td>' +
                            '<td class="px-5 py-3 text-gray-500 text-sm">' + (mi.unit || '—') + '</td>' +
                            '<td class="px-5 py-3 text-center font-semibold text-gray-800 dark:text-white">' +
                            item.quantity + '</td>' +
                            '<td class="px-5 py-3 text-right">' +
                            '<button onclick="deleteItem(' + c.id_batch_category + ',' + item
                            .id_item_batch_category + ')" ' +
                            'class="px-3 py-1 text-xs text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">Hapus</button>' +
                            '</td>' +
                            '</tr>';
                    });
                }

                return '<div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 overflow-hidden">' +
                    '<div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/40">' +
                    '<div class="flex items-center gap-3">' +
                    '<span class="px-2.5 py-1 bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 rounded-full text-xs font-medium">' +
                    catName + '</span>' +
                    '<span class="text-xs text-gray-400">' + items.length + ' item</span>' +
                    '</div>' +
                    '<div class="flex gap-2">' +
                    '<button onclick="openAddItem(' + c.id_batch_category +
                    ')" class="px-3 py-1.5 text-xs font-medium bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition-colors">+ Tambah Item</button>' +
                    '<button onclick="deleteCat(' + c.id_batch_category +
                    ')" class="px-3 py-1.5 text-xs font-medium bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors">Hapus Kategori</button>' +
                    '</div>' +
                    '</div>' +
                    (items.length > 0 ?
                        '<div class="overflow-x-auto"><table class="w-full text-sm">' +
                        '<thead><tr class="border-b border-gray-100 dark:border-gray-800">' +
                        '<th class="text-left px-5 py-3 text-xs font-semibold text-gray-500">Kode</th>' +
                        '<th class="text-left px-5 py-3 text-xs font-semibold text-gray-500">Nama Item</th>' +
                        '<th class="text-left px-5 py-3 text-xs font-semibold text-gray-500">Satuan</th>' +
                        '<th class="text-center px-5 py-3 text-xs font-semibold text-gray-500">Qty</th>' +
                        '<th class="text-right px-5 py-3 text-xs font-semibold text-gray-500">Aksi</th>' +
                        '</tr></thead>' +
                        '<tbody>' + itemRows + '</tbody>' +
                        '</table></div>' :
                        '<p class="px-5 py-4 text-xs text-gray-400">Belum ada item.</p>'
                    ) +
                    '</div>';
            }).join('');
        }

        function renderSupTable(list) {
            const tb = document.getElementById('supTable');
            if (!list.length) {
                tb.innerHTML =
                    '<tr><td colspan="5" class="px-5 py-6 text-center text-gray-400 text-sm">Belum ada supplier diundang.</td></tr>';
                return;
            }
            tb.innerHTML = list.map((inv, i) => {
                var catName = (inv.batch_category && inv.batch_category.master_category && inv.batch_category
                        .master_category.name) ||
                    (inv.batchCategory && inv.batchCategory.masterCategory && inv.batchCategory.masterCategory
                    .name) || '—';
                return '<tr class="border-t border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800/30">' +
                    '<td class="px-5 py-3.5 text-xs text-gray-400">' + (i + 1) + '</td>' +
                    '<td class="px-5 py-3.5"><p class="font-medium text-gray-800 dark:text-white text-sm">' + (inv
                        .supplier?.company_name || '—') + '</p>' +
                    '<p class="text-xs text-gray-400">' + (inv.supplier?.user?.email || '') + '</p></td>' +
                    '<td class="px-5 py-3.5 text-sm text-gray-500">' + catName + '</td>' +
                    '<td class="px-5 py-3.5 text-xs text-gray-400">' + fmtDate(inv.invited_at) + '</td>' +
                    '<td class="px-5 py-3.5"><span class="px-2.5 py-1 rounded-full text-xs font-medium ' + (invCls[
                        inv.status] || 'bg-gray-100 text-gray-500') + '">' + (inv.status || '—') + '</span></td>' +
                    '</tr>';
            }).join('');
        }

        function renderQuotTable(list) {
            const tb = document.getElementById('quotTable');
            if (!list.length) {
                tb.innerHTML =
                    '<tr><td colspan="6" class="px-5 py-6 text-center text-gray-400 text-sm">Belum ada penawaran masuk.</td></tr>';
                return;
            }
            tb.innerHTML = list.map((q, i) => {
                var actions = '';
                if (q.status === 'pending') {
                    actions = '<button onclick="doApprove(' + q.id_quotation +
                        ')" class="px-3 py-1.5 bg-green-50 hover:bg-green-100 text-green-600 rounded-lg text-xs font-medium mr-1">Approve</button>' +
                        '<button onclick="doReject(' + q.id_quotation +
                        ')" class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg text-xs font-medium">Reject</button>';
                } else if (q.status === 'approved' && q.po_file_path) {
                    actions = '<a href="/storage/' + q.po_file_path +
                        '" target="_blank" class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg text-xs font-medium">Download PO</a>';
                }
                return '<tr class="border-t border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800/30">' +
                    '<td class="px-5 py-3.5 text-xs text-gray-400">' + (i + 1) + '</td>' +
                    '<td class="px-5 py-3.5"><p class="font-medium text-gray-800 dark:text-white text-sm">' + (q
                        .invited_supplier?.supplier?.company_name || '—') + '</p></td>' +
                    '<td class="px-5 py-3.5">' + (q.file_path ? '<a href="/storage/' + q.file_path +
                        '" target="_blank" class="text-blue-600 hover:underline text-xs">' + (q.file_name ||
                            'Download') + '</a>' : '—') + '</td>' +
                    '<td class="px-5 py-3.5 text-right font-semibold ' + (q.status === 'approved' ?
                        'text-green-600' : 'text-gray-800 dark:text-white') + '">' + fmtRp(q.total_price) +
                    '</td>' +
                    '<td class="px-5 py-3.5"><span class="px-2.5 py-1 rounded-full text-xs font-medium ' + (quotCls[
                        q.status] || '') + '">' + (q.status || '—') + '</span></td>' +
                    '<td class="px-5 py-3.5 text-right"><div class="flex items-center justify-end gap-2">' +
                    actions + '</div></td>' +
                    '</tr>';
            }).join('');
        }

        // ─── Tab ──────────────────────────────────────────────────────────────
        function switchTab(tab) {
            ['cat', 'sup', 'quot'].forEach(t => {
                document.getElementById('pane' + t.charAt(0).toUpperCase() + t.slice(1)).style.display = t === tab ?
                    '' : 'none';
                document.getElementById('tab' + t.charAt(0).toUpperCase() + t.slice(1)).classList.toggle('active',
                    t === tab);
            });
        }

        // ─── Edit Batch ───────────────────────────────────────────────────────
        function openEditBatch() {
            const b = batchData?.batch;
            if (!b) return;
            document.getElementById('editTitle').value = b.title;
            document.getElementById('editDesc').value = b.description || '';
            document.getElementById('editDeadline').value = b.deadline ? b.deadline.toString().substring(0, 10) : '';
            document.getElementById('editStatus').value = b.status;
            // ✅ FIX 7: set min date = today
            document.getElementById('editDeadline').min = new Date().toISOString().split('T')[0];
            document.getElementById('alertEdit').classList.add('hidden');
            showModal('modalEdit');
        }
        async function saveBatch() {
            const title = document.getElementById('editTitle').value.trim();
            const deadline = document.getElementById('editDeadline').value;
            const status = document.getElementById('editStatus').value;
            const desc = document.getElementById('editDesc').value.trim();
            if (!title || !deadline) {
                setAlert('alertEdit', 'Judul dan deadline wajib.');
                return;
            }
            try {
                const res = await fetch('/api/admin/batches/' + batchId, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF()
                    },
                    body: JSON.stringify({
                        title,
                        description: desc,
                        deadline,
                        status
                    })
                });
                const json = await res.json();
                if (!res.ok || !json.success) {
                    setAlert('alertEdit', json.message || 'Gagal.');
                    return;
                }
                hideModal('modalEdit');
                toast('Batch diperbarui');
                await loadBatch();
            } catch (e) {
                setAlert('alertEdit', 'Kesalahan.');
            }
        }

        // ─── Kategori ─────────────────────────────────────────────────────────
        function openAddCat() {
            document.getElementById('catSel').innerHTML = '<option value="">-- Pilih --</option>' +
                allMasterCats.map(c => '<option value="' + c.id_master_category + '">' + c.name + '</option>').join('');
            document.getElementById('alertCat').classList.add('hidden');
            showModal('modalCat');
        }
        async function addCat() {
            const catId = document.getElementById('catSel').value;
            if (!catId) {
                setAlert('alertCat', 'Pilih kategori.');
                return;
            }
            const res = await fetch('/api/admin/batches/' + batchId + '/categories', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF()
                },
                body: JSON.stringify({
                    id_master_category: catId
                })
            });
            const json = await res.json();
            if (!res.ok || !json.success) {
                setAlert('alertCat', json.message || 'Gagal.');
                return;
            }
            hideModal('modalCat');
            toast('Kategori ditambahkan');
            await loadBatch();
        }
        async function deleteCat(catId) {
            if (!confirm('Hapus kategori ini? Semua item terkait juga terhapus.')) return;
            const res = await fetch('/api/admin/batches/' + batchId + '/categories/' + catId, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF()
                }
            });
            const json = await res.json();
            if (res.ok && json.success) {
                toast('Kategori dihapus');
                await loadBatch();
            } else toast(json.message || 'Gagal', 'error');
        }

        // ─── Item ─────────────────────────────────────────────────────────────
        function openAddItem(catId) {
            document.getElementById('activeCatId').value = catId;
            document.getElementById('itemSel').innerHTML = '<option value="">-- Pilih Item --</option>' +
                allMasterItems.map(i => '<option value="' + i.id_item + '">' + i.item_code + ' — ' + i.item_name + ' (' + i
                    .unit + ')</option>').join('');
            document.getElementById('itemQty').value = '';
            document.getElementById('alertItem').classList.add('hidden');
            showModal('modalItem');
        }
        async function addItem() {
            const catId = document.getElementById('activeCatId').value;
            const itemId = document.getElementById('itemSel').value;
            const qty = document.getElementById('itemQty').value;
            if (!itemId || !qty) {
                setAlert('alertItem', 'Pilih item dan isi quantity.');
                return;
            }
            const res = await fetch('/api/admin/batches/' + batchId + '/categories/' + catId + '/items', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF()
                },
                body: JSON.stringify({
                    id_item: itemId,
                    quantity: qty
                })
            });
            const json = await res.json();
            if (!res.ok || !json.success) {
                setAlert('alertItem', json.message || 'Gagal.');
                return;
            }
            hideModal('modalItem');
            toast('Item ditambahkan');
            await loadBatch();
        }
        async function deleteItem(catId, itemId) {
            if (!confirm('Hapus item ini?')) return;
            const res = await fetch('/api/admin/batches/' + batchId + '/categories/' + catId + '/items/' + itemId, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF()
                }
            });
            const json = await res.json();
            if (res.ok && json.success) {
                toast('Item dihapus');
                await loadBatch();
            } else toast(json.message || 'Gagal', 'error');
        }

        // ─── Invite ───────────────────────────────────────────────────────────
        function openInvite() {
            document.getElementById('invCatSel').innerHTML = '<option value="">-- Pilih kategori --</option>' +
                batchCategories.map(c => {
                    var name = (c.master_category && c.master_category.name) || (c.masterCategory && c.masterCategory
                        .name) || c.id_batch_category;
                    return '<option value="' + c.id_batch_category + '">' + name + '</option>';
                }).join('');
            document.getElementById('invSupSel').innerHTML = '<option value="">-- Pilih supplier --</option>' +
                allActiveSuppliers.map(s => '<option value="' + s.id + '">' + s.company_name + ' (' + (s.user?.name || '') +
                    ')</option>').join('');
            document.getElementById('alertInvite').classList.add('hidden');
            showModal('modalInvite');
        }
        async function doInvite() {
            const catId = document.getElementById('invCatSel').value;
            const supId = document.getElementById('invSupSel').value;
            if (!catId || !supId) {
                setAlert('alertInvite', 'Pilih kategori dan supplier.');
                return;
            }
            const res = await fetch('/api/admin/batches/' + batchId + '/invite', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF()
                },
                body: JSON.stringify({
                    id_supplier: supId,
                    id_batch_category: catId
                })
            });
            const json = await res.json();
            if (!res.ok || !json.success) {
                setAlert('alertInvite', json.message || 'Gagal.');
                return;
            }
            hideModal('modalInvite');
            toast('Supplier diundang & email terkirim');
            await loadBatch();
        }

        // ─── Compare ──────────────────────────────────────────────────────────
        async function compareAll() {
            try {
                const res = await fetch('/api/admin/quotations/compare/' + batchId, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                const json = await res.json();
                const list = json.quotations || [];

                if (!list.length) {
                    toast('Belum ada penawaran untuk dibandingkan.', 'error');
                    return;
                }

                const lowestPrice = parseFloat(list[0]?.total_price || 0);

                document.getElementById('compareContent').innerHTML =
                    '<div class="overflow-x-auto">' +
                    '<table class="w-full text-sm">' +
                    '<thead class="bg-gray-50 dark:bg-gray-800/60"><tr>' +
                    '<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500">Rank</th>' +
                    '<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500">Supplier</th>' +
                    '<th class="text-right px-4 py-3 text-xs font-semibold text-gray-500">Total Harga</th>' +
                    '<th class="text-center px-4 py-3 text-xs font-semibold text-gray-500">Status</th>' +
                    '<th class="text-right px-4 py-3 text-xs font-semibold text-gray-500">Aksi</th>' +
                    '</tr></thead><tbody>' +
                    list.map(function(q, i) {
                        var isLowest = parseFloat(q.total_price) === lowestPrice && q.status !== 'rejected';
                        var rankBg = i === 0 && q.status !== 'rejected' ? 'bg-yellow-100 text-yellow-700' :
                            'bg-gray-100 text-gray-500';
                        var rankTxt = i === 0 && q.status !== 'rejected' ? '🥇' : (i + 1);
                        var sCls = {
                            pending: 'bg-amber-100 text-amber-700',
                            approved: 'bg-green-100 text-green-700',
                            rejected: 'bg-red-100 text-red-600'
                        };
                        var actions = '';
                        if (q.status === 'pending') {
                            actions = '<button onclick="doApprove(' + q.id_quotation +
                                ');hideModal(\'compareModal\')" class="px-2.5 py-1 bg-green-50 hover:bg-green-100 text-green-600 rounded text-xs mr-1">Approve</button>' +
                                '<button onclick="doReject(' + q.id_quotation +
                                ');hideModal(\'compareModal\')" class="px-2.5 py-1 bg-red-50 hover:bg-red-100 text-red-600 rounded text-xs">Reject</button>';
                        } else if (q.status === 'approved' && q.po_file_path) {
                            actions = '<a href="/storage/' + q.po_file_path +
                                '" target="_blank" class="px-2.5 py-1 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded text-xs">PO</a>';
                        }
                        return '<tr class="border-t border-gray-100 dark:border-gray-800 ' + (isLowest ?
                                'bg-green-50/30' : '') + '">' +
                            '<td class="px-4 py-3"><span class="w-7 h-7 inline-flex items-center justify-center rounded-lg text-xs font-bold ' +
                            rankBg + '">' + rankTxt + '</span></td>' +
                            '<td class="px-4 py-3"><p class="font-medium text-sm text-gray-800 dark:text-white">' +
                            (q.invited_supplier?.supplier?.company_name || '—') + '</p>' +
                            '<p class="text-xs text-gray-400">' + (q.invited_supplier?.supplier?.user?.email ||
                            '') + '</p></td>' +
                            '<td class="px-4 py-3 text-right"><p class="font-bold text-sm ' + (isLowest ?
                                'text-green-600' : 'text-gray-800') + '">' + fmtRp(q.total_price) + '</p>' +
                            (isLowest ? '<p class="text-green-500 text-xs">Terendah ✓</p>' : '') + '</td>' +
                            '<td class="px-4 py-3 text-center"><span class="px-2.5 py-1 rounded-full text-xs font-medium ' +
                            (sCls[q.status] || '') + '">' + q.status + '</span></td>' +
                            '<td class="px-4 py-3 text-right">' + actions + '</td>' +
                            '</tr>';
                    }).join('') +
                    '</tbody></table></div>';

                showModal('compareModal');
            } catch (e) {
                toast('Gagal: ' + e.message, 'error');
            }
        }

        // ─── Approve / Reject ─────────────────────────────────────────────────
        async function doApprove(id) {
            if (!confirm('Setujui penawaran ini? PO akan digenerate otomatis.')) return;
            const res = await fetch('/api/admin/quotations/' + id + '/approve', {
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
                toast('Approved! PO digenerate.');
                await loadBatch();
            } else toast(json.message || 'Gagal', 'error');
        }
        async function doReject(id) {
            const note = prompt('Alasan penolakan (wajib):');
            if (!note) return;
            const res = await fetch('/api/admin/quotations/' + id + '/reject', {
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
            if (res.ok && json.success) {
                toast('Penawaran ditolak.');
                await loadBatch();
            } else toast(json.message || 'Gagal', 'error');
        }

        // ─── Reminder ─────────────────────────────────────────────────────────
        async function sendReminder() {
            if (!confirm('Kirim email reminder ke supplier pemenang di batch ini?')) return;
            const res = await fetch('/api/admin/batches/' + batchId + '/send-reminder', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF()
                },
                body: JSON.stringify({})
            });
            const json = await res.json();
            if (res.ok && json.success) toast('Reminder terkirim!');
            else toast(json.message || 'Gagal', 'error');
        }

        // ─── Helpers ──────────────────────────────────────────────────────────
        function setAlert(id, msg) {
            const el = document.getElementById(id);
            el.textContent = msg;
            el.classList.remove('hidden');
        }

        function toast(msg, type = 'success') {
            const t = document.createElement('div');
            t.className = 'fixed bottom-5 right-5 px-5 py-3 rounded-xl text-white text-sm z-[9999] shadow-lg ' + (type ===
                'success' ? 'bg-green-600' : 'bg-red-600');
            t.textContent = msg;
            document.body.appendChild(t);
            setTimeout(() => t.remove(), 3500);
        }

        // ─── Init ─────────────────────────────────────────────────────────────
        Promise.all([loadBatch(), loadMasterData()]);
    </script>
@endsection
