<div id="{{ $id }}"
    class="pagination-root flex items-center justify-between px-5 py-3.5 border-t border-gray-100 dark:border-gray-800">
    <div class="flex items-center gap-2">
        <span class="text-xs text-gray-500 dark:text-gray-400">Baris per halaman:</span>
        <select
            class="pagination-perpage text-xs bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg px-2 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700 dark:text-gray-300">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
    </div>

    <div class="flex items-center gap-3">
        <span class="pagination-info text-xs text-gray-500 dark:text-gray-400"></span>

        <div class="flex items-center gap-1">
            <!-- First -->
            <button
                class="pagination-first w-7 h-7 flex items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 disabled:opacity-30 disabled:cursor-not-allowed transition-colors"
                title="Halaman pertama">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 19l-7-7 7-7M18 19l-7-7 7-7" />
                </svg>
            </button>
            <!-- Prev -->
            <button
                class="pagination-prev w-7 h-7 flex items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 disabled:opacity-30 disabled:cursor-not-allowed transition-colors"
                title="Sebelumnya">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <!-- Page numbers -->
            <div class="pagination-pages flex items-center gap-1"></div>

            <!-- Next -->
            <button
                class="pagination-next w-7 h-7 flex items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 disabled:opacity-30 disabled:cursor-not-allowed transition-colors"
                title="Berikutnya">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            <!-- Last -->
            <button
                class="pagination-last w-7 h-7 flex items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 disabled:opacity-30 disabled:cursor-not-allowed transition-colors"
                title="Halaman terakhir">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 5l7 7-7 7M6 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </div>
</div>

@once
    @push('scripts')
        <script>
            window.Pagination = (() => {
                const _instances = {};

                function _getRoot(id) {
                    return document.getElementById(id);
                }

                function _render(id) {
                    const inst = _instances[id];
                    if (!inst) return;

                    const root = _getRoot(id);
                    const {
                        total,
                        perPage,
                        currentPage,
                        callback
                    } = inst;
                    const totalPages = Math.max(1, Math.ceil(total / perPage));

                    // Clamp currentPage
                    if (inst.currentPage > totalPages) inst.currentPage = totalPages;
                    const page = inst.currentPage;

                    // Info text
                    const from = total === 0 ? 0 : (page - 1) * perPage + 1;
                    const to = Math.min(page * perPage, total);
                    root.querySelector('.pagination-info').textContent =
                        total === 0 ? 'Tidak ada data' : `${from}–${to} dari ${total}`;

                    // Per-page select: reflect current value
                    const select = root.querySelector('.pagination-perpage');
                    select.value = String(perPage);

                    // Buttons enable/disable
                    root.querySelector('.pagination-first').disabled = page <= 1;
                    root.querySelector('.pagination-prev').disabled = page <= 1;
                    root.querySelector('.pagination-next').disabled = page >= totalPages;
                    root.querySelector('.pagination-last').disabled = page >= totalPages;

                    // Page numbers show max 5 pages around current
                    const pagesEl = root.querySelector('.pagination-pages');
                    pagesEl.innerHTML = '';

                    const range = _pageRange(page, totalPages, 5);
                    range.forEach(p => {
                        if (p === '...') {
                            const el = document.createElement('span');
                            el.className = 'w-7 h-7 flex items-center justify-center text-xs text-gray-400';
                            el.textContent = '···';
                            pagesEl.appendChild(el);
                        } else {
                            const btn = document.createElement('button');
                            btn.textContent = p;
                            btn.className = p === page ?
                                'w-7 h-7 flex items-center justify-center rounded-lg text-xs font-semibold bg-blue-600 text-white' :
                                'w-7 h-7 flex items-center justify-center rounded-lg text-xs text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors';
                            btn.addEventListener('click', () => _goTo(id, p));
                            pagesEl.appendChild(btn);
                        }
                    });
                }

                function _pageRange(current, total, maxVisible) {
                    if (total <= maxVisible) {
                        return Array.from({
                            length: total
                        }, (_, i) => i + 1);
                    }
                    const half = Math.floor(maxVisible / 2);
                    let start = Math.max(1, current - half);
                    let end = Math.min(total, start + maxVisible - 1);
                    if (end - start < maxVisible - 1) start = Math.max(1, end - maxVisible + 1);

                    const pages = [];
                    if (start > 1) {
                        pages.push(1);
                        if (start > 2) pages.push('...');
                    }
                    for (let i = start; i <= end; i++) pages.push(i);
                    if (end < total) {
                        if (end < total - 1) pages.push('...');
                        pages.push(total);
                    }
                    return pages;
                }

                function _goTo(id, page) {
                    const inst = _instances[id];
                    if (!inst) return;
                    const totalPages = Math.max(1, Math.ceil(inst.total / inst.perPage));
                    inst.currentPage = Math.min(Math.max(1, page), totalPages);
                    _render(id);
                    inst.callback(inst.currentPage, inst.perPage);
                }

                function _bindEvents(id) {
                    const root = _getRoot(id);
                    if (!root || root._paginationBound) return;
                    root._paginationBound = true;

                    root.querySelector('.pagination-first').addEventListener('click', () => _goTo(id, 1));
                    root.querySelector('.pagination-prev').addEventListener('click', () => _goTo(id, _instances[id]
                        .currentPage - 1));
                    root.querySelector('.pagination-next').addEventListener('click', () => _goTo(id, _instances[id]
                        .currentPage + 1));
                    root.querySelector('.pagination-last').addEventListener('click', () => {
                        const inst = _instances[id];
                        _goTo(id, Math.ceil(inst.total / inst.perPage));
                    });
                    root.querySelector('.pagination-perpage').addEventListener('change', e => {
                        _instances[id].perPage = Number(e.target.value);
                        _instances[id].currentPage = 1;
                        _render(id);
                        const inst = _instances[id];
                        inst.callback(inst.currentPage, inst.perPage);
                    });
                }

                return {
                    init(id, total, perPage = 10, callback = () => {}) {
                        _instances[id] = {
                            total,
                            perPage,
                            currentPage: 1,
                            callback
                        };
                        _bindEvents(id);
                        _render(id);
                    },

                    update(id, newTotal, newPerPage = null) {
                        const inst = _instances[id];
                        if (!inst) return;
                        inst.total = newTotal;
                        if (newPerPage !== null) inst.perPage = newPerPage;
                        // Reset ke halaman 1 jika halaman saat ini melebihi total halaman baru
                        const totalPages = Math.max(1, Math.ceil(inst.total / inst.perPage));
                        if (inst.currentPage > totalPages) inst.currentPage = 1;
                        _render(id);
                    },

                    currentPage(id) {
                        return _instances[id]?.currentPage ?? 1;
                    },
                    currentPerPage(id) {
                        return _instances[id]?.perPage ?? 10;
                    },
                };
            })();
        </script>
    @endpush
@endonce
