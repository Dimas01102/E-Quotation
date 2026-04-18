@extends('layouts.admin')
@section('page-title', 'Master Data')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-5">
        <div>
            <h1 class="text-xl font-bold text-gray-800 dark:text-white">Master Data</h1>
            <p class="text-sm text-gray-500 mt-0.5">Kelola kategori, item, dan template RFQ</p>
        </div>
        <button onclick="openAdd()"
            class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span id="btnAddLabel">Tambah Kategori</span>
        </button>
    </div>

    <!-- Tabs -->
    <div class="flex gap-1 mb-5 bg-gray-100 dark:bg-gray-800 rounded-xl p-1 w-fit">
        <button onclick="switchTab('cat')" id="tabCat"
            class="px-4 py-2 rounded-lg text-sm font-medium transition-all bg-white dark:bg-gray-700 text-gray-800 dark:text-white shadow-sm">Kategori</button>
        <button onclick="switchTab('item')" id="tabItem"
            class="px-4 py-2 rounded-lg text-sm font-medium transition-all text-gray-500 hover:text-gray-700 dark:text-gray-400">Item</button>
        <button onclick="switchTab('tpl')" id="tabTpl"
            class="px-4 py-2 rounded-lg text-sm font-medium transition-all text-gray-500 hover:text-gray-700 dark:text-gray-400">Template Excel</button>
    </div>

    <!-- Search -->
    <div class="mb-4 flex gap-3 items-center">
        <div class="relative w-80">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input id="searchInput" type="text" placeholder="Cari..."
                class="w-full pl-9 pr-4 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 dark:text-white" oninput="doSearch()">
        </div>
        <select id="catItemFilter" onchange="filterItems()" style="display:none"
            class="text-sm bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2 focus:outline-none text-gray-800 dark:text-white">
            <option value="">Semua Kategori</option>
        </select>
    </div>

    <!-- Kategori Pane -->
    <div id="paneCat">
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-800/60">
                    <tr>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">#</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Nama Kategori</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Deskripsi</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Jml Item</th>
                        <th class="text-right px-5 py-3.5 text-xs font-semibold text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody id="catBody"><tr><td colspan="5" class="px-5 py-8 text-center text-gray-400 text-sm">Memuat...</td></tr></tbody>
            </table>
        </div>
    </div>

    <!-- Item Pane -->
    <div id="paneItem" style="display:none">
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-800/60">
                    <tr>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">#</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Kode</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Nama Item</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Kategori</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Satuan</th>
                        <th class="text-right px-5 py-3.5 text-xs font-semibold text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody id="itemBody"><tr><td colspan="6" class="px-5 py-8 text-center text-gray-400 text-sm">Memuat...</td></tr></tbody>
            </table>
        </div>
    </div>

    <!-- Template Excel Pane -->
    <div id="paneTpl" style="display:none">
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-800/60">
                    <tr>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">#</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Judul Template</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">File</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Status</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500">Diupload</th>
                        <th class="text-right px-5 py-3.5 text-xs font-semibold text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tplBody"><tr><td colspan="6" class="px-5 py-8 text-center text-gray-400 text-sm">Memuat...</td></tr></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Kategori -->
<div id="modalCat" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60" style="display:none!important">
    <div class="bg-white dark:bg-gray-900 rounded-2xl w-full max-w-md mx-4 shadow-2xl border border-gray-200 dark:border-gray-700">
        <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100 dark:border-gray-800">
            <h3 id="modalCatTitle" class="font-semibold text-gray-800 dark:text-white">Tambah Kategori</h3>
            <button onclick="hideModal('modalCat')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="p-6 space-y-4">
            <div id="alertCat" class="hidden p-3 rounded-xl text-sm bg-red-50 text-red-600 border border-red-100"></div>
            <input type="hidden" id="catId">
            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">Nama Kategori <span class="text-red-500">*</span></label>
                <input id="catName" type="text" placeholder="Contoh: Alat Tulis Kantor"
                    class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 dark:text-white">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">Deskripsi</label>
                <textarea id="catDesc" rows="2" placeholder="Opsional"
                    class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 dark:text-white resize-none"></textarea>
            </div>
        </div>
        <div class="px-6 pb-6 flex gap-3">
            <button onclick="saveCat()" class="flex-1 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-medium">Simpan</button>
            <button onclick="hideModal('modalCat')" class="flex-1 py-2.5 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 rounded-xl text-sm">Batal</button>
        </div>
    </div>
</div>

<!-- Modal Item -->
<div id="modalItem" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60" style="display:none!important">
    <div class="bg-white dark:bg-gray-900 rounded-2xl w-full max-w-lg mx-4 shadow-2xl border border-gray-200 dark:border-gray-700">
        <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100 dark:border-gray-800">
            <h3 id="modalItemTitle" class="font-semibold text-gray-800 dark:text-white">Tambah Item</h3>
            <button onclick="hideModal('modalItem')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="p-6 space-y-4">
            <div id="alertItem" class="hidden p-3 rounded-xl text-sm bg-red-50 text-red-600 border border-red-100"></div>
            <input type="hidden" id="itemId">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">Kode Item <span class="text-red-500">*</span></label>
                    <input id="itemCode" type="text" placeholder="ITM-001"
                        class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 dark:text-white">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">Satuan <span class="text-red-500">*</span></label>
                    <input id="itemUnit" type="text" placeholder="pcs / kg / m"
                        class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 dark:text-white">
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">Nama Item <span class="text-red-500">*</span></label>
                <input id="itemName" type="text" placeholder="Nama item"
                    class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 dark:text-white">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                <select id="itemCatSel"
                    class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 dark:text-white">
                    <option value="">-- Pilih Kategori --</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">Deskripsi</label>
                <textarea id="itemDesc" rows="2" placeholder="Opsional"
                    class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 dark:text-white resize-none"></textarea>
            </div>
        </div>
        <div class="px-6 pb-6 flex gap-3">
            <button onclick="saveItem()" class="flex-1 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-medium">Simpan</button>
            <button onclick="hideModal('modalItem')" class="flex-1 py-2.5 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 rounded-xl text-sm">Batal</button>
        </div>
    </div>
</div>

<!-- Modal Template Excel -->
<div id="modalTpl" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60" style="display:none!important">
    <div class="bg-white dark:bg-gray-900 rounded-2xl w-full max-w-md mx-4 shadow-2xl border border-gray-200 dark:border-gray-700">
        <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100 dark:border-gray-800">
            <h3 id="modalTplTitle" class="font-semibold text-gray-800 dark:text-white">Upload Template Excel</h3>
            <button onclick="hideModal('modalTpl')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="p-6 space-y-4">
            <div id="alertTpl" class="hidden p-3 rounded-xl text-sm bg-red-50 text-red-600 border border-red-100"></div>
            <input type="hidden" id="tplId">
            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">Judul Template <span class="text-red-500">*</span></label>
                <input id="tplTitle" type="text" placeholder="Contoh: Template RFQ ATK 2025"
                    class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 dark:text-white">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">Deskripsi</label>
                <textarea id="tplDesc" rows="2" placeholder="Deskripsi template (opsional)"
                    class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 dark:text-white resize-none"></textarea>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">File Excel <span id="tplFileRequired" class="text-red-500">*</span></label>
                <input id="tplFile" type="file" accept=".xlsx,.xls,.csv"
                    class="w-full text-sm text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-blue-600 file:text-white">
                <p id="tplCurrentFile" class="text-xs text-gray-400 mt-1 hidden"></p>
            </div>
            <div class="flex items-center gap-3">
                <input id="tplActive" type="checkbox" checked class="rounded">
                <label class="text-sm text-gray-600 dark:text-gray-400">Aktif (tampil ke supplier)</label>
            </div>
        </div>
        <div class="px-6 pb-6 flex gap-3">
            <button onclick="saveTpl()" class="flex-1 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-medium">Simpan</button>
            <button onclick="hideModal('modalTpl')" class="flex-1 py-2.5 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 rounded-xl text-sm">Batal</button>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="modalDel" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60" style="display:none!important">
    <div class="bg-white dark:bg-gray-900 rounded-2xl w-full max-w-sm mx-4 p-6 text-center shadow-2xl border border-gray-200 dark:border-gray-700">
        <div class="w-14 h-14 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        </div>
        <h3 class="font-bold text-gray-800 dark:text-white mb-2">Hapus Data?</h3>
        <p class="text-sm text-gray-500 mb-5">Tindakan ini tidak dapat dibatalkan.</p>
        <div class="flex gap-3">
            <button onclick="confirmDel()" class="flex-1 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm font-medium">Hapus</button>
            <button onclick="hideModal('modalDel')" class="flex-1 py-2.5 border border-gray-200 dark:border-gray-700 text-gray-600 rounded-xl text-sm">Batal</button>
        </div>
    </div>
</div>

<script>
let allCats = [], allItems = [], allTpls = [];
let delId = null, delType = null, activeTab = 'cat';

// ─── Tab ──────────────────────────────────────────────────────────────
function switchTab(tab) {
    activeTab = tab;
    ['cat','item','tpl'].forEach(t => {
        document.getElementById('pane' + t.charAt(0).toUpperCase() + t.slice(1)).style.display = t === tab ? '' : 'none';
    });
    const a = 'px-4 py-2 rounded-lg text-sm font-medium transition-all bg-white dark:bg-gray-700 text-gray-800 dark:text-white shadow-sm';
    const i = 'px-4 py-2 rounded-lg text-sm font-medium transition-all text-gray-500 hover:text-gray-700 dark:text-gray-400';
    document.getElementById('tabCat').className  = tab === 'cat'  ? a : i;
    document.getElementById('tabItem').className = tab === 'item' ? a : i;
    document.getElementById('tabTpl').className  = tab === 'tpl'  ? a : i;
    document.getElementById('catItemFilter').style.display = tab === 'item' ? '' : 'none';
    const labels = { cat: 'Tambah Kategori', item: 'Tambah Item', tpl: 'Upload Template' };
    document.getElementById('btnAddLabel').textContent = labels[tab];
    document.getElementById('searchInput').value = '';
}

function openAdd() {
    if (activeTab === 'cat') openAddCat();
    else if (activeTab === 'item') openAddItem();
    else openAddTpl();
}

// ─── Modal helpers ────────────────────────────────────────────────────
function showModal(id) { const el = document.getElementById(id); el.style.removeProperty('display'); el.style.display = 'flex'; }
function hideModal(id) { document.getElementById(id).style.display = 'none'; }

// ─── KATEGORI ─────────────────────────────────────────────────────────
function openAddCat() {
    document.getElementById('catId').value = '';
    document.getElementById('catName').value = '';
    document.getElementById('catDesc').value = '';
    document.getElementById('modalCatTitle').textContent = 'Tambah Kategori';
    document.getElementById('alertCat').classList.add('hidden');
    showModal('modalCat');
}
function openEditCat(id) {
    const c = allCats.find(x => x.id_master_category == id); if (!c) return;
    document.getElementById('catId').value = id;
    document.getElementById('catName').value = c.name;
    document.getElementById('catDesc').value = c.description || '';
    document.getElementById('modalCatTitle').textContent = 'Edit Kategori';
    document.getElementById('alertCat').classList.add('hidden');
    showModal('modalCat');
}
async function saveCat() {
    const id = document.getElementById('catId').value;
    const name = document.getElementById('catName').value.trim();
    const desc = document.getElementById('catDesc').value.trim();
    if (!name) { setAlert('alertCat', 'Nama wajib diisi.'); return; }
    const url = id ? `/api/admin/master-categories/${id}` : '/api/admin/master-categories';
    try {
        const res = await fetch(url, { method: id ? 'PUT' : 'POST', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF() }, body: JSON.stringify({ name, description: desc }) });
        const json = await res.json();
        if (!res.ok) { setAlert('alertCat', json.message || errMsg(json.errors)); return; }
        hideModal('modalCat'); toast(id ? 'Kategori diperbarui' : 'Kategori ditambahkan'); await loadCats();
    } catch(e) { setAlert('alertCat', 'Terjadi kesalahan.'); }
}
async function loadCats() {
    const res = await fetch('/api/admin/master-categories', { headers: { 'Accept': 'application/json' } });
    const json = await res.json();
    allCats = json.categories || [];
    renderCats(allCats); populateCatSelects();
}
function renderCats(list) {
    const tb = document.getElementById('catBody');
    if (!list.length) { tb.innerHTML = '<tr><td colspan="5" class="px-5 py-6 text-center text-sm text-gray-400">Belum ada kategori.</td></tr>'; return; }
    tb.innerHTML = list.map((c, i) => `<tr class="border-t border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800/30">
        <td class="px-5 py-3.5 text-xs text-gray-400">${i+1}</td>
        <td class="px-5 py-3.5 font-medium text-gray-800 dark:text-white">${c.name}</td>
        <td class="px-5 py-3.5 text-sm text-gray-500">${c.description || '—'}</td>
        <td class="px-5 py-3.5"><span class="px-2.5 py-1 bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 rounded-full text-xs">${c.items_count ?? 0} item</span></td>
        <td class="px-5 py-3.5 text-right">${actionBtns(c.id_master_category, 'cat')}</td>
    </tr>`).join('');
}

// ─── ITEM ─────────────────────────────────────────────────────────────
function openAddItem() {
    document.getElementById('itemId').value = '';
    ['itemCode','itemName','itemUnit','itemDesc'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('itemCatSel').value = '';
    document.getElementById('modalItemTitle').textContent = 'Tambah Item';
    document.getElementById('alertItem').classList.add('hidden');
    showModal('modalItem');
}
function openEditItem(id) {
    const item = allItems.find(x => x.id_item == id); if (!item) return;
    document.getElementById('itemId').value = id;
    document.getElementById('itemCode').value = item.item_code;
    document.getElementById('itemName').value = item.item_name;
    document.getElementById('itemUnit').value = item.unit;
    document.getElementById('itemDesc').value = item.description || '';
    document.getElementById('itemCatSel').value = item.id_category;
    document.getElementById('modalItemTitle').textContent = 'Edit Item';
    document.getElementById('alertItem').classList.add('hidden');
    showModal('modalItem');
}
async function saveItem() {
    const id = document.getElementById('itemId').value;
    const body = { item_code: document.getElementById('itemCode').value.trim(), item_name: document.getElementById('itemName').value.trim(), unit: document.getElementById('itemUnit').value.trim(), id_category: document.getElementById('itemCatSel').value, description: document.getElementById('itemDesc').value.trim() };
    if (!body.item_code || !body.item_name || !body.unit || !body.id_category) { setAlert('alertItem', 'Semua field wajib diisi.'); return; }
    const url = id ? `/api/admin/master-items/${id}` : '/api/admin/master-items';
    try {
        const res = await fetch(url, { method: id ? 'PUT' : 'POST', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF() }, body: JSON.stringify(body) });
        const json = await res.json();
        if (!res.ok) { setAlert('alertItem', json.message || errMsg(json.errors)); return; }
        hideModal('modalItem'); toast(id ? 'Item diperbarui' : 'Item ditambahkan'); await loadItems();
    } catch(e) { setAlert('alertItem', 'Terjadi kesalahan.'); }
}
async function loadItems() {
    const res = await fetch('/api/admin/master-items', { headers: { 'Accept': 'application/json' } });
    const json = await res.json();
    allItems = json.items || [];
    renderItems(allItems);
}
function renderItems(list) {
    const tb = document.getElementById('itemBody');
    if (!list.length) { tb.innerHTML = '<tr><td colspan="6" class="px-5 py-6 text-center text-sm text-gray-400">Belum ada item.</td></tr>'; return; }
    tb.innerHTML = list.map((item, i) => `<tr class="border-t border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800/30">
        <td class="px-5 py-3.5 text-xs text-gray-400">${i+1}</td>
        <td class="px-5 py-3.5"><span class="px-2 py-0.5 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 rounded text-xs font-mono">${item.item_code}</span></td>
        <td class="px-5 py-3.5 font-medium text-gray-800 dark:text-white">${item.item_name}</td>
        <td class="px-5 py-3.5"><span class="px-2.5 py-1 bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 rounded-full text-xs">${item.category?.name || '—'}</span></td>
        <td class="px-5 py-3.5 text-sm text-gray-500">${item.unit}</td>
        <td class="px-5 py-3.5 text-right">${actionBtns(item.id_item, 'item')}</td>
    </tr>`).join('');
}
function populateCatSelects() {
    const opts = '<option value="">-- Pilih Kategori --</option>' + allCats.map(c => `<option value="${c.id_master_category}">${c.name}</option>`).join('');
    document.getElementById('itemCatSel').innerHTML = opts;
    document.getElementById('catItemFilter').innerHTML = '<option value="">Semua Kategori</option>' + allCats.map(c => `<option value="${c.id_master_category}">${c.name}</option>`).join('');
}
function filterItems() {
    const catId = document.getElementById('catItemFilter').value;
    const q = document.getElementById('searchInput').value.toLowerCase();
    renderItems(allItems.filter(item => (!catId || String(item.id_category) === catId) && (!q || item.item_name.toLowerCase().includes(q) || item.item_code.toLowerCase().includes(q))));
}

// ─── TEMPLATE EXCEL ───────────────────────────────────────────────────
function openAddTpl() {
    document.getElementById('tplId').value = '';
    document.getElementById('tplTitle').value = '';
    document.getElementById('tplDesc').value = '';
    document.getElementById('tplFile').value = '';
    document.getElementById('tplActive').checked = true;
    document.getElementById('modalTplTitle').textContent = 'Upload Template Excel';
    document.getElementById('tplFileRequired').textContent = '*';
    document.getElementById('tplCurrentFile').classList.add('hidden');
    document.getElementById('alertTpl').classList.add('hidden');
    showModal('modalTpl');
}
function openEditTpl(id) {
    const t = allTpls.find(x => x.id == id); if (!t) return;
    document.getElementById('tplId').value = id;
    document.getElementById('tplTitle').value = t.title;
    document.getElementById('tplDesc').value = t.description || '';
    document.getElementById('tplFile').value = '';
    document.getElementById('tplActive').checked = t.is_active;
    document.getElementById('modalTplTitle').textContent = 'Edit Template';
    document.getElementById('tplFileRequired').textContent = '(opsional - kosongkan jika tidak ganti file)';
    document.getElementById('tplCurrentFile').textContent = 'File saat ini: ' + t.file_name;
    document.getElementById('tplCurrentFile').classList.remove('hidden');
    document.getElementById('alertTpl').classList.add('hidden');
    showModal('modalTpl');
}
async function saveTpl() {
    const id    = document.getElementById('tplId').value;
    const title = document.getElementById('tplTitle').value.trim();
    const desc  = document.getElementById('tplDesc').value.trim();
    const file  = document.getElementById('tplFile').files[0];
    const active= document.getElementById('tplActive').checked;

    if (!title) { setAlert('alertTpl', 'Judul wajib diisi.'); return; }
    if (!id && !file) { setAlert('alertTpl', 'File Excel wajib diupload.'); return; }

    const fd = new FormData();
    fd.append('title', title);
    fd.append('description', desc);
    fd.append('is_active', active ? '1' : '0');
    if (file) fd.append('file', file);
    if (id) fd.append('_method', 'POST'); // Override untuk edit

    const url = id ? `/api/admin/rfq-templates/${id}` : '/api/admin/rfq-templates';
    try {
        const res = await fetch(url, { method: 'POST', headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF() }, body: fd });
        const json = await res.json();
        if (!res.ok) { setAlert('alertTpl', json.message || errMsg(json.errors)); return; }
        hideModal('modalTpl'); toast(id ? 'Template diperbarui' : 'Template diupload'); await loadTpls();
    } catch(e) { setAlert('alertTpl', 'Terjadi kesalahan.'); }
}
async function loadTpls() {
    const res = await fetch('/api/admin/rfq-templates', { headers: { 'Accept': 'application/json' } });
    const json = await res.json();
    allTpls = json.templates || [];
    renderTpls(allTpls);
}
function renderTpls(list) {
    const tb = document.getElementById('tplBody');
    if (!list.length) { tb.innerHTML = '<tr><td colspan="6" class="px-5 py-6 text-center text-sm text-gray-400">Belum ada template.</td></tr>'; return; }
    tb.innerHTML = list.map((t, i) => `<tr class="border-t border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800/30">
        <td class="px-5 py-3.5 text-xs text-gray-400">${i+1}</td>
        <td class="px-5 py-3.5">
            <p class="font-medium text-gray-800 dark:text-white text-sm">${t.title}</p>
            <p class="text-xs text-gray-400 mt-0.5">${t.description || ''}</p>
        </td>
        <td class="px-5 py-3.5">
            <a href="${t.file_url}" target="_blank" class="inline-flex items-center gap-1 text-blue-600 hover:underline text-xs">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17v3a2 2 0 002 2h14a2 2 0 002-2v-3"/></svg>
                ${t.file_name}
            </a>
        </td>
        <td class="px-5 py-3.5">
            <span class="px-2.5 py-1 rounded-full text-xs font-medium ${t.is_active ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-500'}">
                ${t.is_active ? 'Aktif' : 'Nonaktif'}
            </span>
        </td>
        <td class="px-5 py-3.5 text-xs text-gray-400">${t.created_at ? new Date(t.created_at).toLocaleDateString('id-ID') : '—'} · ${t.uploaded_by || '—'}</td>
        <td class="px-5 py-3.5 text-right">${actionBtns(t.id, 'tpl')}</td>
    </tr>`).join('');
}

// ─── DELETE ───────────────────────────────────────────────────────────
function askDel(id, type) { delId = id; delType = type; showModal('modalDel'); }
async function confirmDel() {
    const urlMap = { cat: `/api/admin/master-categories/${delId}`, item: `/api/admin/master-items/${delId}`, tpl: `/api/admin/rfq-templates/${delId}` };
    const res = await fetch(urlMap[delType], { method: 'DELETE', headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF() } });
    hideModal('modalDel');
    if (res.ok) {
        toast('Data berhasil dihapus');
        if (delType === 'cat') await loadCats(); else if (delType === 'item') await loadItems(); else await loadTpls();
    } else { toast('Gagal menghapus', 'error'); }
}

// ─── Search ───────────────────────────────────────────────────────────
function doSearch() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    if (activeTab === 'cat') renderCats(allCats.filter(c => c.name.toLowerCase().includes(q) || (c.description||'').toLowerCase().includes(q)));
    else if (activeTab === 'item') filterItems();
    else renderTpls(allTpls.filter(t => t.title.toLowerCase().includes(q) || t.file_name.toLowerCase().includes(q)));
}

// ─── Helpers ──────────────────────────────────────────────────────────
function actionBtns(id, type) {
    const editFn = type === 'cat' ? `openEditCat(${id})` : type === 'item' ? `openEditItem(${id})` : `openEditTpl(${id})`;
    return `<div class="flex items-center justify-end gap-2">
        <button onclick="${editFn}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-amber-50 hover:bg-amber-100 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 rounded-lg text-xs font-medium transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>Edit
        </button>
        <button onclick="askDel(${id},'${type}')" class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 hover:bg-red-100 dark:bg-red-900/20 text-red-600 dark:text-red-400 rounded-lg text-xs font-medium transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>Hapus
        </button>
    </div>`;
}
function setAlert(id, msg) { const el = document.getElementById(id); el.textContent = msg; el.classList.remove('hidden'); }
function errMsg(e) { return e ? Object.values(e).flat().join(' ') : 'Kesalahan.'; }
function toast(msg, type = 'success') {
    const t = document.createElement('div');
    t.className = `fixed bottom-5 right-5 px-5 py-3 rounded-xl text-white text-sm z-[9999] shadow-lg ${type === 'success' ? 'bg-green-600' : 'bg-red-600'}`;
    t.textContent = msg; document.body.appendChild(t); setTimeout(() => t.remove(), 3000);
}

// ─── Init ─────────────────────────────────────────────────────────────
loadCats(); loadItems(); loadTpls();
</script>
@endsection