<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - RFQ System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Set dark mode sebelum render agar tidak flash --}}
    <script>
        (function() {
            if (localStorage.getItem('rfq_theme') === 'dark') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        /*
         * Sidebar label transition — tidak bisa murni Tailwind karena
         * butuh max-width transition. Ini satu-satunya custom CSS yang diperlukan.
         */
        .sb-label {
            white-space: nowrap;
            overflow: hidden;
            transition: opacity 0.25s ease, max-width 0.25s ease;
        }

        .sb-expanded .sb-label {
            opacity: 1;
            max-width: 200px;
        }

        .sb-collapsed .sb-label {
            opacity: 0;
            max-width: 0;
        }
    </style>
</head>

<body class="bg-gray-50 dark:bg-gray-950 antialiased">

    <div class="flex min-h-screen">

        {{-- ── Mobile Backdrop ─────────────────────────────── --}}
        <div id="mob-backdrop" onclick="Sb.closeMobile()"
            class="fixed inset-0 z-40 hidden bg-black/60 backdrop-blur-sm xl:hidden"></div>

        <aside id="main-sidebar"
            class="
                sb-expanded
                flex-shrink-0 flex flex-col
                bg-white dark:bg-gray-900
                border-r border-gray-200 dark:border-gray-800
                px-3 overflow-hidden
                transition-all duration-300 ease-in-out

                {{-- Desktop --}}
                hidden xl:flex
                w-[280px]

                {{-- Mobile --}}
            ">
            {{-- Logo --}}
            <div class="flex h-16 flex-shrink-0 items-center gap-3 px-1">
                <a href="/admin/dashboard" class="flex items-center gap-3">
                    <div
                        class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl
                                bg-brand-500 shadow-lg shadow-brand-500/20">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2
                                     M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div class="sb-label leading-tight">
                        <p class="text-xl font-extrabold text-gray-900 dark:text-white">
                            RFQ<span class="text-brand-500">System</span>
                        </p>
                        <p class="text-[10px] text-gray-400">E-Procurement Platform</p>
                    </div>
                </a>
            </div>

            {{-- Navigation --}}
            <nav class="flex flex-1 flex-col gap-0.5 overflow-y-auto overflow-x-hidden py-3">
                @php
                    $seg = request()->segment(2) ?? '';
                    $active = 'flex items-center gap-3 rounded-xl bg-brand-50 px-3 py-2.5 text-sm
                                font-semibold text-brand-700 dark:bg-brand-900/20 dark:text-brand-400';
                    $normal = 'flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium
                                text-gray-600 transition-colors hover:bg-gray-100 hover:text-gray-900
                                dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white';
                    $ni = fn(bool $on) => $on ? $active : $normal;
                @endphp

                {{-- Dashboard --}}
                <a href="/admin/dashboard" class="{{ $ni($seg === 'dashboard') }}" title="Dashboard">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <rect x="3" y="3" width="7" height="7" rx="1.5" stroke-width="2" />
                        <rect x="14" y="3" width="7" height="7" rx="1.5" stroke-width="2" />
                        <rect x="3" y="14" width="7" height="7" rx="1.5" stroke-width="2" />
                        <rect x="14" y="14" width="7" height="7" rx="1.5" stroke-width="2" />
                    </svg>
                    <span class="sb-label">Dashboard</span>
                </a>

                {{-- ── Master Data (menggantikan Master Kategori & Master Item) ── --}}
                <p class="sb-label mt-5 mb-1 px-3 text-[10px] font-bold uppercase tracking-widest text-gray-400">
                    Master Data
                </p>

                <a href="/admin/master-data" class="{{ $ni($seg === 'master-data') }}" title="Master Data">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 1.1.9 2 2 2h12a2 2 0 002-2V7M4 7h16M4 7l2-4h12l2 4
                               M10 11h4M10 15h4" />
                    </svg>
                    <span class="sb-label">Master Data</span>
                </a>

                {{-- Pengadaan --}}
                <p class="sb-label mt-5 mb-1 px-3 text-[10px] font-bold uppercase tracking-widest text-gray-400">
                    Pengadaan
                </p>

                <a href="/admin/suppliers" class="{{ $ni($seg === 'suppliers') }}" title="Supplier">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857
                                 M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857
                                 m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="sb-label">Supplier</span>
                </a>

                <a href="/admin/batches" class="{{ $ni($seg === 'batches') }}" title="Batch / RFQ">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2
                                 M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2
                                 m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    <span class="sb-label">Batch / RFQ</span>
                </a>

                <a href="/admin/quotations" class="{{ $ni($seg === 'quotations') }}" title="Quotation">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="sb-label">Quotation</span>
                </a>

                <a href="/admin/reports" class="{{ $ni($seg === 'reports') }}" title="Laporan">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9
                                 a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5
                                 a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <span class="sb-label">Laporan</span>
                </a>

                {{-- Logout --}}
                <div class="mt-auto border-t border-gray-100 dark:border-gray-800 pt-3">
                    <button onclick="doLogout()" title="Logout"
                        class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium
                               text-red-500 transition-colors hover:bg-red-50 dark:hover:bg-red-900/20">
                        <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7
                                     a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="sb-label">Logout</span>
                    </button>
                </div>
            </nav>
        </aside>

        {{-- ══════════════════════════════════════════════════
             PAGE AREA — mengisi sisa ruang (flex:1)
        ══════════════════════════════════════════════════ --}}
        <div id="page-area" class="flex flex-1 flex-col min-w-0">

            {{-- TOPBAR --}}
            <header
                class="sticky top-0 z-30 flex h-16 w-full items-center justify-between
                           border-b border-gray-200 dark:border-gray-800
                           bg-white dark:bg-gray-900 px-4 xl:px-6">

                <div class="flex items-center gap-3">
                    {{-- Desktop toggle --}}
                    <button onclick="Sb.toggleDesktop()" title="Toggle Sidebar"
                        class="hidden xl:flex h-9 w-9 items-center justify-center rounded-lg
                               border border-gray-200 dark:border-gray-700
                               text-gray-500 dark:text-gray-400
                               hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <svg width="16" height="12" viewBox="0 0 16 12" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0 1a1 1 0 011-1h14a1 1 0 110 2H1a1 1 0 01-1-1zm0 5a1 1 0 011-1h8
                                     a1 1 0 110 2H1a1 1 0 01-1-1zm1 4a1 1 0 000 2h14a1 1 0 000-2H1z"
                                fill="currentColor" />
                        </svg>
                    </button>

                    {{-- Mobile hamburger --}}
                    <button onclick="Sb.toggleMobile()" title="Menu"
                        class="flex xl:hidden h-9 w-9 items-center justify-center rounded-lg
                               border border-gray-200 dark:border-gray-700
                               text-gray-500 dark:text-gray-400
                               hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <h1 class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                        @yield('page-title', 'Dashboard')
                    </h1>
                </div>

                <div class="flex items-center gap-2">
                    {{-- Theme Toggle --}}
                    <button onclick="ThemeStore.toggle()" id="theme-btn" title="Toggle Theme"
                        class="flex h-9 w-9 items-center justify-center rounded-lg
                               border border-gray-200 dark:border-gray-700
                               text-gray-500 dark:text-gray-400
                               hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        {{-- Moon (tampil di light mode) --}}
                        <svg id="icon-moon" class="h-[18px] w-[18px]" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        {{-- Sun (tampil di dark mode) --}}
                        <svg id="icon-sun" class="h-[18px] w-[18px] text-yellow-300 hidden" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707
                                     m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </button>

                    {{-- User Dropdown --}}
                    <div class="relative" id="dd-wrap">
                        <button onclick="DD.toggle(event)"
                            class="flex items-center gap-2 rounded-xl px-2 py-1.5
                                   hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                            <div id="user-avatar"
                                class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full
                                        bg-brand-500 text-sm font-bold text-white select-none">
                                A</div>
                            <div class="hidden sm:block text-left">
                                <p id="header-uname"
                                    class="text-sm font-semibold leading-tight text-gray-800 dark:text-white">Admin</p>
                                <p class="text-xs text-gray-400">Administrator</p>
                            </div>
                            <svg id="dd-chevron" class="h-4 w-4 text-gray-400 transition-transform duration-200"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div id="dd-panel"
                            class="absolute right-0 top-full mt-2 hidden w-52 overflow-hidden
                                    rounded-2xl border border-gray-100 dark:border-gray-700
                                    bg-white dark:bg-gray-800 shadow-xl z-50">
                            <div class="border-b border-gray-100 dark:border-gray-700 px-4 py-3">
                                <p id="dd-name" class="text-sm font-semibold text-gray-900 dark:text-white">Admin
                                </p>
                                <p class="text-xs text-gray-400">Administrator</p>
                            </div>
                            <div class="p-1.5">
                                <button onclick="doLogout()"
                                    class="flex w-full items-center gap-2.5 rounded-xl px-3 py-2.5 text-sm
                                           text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7
                                                 a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Logout
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {{-- CONTENT --}}
            <main class="flex-1 p-4 md:p-6">
                <div class="mx-auto max-w-screen-2xl">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    {{-- Mobile sidebar overlay (fixed, di luar flex row) --}}
    <div id="mob-sidebar"
        class="fixed inset-y-0 left-0 z-50 hidden w-[280px] flex-col
                bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800
                px-3 overflow-hidden xl:hidden">
        {{-- Logo --}}
        <div class="flex h-16 flex-shrink-0 items-center gap-3 px-1">
            <a href="/admin/dashboard" class="flex items-center gap-3">
                <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl bg-brand-500">
                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2
                                 M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div class="leading-tight">
                    <p class="text-xl font-extrabold text-gray-900 dark:text-white">RFQ<span
                            class="text-brand-500">System</span></p>
                    <p class="text-[10px] text-gray-400">E-Procurement Platform</p>
                </div>
            </a>
        </div>
        {{-- Nav mobile (sama dengan desktop) --}}
        <nav class="flex flex-1 flex-col gap-0.5 overflow-y-auto py-3">
            @php $seg2 = request()->segment(2) ?? ''; @endphp

            <a href="/admin/dashboard" onclick="Sb.closeMobile()" class="{{ $ni($seg2 === 'dashboard') }}">
                <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <rect x="3" y="3" width="7" height="7" rx="1.5" stroke-width="2" />
                    <rect x="14" y="3" width="7" height="7" rx="1.5" stroke-width="2" />
                    <rect x="3" y="14" width="7" height="7" rx="1.5" stroke-width="2" />
                    <rect x="14" y="14" width="7" height="7" rx="1.5" stroke-width="2" />
                </svg>
                <span>Dashboard</span>
            </a>

            <p class="mt-5 mb-1 px-3 text-[10px] font-bold uppercase tracking-widest text-gray-400">Master Data</p>

            <a href="/admin/master-data" onclick="Sb.closeMobile()" class="{{ $ni($seg2 === 'master-data') }}">
                <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 1.1.9 2 2 2h12a2 2 0 002-2V7M4 7h16M4 7l2-4h12l2 4
                           M10 11h4M10 15h4" />
                </svg>
                <span>Master Data</span>
            </a>

            <p class="mt-5 mb-1 px-3 text-[10px] font-bold uppercase tracking-widest text-gray-400">Pengadaan</p>

            <a href="/admin/suppliers" onclick="Sb.closeMobile()" class="{{ $ni($seg2 === 'suppliers') }}">
                <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Supplier</span>
            </a>

            <a href="/admin/batches" onclick="Sb.closeMobile()" class="{{ $ni($seg2 === 'batches') }}">
                <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                <span>Batch / RFQ</span>
            </a>

            <a href="/admin/quotations" onclick="Sb.closeMobile()" class="{{ $ni($seg2 === 'quotations') }}">
                <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Quotation</span>
            </a>

            <a href="/admin/reports" onclick="Sb.closeMobile()" class="{{ $ni($seg2 === 'reports') }}">
                <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <span>Laporan</span>
            </a>

            <div class="mt-auto border-t border-gray-100 dark:border-gray-800 pt-3">
                <button onclick="doLogout()"
                    class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium
                           text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Logout</span>
                </button>
            </div>
        </nav>
    </div>

    {{-- Toast --}}
    <div id="toast-wrap" class="pointer-events-none fixed bottom-6 right-6 z-[9999] flex flex-col gap-2"></div>

    {{-- Modal backdrop --}}
    <div id="modal-bg" onclick="closeAllModals()" class="fixed inset-0 z-[900] hidden bg-black/60 backdrop-blur-sm">
    </div>

    {{-- ══════════════════════════════════════════════════════════
         GLOBAL JAVASCRIPT
    ══════════════════════════════════════════════════════════ --}}
    <script>
        /* ─── CSRF & API ──────────────────────────────────────── */
        const CSRF = document.querySelector('meta[name="csrf-token"]').content;
        const API = {
            _h(json = true) {
                const h = {
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json'
                };
                if (json) h['Content-Type'] = 'application/json';
                return h;
            },
            get: (url, p = {}) => fetch('/api' + url + (Object.keys(p).length ? '?' + new URLSearchParams(p) : ''), {
                headers: API._h()
            }).then(r => r.json()),
            post: (url, d = {}) => fetch('/api' + url, {
                method: 'POST',
                headers: API._h(),
                body: JSON.stringify(d)
            }).then(r => r.json()),
            put: (url, d = {}) => fetch('/api' + url, {
                method: 'PUT',
                headers: API._h(),
                body: JSON.stringify(d)
            }).then(r => r.json()),
            del: (url) => fetch('/api' + url, {
                method: 'DELETE',
                headers: API._h()
            }).then(r => r.json()),
            upload: (url, fd, m = 'POST') => {
                if (m !== 'POST') fd.append('_method', m);
                return fetch('/api' + url, {
                    method: 'POST',
                    headers: API._h(false),
                    body: fd
                }).then(r => r.json());
            }
        };

        /* ─── SIDEBAR ─────────────────────────────────────────── */
        const Sb = {
            get isCollapsed() {
                return localStorage.getItem('sb_collapsed') === '1';
            },

            init() {
                const sb = document.getElementById('main-sidebar');
                if (!sb) return;
                if (this.isCollapsed) {
                    sb.classList.remove('w-[280px]', 'sb-expanded');
                    sb.classList.add('w-[72px]', 'sb-collapsed');
                } else {
                    sb.classList.remove('w-[72px]', 'sb-collapsed');
                    sb.classList.add('w-[280px]', 'sb-expanded');
                }
                this._syncThemeIcons();
            },

            toggleDesktop() {
                const sb = document.getElementById('main-sidebar');
                if (!sb) return;
                const nowCollapsed = sb.classList.contains('sb-collapsed');
                if (nowCollapsed) {
                    sb.classList.remove('w-[72px]', 'sb-collapsed');
                    sb.classList.add('w-[280px]', 'sb-expanded');
                    localStorage.setItem('sb_collapsed', '0');
                } else {
                    sb.classList.remove('w-[280px]', 'sb-expanded');
                    sb.classList.add('w-[72px]', 'sb-collapsed');
                    localStorage.setItem('sb_collapsed', '1');
                }
            },

            toggleMobile() {
                const mob = document.getElementById('mob-sidebar');
                const backdrop = document.getElementById('mob-backdrop');
                const isOpen = !mob.classList.contains('hidden');
                if (isOpen) {
                    mob.classList.add('hidden');
                    mob.classList.remove('flex');
                    backdrop.classList.add('hidden');
                    document.body.style.overflow = '';
                } else {
                    mob.classList.remove('hidden');
                    mob.classList.add('flex');
                    backdrop.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                }
            },

            closeMobile() {
                const mob = document.getElementById('mob-sidebar');
                const backdrop = document.getElementById('mob-backdrop');
                if (mob) {
                    mob.classList.add('hidden');
                    mob.classList.remove('flex');
                }
                if (backdrop) backdrop.classList.add('hidden');
                document.body.style.overflow = '';
            },

            _syncThemeIcons() {
                const isDark = document.documentElement.classList.contains('dark');
                document.getElementById('icon-moon')?.classList.toggle('hidden', isDark);
                document.getElementById('icon-sun')?.classList.toggle('hidden', !isDark);
            }
        };

        /* ─── THEME ───────────────────────────────────────────── */
        const ThemeStore = {
            toggle() {
                const isDark = document.documentElement.classList.toggle('dark');
                localStorage.setItem('rfq_theme', isDark ? 'dark' : 'light');
                Sb._syncThemeIcons();
            }
        };

        /* ─── USER DROPDOWN ───────────────────────────────────── */
        const DD = {
            open: false,
            toggle(e) {
                if (e) e.stopPropagation();
                this.open ? this.close() : this.show();
            },
            show() {
                this.open = true;
                document.getElementById('dd-panel').classList.remove('hidden');
                document.getElementById('dd-chevron').style.transform = 'rotate(180deg)';
            },
            close() {
                this.open = false;
                document.getElementById('dd-panel')?.classList.add('hidden');
                document.getElementById('dd-chevron').style.transform = 'rotate(0deg)';
            }
        };
        document.addEventListener('click', e => {
            if (DD.open && !document.getElementById('dd-wrap')?.contains(e.target)) DD.close();
        });
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                DD.close();
                Sb.closeMobile();
            }
        });

        /* ─── TOAST ───────────────────────────────────────────── */
        function showToast(msg, type = 'success') {
            const colors = {
                success: 'bg-green-500',
                error: 'bg-red-500',
                warning: 'bg-amber-500',
                info: 'bg-blue-500'
            };
            const icons = {
                success: '✓',
                error: '✕',
                warning: '⚠',
                info: 'ℹ'
            };
            const el = document.createElement('div');
            el.className = `pointer-events-auto flex items-center gap-3 rounded-2xl px-4 py-3 text-sm
                            text-white shadow-2xl min-w-[260px] ${colors[type] || colors.info}
                            translate-x-full opacity-0 transition-all duration-300`;
            el.innerHTML = `<span class="w-5 text-center font-bold text-base">${icons[type]||'ℹ'}</span>
                            <span class="flex-1 font-medium">${msg}</span>`;
            document.getElementById('toast-wrap').appendChild(el);
            requestAnimationFrame(() => requestAnimationFrame(() => {
                el.classList.remove('translate-x-full', 'opacity-0');
            }));
            setTimeout(() => {
                el.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => el.remove(), 350);
            }, 4500);
        }

        /* ─── MODAL ───────────────────────────────────────────── */
        function openModal(id) {
            document.getElementById('modal-bg').classList.remove('hidden');
            document.getElementById(id).classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            document.getElementById('modal-bg').classList.add('hidden');
            document.getElementById(id)?.classList.add('hidden');
            document.body.style.overflow = '';
        }

        function closeAllModals() {
            document.getElementById('modal-bg').classList.add('hidden');
            document.querySelectorAll('[id$="-modal"]').forEach(m => m.classList.add('hidden'));
            document.body.style.overflow = '';
        }

        /* ─── FORMATTERS ──────────────────────────────────────── */
        const fmtRp = n => 'Rp ' + Number(n || 0).toLocaleString('id-ID');
        const fmtDate = d => d ? new Date(d).toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        }) : '-';
        const fmtDT = d => d ? new Date(d).toLocaleString('id-ID') : '-';

        /* ─── BADGE ───────────────────────────────────────────── */
        const _bc = {
            draft: 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300',
            open: 'bg-green-100 text-green-700',
            closed: 'bg-blue-100 text-blue-700',
            invited: 'bg-cyan-100 text-cyan-700',
            viewed: 'bg-indigo-100 text-indigo-700',
            submitted: 'bg-blue-100 text-blue-700',
            approved: 'bg-emerald-100 text-emerald-700',
            rejected: 'bg-red-100 text-red-700',
            active: 'bg-green-100 text-green-700',
            inactive: 'bg-red-100 text-red-600',
            pending: 'bg-amber-100 text-amber-700',
            cancelled: 'bg-red-100 text-red-600',
            issued: 'bg-indigo-100 text-indigo-700',
            acknowledged: 'bg-teal-100 text-teal-700',
            completed: 'bg-green-100 text-green-700',
        };
        const _bl = {
            draft: 'Draft',
            open: 'Open',
            closed: 'Closed',
            invited: 'Diundang',
            viewed: 'Dilihat',
            submitted: 'Submitted',
            approved: 'Disetujui',
            rejected: 'Ditolak',
            active: 'Aktif',
            inactive: 'Nonaktif',
            pending: 'Pending',
            cancelled: 'Dibatalkan',
            issued: 'Diterbitkan',
            acknowledged: 'Dikonfirmasi',
            completed: 'Selesai',
        };
        const badge = s =>
            `<span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold ${_bc[s]||'bg-gray-100 text-gray-600'}">${_bl[s]||s}</span>`;

        const confirmAction = (msg, cb) => {
            if (confirm(msg)) cb();
        };

        /* ─── LOGOUT ──────────────────────────────────────────── */
        async function doLogout() {
            try {
                const r = await API.post('/logout');
                if (r.success) {
                    window.location.href = r.redirect;
                    return;
                }
            } catch (_) {}
            window.location.href = '/login';
        }

        /* ─── LOAD USER INFO ──────────────────────────────────── */
        (async () => {
            try {
                const r = await API.get('/auth/me');
                if (r?.success && r.data) {
                    const name = r.data.name || 'Admin';
                    const el1 = document.getElementById('header-uname');
                    const el2 = document.getElementById('user-avatar');
                    const el3 = document.getElementById('dd-name');
                    if (el1) el1.textContent = name;
                    if (el2) el2.textContent = name[0].toUpperCase();
                    if (el3) el3.textContent = name;
                }
            } catch (_) {}
        })();

        /* ─── INIT ────────────────────────────────────────────── */
        document.addEventListener('DOMContentLoaded', () => {
            Sb.init();
        });
    </script>

    @stack('scripts')
</body>

</html>
