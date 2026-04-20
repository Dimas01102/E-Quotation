<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page-title', 'Admin') — E-Quotation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class'
        };
    </script>
</head>

<body class="bg-gray-50 dark:bg-gray-950 min-h-screen">

    <div class="flex min-h-screen">

        {{-- ── Sidebar ─────────────────────────────────────────────────── --}}
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 z-40 w-64 flex flex-col
                   bg-white dark:bg-gray-900
                   border-r border-gray-200 dark:border-gray-800
                   overflow-hidden"
            style="transition: width 0.25s ease;">

            {{-- ── Logo ── --}}
            <div class="flex items-center h-16 px-4
                        border-b border-gray-100 dark:border-gray-800 flex-shrink-0 gap-3 min-w-0">

                <img id="sidebarLogo"
                     src="/images/logo.jpg"
                     alt="Logo"
                     class="w-8 h-8 rounded-xl object-cover flex-shrink-0"
                     onerror="this.style.display='none'; document.getElementById('sidebarLogoFallback').style.display='flex';">

               

                {{-- Label — disembunyikan saat collapsed --}}
                <div id="sidebarLogoLabel"
                     class="flex items-center gap-2 min-w-0 overflow-hidden"
                     style="transition: opacity 0.2s ease, width 0.25s ease;">
                    <span class="font-bold text-gray-800 dark:text-white text-sm whitespace-nowrap">Dashboard</span>
                    <span class="text-xs font-semibold px-2 py-0.5 bg-blue-100 text-blue-700
                                 dark:bg-blue-900/30 dark:text-blue-400 rounded-full whitespace-nowrap flex-shrink-0">
                        Admin
                    </span>
                </div>
            </div>

            {{-- ── Nav ── --}}
            <nav class="flex-1 overflow-y-auto overflow-x-hidden py-4 px-2 space-y-0.5" id="sidebarNav">

                <a href="/admin/dashboard" data-path="dashboard" title="Dashboard"
                    class="nav-link group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium
                           transition-all text-gray-600 dark:text-gray-400
                           hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="nav-label whitespace-nowrap overflow-hidden"
                          style="transition: opacity 0.2s ease, max-width 0.25s ease; max-width: 200px; opacity: 1;">
                        Dashboard
                    </span>
                </a>

                <a href="/admin/master-data" data-path="master-data" title="Master Data"
                    class="nav-link group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium
                           transition-all text-gray-600 dark:text-gray-400
                           hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <span class="nav-label whitespace-nowrap overflow-hidden"
                          style="transition: opacity 0.2s ease, max-width 0.25s ease; max-width: 200px; opacity: 1;">
                        Master Data
                    </span>
                </a>

                <a href="/admin/suppliers" data-path="suppliers" title="Supplier"
                    class="nav-link group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium
                           transition-all text-gray-600 dark:text-gray-400
                           hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="nav-label whitespace-nowrap overflow-hidden"
                          style="transition: opacity 0.2s ease, max-width 0.25s ease; max-width: 200px; opacity: 1;">
                        Supplier
                    </span>
                </a>

                <a href="/admin/batches" data-path="batches" title="Batch / RFQ"
                    class="nav-link group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium
                           transition-all text-gray-600 dark:text-gray-400
                           hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span class="nav-label whitespace-nowrap overflow-hidden"
                          style="transition: opacity 0.2s ease, max-width 0.25s ease; max-width: 200px; opacity: 1;">
                        Batch / RFQ
                    </span>
                </a>

                <a href="/admin/quotations" data-path="quotations" title="Quotation"
                    class="nav-link group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium
                           transition-all text-gray-600 dark:text-gray-400
                           hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="nav-label whitespace-nowrap overflow-hidden"
                          style="transition: opacity 0.2s ease, max-width 0.25s ease; max-width: 200px; opacity: 1;">
                        Quotation
                    </span>
                </a>

                <a href="/admin/reports" data-path="reports" title="Laporan"
                    class="nav-link group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium
                           transition-all text-gray-600 dark:text-gray-400
                           hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="nav-label whitespace-nowrap overflow-hidden"
                          style="transition: opacity 0.2s ease, max-width 0.25s ease; max-width: 200px; opacity: 1;">
                        Laporan
                    </span>
                </a>

            </nav>

            {{-- ── Footer ── --}}
            <div class="p-4 border-t border-gray-100 dark:border-gray-800 flex-shrink-0 overflow-hidden">
                <p id="sidebarFooterText"
                   class="text-xs text-gray-400 text-center whitespace-nowrap overflow-hidden"
                   style="transition: opacity 0.2s ease, max-width 0.25s ease; max-width: 200px; opacity: 1;">
                    E-Quotation System
                </p>
            </div>
        </aside>

        {{-- ── Main ─────────────────────────────────────────────────────── --}}
        <div id="mainContent" class="flex-1 flex flex-col min-w-0"
             style="margin-left: 16rem; transition: margin-left 0.25s ease;">

            {{-- Top Bar --}}
            <header
                class="sticky top-0 z-30 h-16 bg-white dark:bg-gray-900
                       border-b border-gray-200 dark:border-gray-800
                       flex items-center gap-3 px-5">

                <button id="sidebarToggle" type="button"
                    class="w-9 h-9 flex items-center justify-center rounded-xl
                           text-gray-500 hover:text-gray-800 dark:hover:text-white
                           hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 flex-1 truncate">
                    @yield('page-title', 'Dashboard')
                </h2>

                <div class="flex items-center gap-2">

                    {{-- Dark Mode --}}
                    <button id="darkToggle" type="button"
                        class="w-9 h-9 flex items-center justify-center rounded-xl
                               text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <svg id="iconMoon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <svg id="iconSun" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 5a7 7 0 110 14A7 7 0 0112 5z" />
                        </svg>
                    </button>

                    {{-- User Dropdown --}}
                    <div class="relative" id="userMenuWrapper">
                        <button id="userMenuBtn" type="button"
                            class="flex items-center gap-2 px-3 py-1.5 rounded-xl
                                   hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                            <div id="userAvatar"
                                class="w-7 h-7 rounded-lg bg-blue-600 flex items-center justify-center
                                       text-white text-xs font-bold flex-shrink-0">
                                A
                            </div>
                            <span id="userName"
                                class="text-sm font-medium text-gray-700 dark:text-gray-300
                                       hidden sm:block max-w-[120px] truncate">
                                Admin
                            </span>
                            <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none"
                                 stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div id="userDropdown"
                            class="absolute right-0 top-full mt-1 w-52 bg-white dark:bg-gray-900
                                   border border-gray-200 dark:border-gray-700 rounded-2xl shadow-xl z-50 overflow-hidden"
                            style="display:none">
                            <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-800">
                                <p id="dropdownName"
                                    class="text-sm font-semibold text-gray-800 dark:text-white truncate">Admin</p>
                                <p id="dropdownEmail" class="text-xs text-gray-400 truncate"></p>
                            </div>
                            <div class="p-2">
                                <button onclick="openProfileModal()" type="button"
                                    class="w-full flex items-center gap-3 px-3 py-2 text-sm
                                           text-gray-700 dark:text-gray-300
                                           hover:bg-gray-100 dark:hover:bg-gray-800 rounded-xl transition-colors text-left">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit Profil
                                </button>
                                <button onclick="doLogout()" type="button"
                                    class="w-full flex items-center gap-3 px-3 py-2 text-sm
                                           text-red-600 dark:text-red-400
                                           hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-colors text-left">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Logout
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Page Content --}}
            <main class="flex-1 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- ── Edit Profile Modal ────────────────────────────────────────────── --}}
    <div id="profileModal"
         class="fixed inset-0 z-[60] items-center justify-center bg-black/60 backdrop-blur-sm"
         style="display:none">
        <div
            class="bg-white dark:bg-gray-900 rounded-2xl w-full max-w-md mx-4 shadow-2xl
                   border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between px-6 py-4
                        border-b border-gray-100 dark:border-gray-800">
                <h3 class="font-semibold text-gray-800 dark:text-white">Edit Profil Admin</h3>
                <button onclick="closeProfileModal()"
                        class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div id="profileAlert" class="hidden p-3 rounded-xl text-sm"></div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">
                        Nama <span class="text-red-500">*</span>
                    </label>
                    <input id="profileName" type="text"
                        class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800
                               border border-gray-200 dark:border-gray-700 rounded-xl
                               focus:outline-none focus:ring-2 focus:ring-blue-500
                               text-gray-800 dark:text-white">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">Email</label>
                    <input id="profileEmail" type="email" disabled
                        class="w-full px-4 py-2.5 text-sm bg-gray-100 dark:bg-gray-700
                               border border-gray-200 dark:border-gray-600 rounded-xl
                               text-gray-500 dark:text-gray-400 cursor-not-allowed">
                </div>
                <div class="pt-2 border-t border-gray-100 dark:border-gray-800">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Ubah Password</p>
                    <p class="text-xs text-gray-400 mb-3">Kosongkan jika tidak ingin mengubah password.</p>
                    <div class="space-y-3">
                        <input id="profilePassword" type="password"
                               placeholder="Password baru (min. 8 karakter)"
                            class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800
                                   border border-gray-200 dark:border-gray-700 rounded-xl
                                   focus:outline-none focus:ring-2 focus:ring-blue-500
                                   text-gray-800 dark:text-white">
                        <input id="profilePasswordConfirm" type="password"
                               placeholder="Konfirmasi password baru"
                            class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800
                                   border border-gray-200 dark:border-gray-700 rounded-xl
                                   focus:outline-none focus:ring-2 focus:ring-blue-500
                                   text-gray-800 dark:text-white">
                    </div>
                </div>
            </div>
            <div class="px-6 pb-6 flex gap-3">
                <button onclick="saveProfile()"
                    class="flex-1 py-2.5 bg-blue-600 hover:bg-blue-700 text-white
                           rounded-xl text-sm font-medium transition-colors">
                    Simpan Perubahan
                </button>
                <button onclick="closeProfileModal()"
                    class="flex-1 py-2.5 border border-gray-200 dark:border-gray-700
                           text-gray-600 dark:text-gray-300 rounded-xl text-sm
                           hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                    Batal
                </button>
            </div>
        </div>
    </div>

    {{-- ── GLOBAL JS ─────────────────────────────────────────────────────── --}}
    <script>
        // ═══════════════════════════════════════════════════════════════════
        // GLOBAL HELPERS
        // ═══════════════════════════════════════════════════════════════════

        window.CSRF = function () {
            return document.querySelector('meta[name="csrf-token"]')?.content || '';
        };
        window.getCSRF = window.CSRF;

        window.fmtDate = function (d) {
            if (!d) return '—';
            return new Date(d).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
        };

        window.fmtRp = function (n) {
            if (n == null || n === '') return '—';
            return 'Rp ' + parseInt(n).toLocaleString('id-ID');
        };

        window.statusBadge = window.badge = function (s) {
            const m = {
                open:      'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                draft:     'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400',
                closed:    'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400',
                pending:   'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                approved:  'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                rejected:  'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400',
                invited:   'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                submitted: 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                winner:    'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
            };
            return '<span class="px-2.5 py-1 rounded-full text-xs font-medium ' +
                (m[s] || 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400') +
                '">' + (s || '—') + '</span>';
        };

        window.toast = function (msg, type) {
            const t = document.createElement('div');
            const bg = type === 'error' ? 'bg-red-600' : type === 'info' ? 'bg-blue-600' : 'bg-green-600';
            t.className = 'fixed bottom-5 right-5 px-5 py-3 rounded-xl text-white text-sm z-[9999] shadow-xl ' + bg;
            t.textContent = msg;
            document.body.appendChild(t);
            setTimeout(() => t.remove(), 3500);
        };

        window.showModal = function (id) {
            const el = document.getElementById(id);
            if (!el) return;
            el.style.display = 'flex';
        };
        window.hideModal = function (id) {
            const el = document.getElementById(id);
            if (el) el.style.display = 'none';
        };

        // ═══════════════════════════════════════════════════════════════════
        // SIDEBAR COLLAPSE (icon-only ↔ expanded)
        // ═══════════════════════════════════════════════════════════════════
        (function () {
            const STORAGE_KEY = 'sb_admin_collapsed';
            const EXPANDED_W  = '16rem';   // w-64
            const COLLAPSED_W = '4rem';    // w-16

            function isCollapsed() {
                return localStorage.getItem(STORAGE_KEY) === '1';
            }

            function applyState(collapsed) {
                const sidebar  = document.getElementById('sidebar');
                const main     = document.getElementById('mainContent');
                const labels   = document.querySelectorAll('.nav-label');
                const logoLbl  = document.getElementById('sidebarLogoLabel');
                const footer   = document.getElementById('sidebarFooterText');

                if (!sidebar || !main) return;

                if (collapsed) {
                    // Sidebar menyempit ke icon-only
                    sidebar.style.width = COLLAPSED_W;
                    main.style.marginLeft = COLLAPSED_W;

                    // Sembunyikan semua label teks
                    labels.forEach(el => {
                        el.style.opacity  = '0';
                        el.style.maxWidth = '0';
                    });
                    if (logoLbl) {
                        logoLbl.style.opacity  = '0';
                        logoLbl.style.width    = '0';
                        logoLbl.style.overflow = 'hidden';
                    }
                    if (footer) {
                        footer.style.opacity  = '0';
                        footer.style.maxWidth = '0';
                    }

                    // Pusatkan icon di nav link
                    document.querySelectorAll('.nav-link').forEach(a => {
                        a.style.justifyContent = 'center';
                        a.style.paddingLeft    = '0';
                        a.style.paddingRight   = '0';
                    });

                } else {
                    // Sidebar expanded
                    sidebar.style.width = EXPANDED_W;
                    main.style.marginLeft = EXPANDED_W;

                    // Tampilkan semua label teks
                    labels.forEach(el => {
                        el.style.opacity  = '1';
                        el.style.maxWidth = '200px';
                    });
                    if (logoLbl) {
                        logoLbl.style.opacity  = '1';
                        logoLbl.style.width    = '';
                        logoLbl.style.overflow = 'hidden';
                    }
                    if (footer) {
                        footer.style.opacity  = '1';
                        footer.style.maxWidth = '200px';
                    }

                    // Kembalikan padding nav link
                    document.querySelectorAll('.nav-link').forEach(a => {
                        a.style.justifyContent = '';
                        a.style.paddingLeft    = '';
                        a.style.paddingRight   = '';
                    });
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                // Terapkan state awal
                applyState(isCollapsed());

                // Tombol toggle
                const btn = document.getElementById('sidebarToggle');
                if (btn) {
                    btn.addEventListener('click', function (e) {
                        e.stopPropagation();
                        const next = !isCollapsed();
                        localStorage.setItem(STORAGE_KEY, next ? '1' : '0');
                        applyState(next);
                    });
                }
            });
        })();

        // ── Dark Mode ─────────────────────────────────────────────────────
        document.addEventListener('DOMContentLoaded', function () {
            const btn  = document.getElementById('darkToggle');
            const moon = document.getElementById('iconMoon');
            const sun  = document.getElementById('iconSun');

            function applyDark(isDark) {
                document.documentElement.classList.toggle('dark', isDark);
                if (moon) moon.classList.toggle('hidden', isDark);
                if (sun)  sun.classList.toggle('hidden', !isDark);
            }

            applyDark(localStorage.getItem('darkMode') === 'true');

            if (btn) btn.addEventListener('click', function () {
                const isDark = document.documentElement.classList.toggle('dark');
                localStorage.setItem('darkMode', isDark);
                applyDark(isDark);
            });
        });

        // ── Active Nav Link ───────────────────────────────────────────────
        document.addEventListener('DOMContentLoaded', function () {
            const path  = window.location.pathname;
            const links = document.querySelectorAll('.nav-link');
            links.forEach(function (a) {
                const p = a.getAttribute('data-path');
                if (p && path.includes(p)) {
                    a.classList.add('bg-blue-50', 'dark:bg-blue-900/30', 'text-blue-700', 'dark:text-blue-400');
                    a.classList.remove('text-gray-600', 'dark:text-gray-400');
                }
            });
        });

        // ── User Dropdown + load user info ────────────────────────────────
        document.addEventListener('DOMContentLoaded', function () {
            const btn      = document.getElementById('userMenuBtn');
            const dropdown = document.getElementById('userDropdown');
            if (!btn || !dropdown) return;

            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                const vis = dropdown.style.display !== 'none' && dropdown.style.display !== '';
                dropdown.style.display = vis ? 'none' : 'block';
            });

            document.addEventListener('click', function (e) {
                if (!document.getElementById('userMenuWrapper')?.contains(e.target)) {
                    dropdown.style.display = 'none';
                }
            });

            fetch('/api/auth/me', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF() }
            })
            .then(r => r.ok ? r.json() : null)
            .then(data => {
                if (!data) return;
                const name   = data.name || 'Admin';
                const email  = data.email || '';
                const avatar = name.charAt(0).toUpperCase();
                const set    = (id, val) => { const el = document.getElementById(id); if (el) el.textContent = val; };
                set('userName',     name);
                set('userAvatar',   avatar);
                set('dropdownName', name);
                set('dropdownEmail', email);
            })
            .catch(() => {});
        });

        // ── Logout ────────────────────────────────────────────────────────
        window.doLogout = async function () {
            try {
                await fetch('/api/logout', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': CSRF(), 'Accept': 'application/json' }
                });
            } catch (e) {}
            window.location.href = '/login';
        };

        // ── Edit Profile Modal ────────────────────────────────────────────
        window.openProfileModal = function () {
            document.getElementById('userDropdown').style.display = 'none';

            fetch('/api/auth/me', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF() }
            })
            .then(r => r.ok ? r.json() : {})
            .then(data => {
                document.getElementById('profileName').value            = data.name  || '';
                document.getElementById('profileEmail').value           = data.email || '';
                document.getElementById('profilePassword').value        = '';
                document.getElementById('profilePasswordConfirm').value = '';
                document.getElementById('profileAlert').classList.add('hidden');
            });

            document.getElementById('profileModal').style.display = 'flex';
        };

        window.closeProfileModal = function () {
            document.getElementById('profileModal').style.display = 'none';
        };

        window.saveProfile = async function () {
            const name   = document.getElementById('profileName').value.trim();
            const pw     = document.getElementById('profilePassword').value;
            const pwConf = document.getElementById('profilePasswordConfirm').value;
            const alertEl = document.getElementById('profileAlert');

            function showAlert(msg, ok) {
                alertEl.className = 'p-3 rounded-xl text-sm ' + (ok
                    ? 'bg-green-50 text-green-700 border border-green-200 dark:bg-green-900/20 dark:text-green-400'
                    : 'bg-red-50 text-red-700 border border-red-200 dark:bg-red-900/20 dark:text-red-400');
                alertEl.textContent = msg;
                alertEl.classList.remove('hidden');
            }

            if (!name)                  { showAlert('Nama wajib diisi.');                       return; }
            if (pw && pw.length < 8)    { showAlert('Password minimal 8 karakter.');            return; }
            if (pw && pw !== pwConf)    { showAlert('Konfirmasi password tidak cocok.');         return; }

            const body = { name };
            if (pw) { body.password = pw; body.password_confirmation = pwConf; }

            try {
                const res  = await fetch('/api/admin/profile', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF()
                    },
                    body: JSON.stringify(body)
                });
                const json = await res.json();

                if (res.ok && json.success) {
                    showAlert('Profil berhasil diperbarui!', true);
                    const set = (id, val) => { const el = document.getElementById(id); if (el) el.textContent = val; };
                    set('userName',     name);
                    set('userAvatar',   name.charAt(0).toUpperCase());
                    set('dropdownName', name);
                    setTimeout(closeProfileModal, 1500);
                } else {
                    const msg = json.errors
                        ? Object.values(json.errors).flat().join(' ')
                        : (json.message || 'Gagal menyimpan.');
                    showAlert(msg);
                }
            } catch (e) {
                showAlert('Terjadi kesalahan koneksi.');
            }
        };

        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('profileModal');
            if (modal) modal.addEventListener('click', function (e) {
                if (e.target === modal) closeProfileModal();
            });
        });
    </script>

    @stack('scripts')
</body>

</html>