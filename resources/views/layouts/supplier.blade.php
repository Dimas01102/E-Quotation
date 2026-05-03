{{-- resources/views/layouts/supplier.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page-title', 'Supplier') — E-Quotation</title>
    <link rel="icon" type="image/png" href="/assets/images/logo.jpg">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            darkMode: 'class'
        };
    </script>
</head>


<body class="bg-gray-50 dark:bg-gray-950 text-gray-800 dark:text-white antialiased min-h-screen">

    <div class="flex min-h-screen">

        {{-- ── Mobile backdrop ─────────────────────────────────────────────── --}}
        <div id="mob-backdrop" onclick="Sb.closeMobile()"
            class="fixed inset-0 z-40 hidden bg-black bg-opacity-60 xl:hidden"></div>

        {{-- ══════════════════════════════════════════════════════════════════
             SIDEBAR DESKTOP
        ══════════════════════════════════════════════════════════════════ --}}
        <aside id="main-sidebar"
            class="fixed inset-y-0 left-0 z-40 flex-shrink-0 hidden xl:flex flex-col
                   bg-white dark:bg-gray-900
                   border-r border-gray-200 dark:border-gray-800
                   px-3 overflow-hidden"
            style="width: 16rem; transition: width 0.3s ease;">

            {{-- Logo --}}
            <div class="flex h-16 flex-shrink-0 items-center gap-3 px-1
                        border-b border-gray-100 dark:border-gray-800">
                <a href="/supplier/dashboard" class="flex items-center gap-3 min-w-0">
                    <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-shopping-cart text-white text-sm"></i>
                    </div>
                    <div id="desktopLogoLabel"
                         class="leading-tight overflow-hidden"
                         style="transition: opacity 0.2s ease, width 0.3s ease; opacity: 1; width: auto;">
                        <p class="text-gray-800 dark:text-white font-bold text-sm whitespace-nowrap">E-Quotation</p>
                        <p class="text-gray-400 dark:text-gray-500 text-xs whitespace-nowrap">Supplier Portal</p>
                    </div>
                </a>
            </div>

            {{-- Nav --}}
            <nav class="flex flex-1 flex-col gap-0.5 overflow-y-auto overflow-x-hidden py-4">
                @php
                    $seg    = request()->segment(2) ?? '';
                    $active = 'desk-nav-link flex items-center gap-3 rounded-xl bg-blue-50 dark:bg-blue-900/20 px-3 py-2.5 text-sm font-semibold text-blue-700 dark:text-blue-400';
                    $normal = 'desk-nav-link flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-400 transition-colors hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white';
                    $ni     = fn(bool $on) => $on ? $active : $normal;
                @endphp

                <p id="navSectionLabel"
                   class="mt-1 mb-1 px-3 text-xs font-bold uppercase tracking-widest
                          text-gray-400 dark:text-gray-500 whitespace-nowrap overflow-hidden"
                   style="transition: opacity 0.2s ease, max-width 0.3s ease; max-width: 200px; opacity: 1;">
                    Menu
                </p>

                <a href="/supplier/dashboard" class="{{ $ni($seg === 'dashboard') }}" title="Dashboard">
                    <i class="fas fa-home w-5 text-center flex-shrink-0"></i>
                    <span class="desk-nav-label whitespace-nowrap overflow-hidden"
                          style="transition: opacity 0.2s ease, max-width 0.3s ease; max-width: 200px; opacity: 1;">
                        Dashboard
                    </span>
                </a>
                <a href="/supplier/rfq" class="{{ $ni($seg === 'rfq') }}" title="RFQ & Undangan">
                    <i class="fas fa-file-invoice w-5 text-center flex-shrink-0"></i>
                    <span class="desk-nav-label whitespace-nowrap overflow-hidden"
                          style="transition: opacity 0.2s ease, max-width 0.3s ease; max-width: 200px; opacity: 1;">
                        RFQ &amp; Undangan
                    </span>
                </a>
                <a href="/supplier/quotations" class="{{ $ni($seg === 'quotations') }}" title="Penawaran Saya">
                    <i class="fas fa-paper-plane w-5 text-center flex-shrink-0"></i>
                    <span class="desk-nav-label whitespace-nowrap overflow-hidden"
                          style="transition: opacity 0.2s ease, max-width 0.3s ease; max-width: 200px; opacity: 1;">
                        Penawaran Saya
                    </span>
                </a>
                <a href="/supplier/profile" class="{{ $ni($seg === 'profile') }}" title="Profil Perusahaan">
                    <i class="fas fa-building w-5 text-center flex-shrink-0"></i>
                    <span class="desk-nav-label whitespace-nowrap overflow-hidden"
                          style="transition: opacity 0.2s ease, max-width 0.3s ease; max-width: 200px; opacity: 1;">
                        Profil Perusahaan
                    </span>
                </a>

                {{-- User info + logout --}}
                <div class="mt-auto border-t border-gray-100 dark:border-gray-800 pt-3">
                    <div class="flex items-center gap-3 px-3 mb-2 overflow-hidden">
                        <div class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-lg
                                    flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-user text-green-600 dark:text-green-400 text-xs"></i>
                        </div>
                        <div id="desktopUserLabel"
                             class="min-w-0 overflow-hidden"
                             style="transition: opacity 0.2s ease, width 0.3s ease; opacity: 1; width: auto;">
                            <p id="userNameSidebar"
                               class="text-gray-800 dark:text-white text-xs font-medium truncate whitespace-nowrap">—</p>
                            <p class="text-gray-400 dark:text-gray-500 text-xs whitespace-nowrap">Supplier</p>
                        </div>
                    </div>
                    <button onclick="doLogout()" title="Logout"
                        class="desk-nav-link flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium
                               text-red-500 dark:text-red-400 transition-colors
                               hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 dark:hover:text-red-300">
                        <i class="fas fa-sign-out-alt w-5 text-center flex-shrink-0"></i>
                        <span class="desk-nav-label whitespace-nowrap overflow-hidden"
                              style="transition: opacity 0.2s ease, max-width 0.3s ease; max-width: 200px; opacity: 1;">
                            Logout
                        </span>
                    </button>
                </div>
            </nav>
        </aside>

        {{-- ══════════════════════════════════════════════════════════════════
             PAGE AREA
        ══════════════════════════════════════════════════════════════════ --}}
        <div id="mainContent" class="flex flex-1 flex-col min-w-0"
             style="margin-left: 16rem; transition: margin-left 0.3s ease;">

            {{-- ── TOPBAR ─────────────────────────────────────────────────── --}}
            <header
                class="sticky top-0 z-30 flex h-16 items-center gap-3 px-5
                       bg-white dark:bg-gray-900
                       border-b border-gray-200 dark:border-gray-800">

                {{-- Desktop sidebar toggle --}}
                <button onclick="Sb.toggleDesktop()" title="Toggle Sidebar"
                    class="hidden xl:flex w-9 h-9 items-center justify-center rounded-xl
                           text-gray-500 hover:text-gray-800 dark:hover:text-white
                           hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                {{-- Mobile hamburger --}}
                <button onclick="Sb.toggleMobile()" title="Menu"
                    class="flex xl:hidden w-9 h-9 items-center justify-center rounded-xl
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

                    <button id="darkToggle" type="button" title="Toggle Dark Mode"
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

                    {{-- User info di topbar --}}
                    <div class="flex items-center gap-2 px-3 py-1.5 rounded-xl
                                hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <div class="w-7 h-7 rounded-lg bg-blue-600 flex items-center justify-center
                                    text-white text-xs font-bold flex-shrink-0">
                            S
                        </div>
                        <span id="topUserName"
                              class="text-sm font-medium text-gray-700 dark:text-gray-300
                                     hidden sm:block max-w-[120px] truncate">—</span>
                    </div>

                </div>
            </header>

            {{-- ── CONTENT ─────────────────────────────────────────────────── --}}
            <main class="flex-1 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════════════
         MOBILE SIDEBAR
    ══════════════════════════════════════════════════════════════════════ --}}
    <aside id="mob-sidebar"
        class="fixed inset-y-0 left-0 z-50 hidden w-64 flex-col
               bg-white dark:bg-gray-900
               border-r border-gray-200 dark:border-gray-800
               px-3 overflow-hidden xl:hidden">

        <div class="flex h-16 flex-shrink-0 items-center gap-3 px-1
                    border-b border-gray-100 dark:border-gray-800">
            <a href="/supplier/dashboard" class="flex items-center gap-3">
                <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-shopping-cart text-white text-sm"></i>
                </div>
                <div class="leading-tight">
                    <p class="text-gray-800 dark:text-white font-bold text-sm">E-Quotation</p>
                    <p class="text-gray-400 dark:text-gray-500 text-xs">Supplier Portal</p>
                </div>
            </a>
        </div>

        <nav class="flex flex-1 flex-col gap-0.5 overflow-y-auto py-4">
            @php $seg2 = request()->segment(2) ?? ''; @endphp

            <p class="mt-1 mb-1 px-3 text-xs font-bold uppercase tracking-widest
                       text-gray-400 dark:text-gray-500">Menu</p>

            <a href="/supplier/dashboard" onclick="Sb.closeMobile()"
               class="{{ $ni($seg2 === 'dashboard') }}">
                <i class="fas fa-home w-5 text-center flex-shrink-0"></i>
                <span>Dashboard</span>
            </a>
            <a href="/supplier/rfq" onclick="Sb.closeMobile()"
               class="{{ $ni($seg2 === 'rfq') }}">
                <i class="fas fa-file-invoice w-5 text-center flex-shrink-0"></i>
                <span>RFQ &amp; Undangan</span>
            </a>
            <a href="/supplier/quotations" onclick="Sb.closeMobile()"
               class="{{ $ni($seg2 === 'quotations') }}">
                <i class="fas fa-paper-plane w-5 text-center flex-shrink-0"></i>
                <span>Penawaran Saya</span>
            </a>
            <a href="/supplier/profile" onclick="Sb.closeMobile()"
               class="{{ $ni($seg2 === 'profile') }}">
                <i class="fas fa-building w-5 text-center flex-shrink-0"></i>
                <span>Profil Perusahaan</span>
            </a>

            <div class="mt-auto border-t border-gray-100 dark:border-gray-800 pt-3">
                <div class="flex items-center gap-3 px-3 mb-2">
                    <div class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-lg
                                flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-user text-green-600 dark:text-green-400 text-xs"></i>
                    </div>
                    <div class="min-w-0">
                        <p id="mobUserName"
                           class="text-gray-800 dark:text-white text-xs font-medium truncate">—</p>
                        <p class="text-gray-400 dark:text-gray-500 text-xs">Supplier</p>
                    </div>
                </div>
                <button onclick="doLogout()"
                    class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium
                           text-red-500 dark:text-red-400 transition-colors
                           hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 dark:hover:text-red-300">
                    <i class="fas fa-sign-out-alt w-5 text-center flex-shrink-0"></i>
                    <span>Logout</span>
                </button>
            </div>
        </nav>
    </aside>

    {{-- ════════════════════════════════════════════════════════════════════
         GLOBAL SCRIPTS
    ════════════════════════════════════════════════════════════════════ --}}
    <script>
        const CSRF = () => document.querySelector('meta[name="csrf-token"]')?.content || '';

        window.fmtRp = function (n) {
            return n ? 'Rp ' + parseInt(n).toLocaleString('id-ID') : '—';
        };
        window.fmtDate = function (d) {
            return d ? new Date(d).toLocaleDateString('id-ID', {
                day: 'numeric', month: 'short', year: 'numeric'
            }) : '—';
        };
        window.statusBadge = function (s) {
            const m = {
                open:      'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
                draft:     'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400',
                closed:    'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400',
                pending:   'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                approved:  'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                rejected:  'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400',
                invited:   'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                submitted: 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
            };
            return '<span class="px-2.5 py-1 rounded-full text-xs font-medium ' +
                (m[s] || 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400') +
                '">' + (s || '—') + '</span>';
        };
        window.showToast = function (msg, type) {
            const t  = document.createElement('div');
            const bg = type === 'error' ? 'bg-red-600' : type === 'info' ? 'bg-blue-600' : 'bg-green-600';
            t.className = 'fixed bottom-5 right-5 px-5 py-3 rounded-xl text-white text-sm z-[9999] shadow-xl ' + bg;
            t.textContent = msg;
            document.body.appendChild(t);
            setTimeout(() => t.remove(), 3500);
        };
        window.showModal = function (id) {
            const el = document.getElementById(id);
            if (el) el.style.display = 'flex';
        };
        window.hideModal = function (id) {
            const el = document.getElementById(id);
            if (el) el.style.display = 'none';
        };

        // ── SIDEBAR COLLAPSE ─────────────────────────────────────────────
        const Sb = {
            STORAGE_KEY: 'sb_supplier_collapsed',
            EXPANDED_W:  '16rem',
            COLLAPSED_W: '4rem',

            get isCollapsed() {
                return localStorage.getItem(this.STORAGE_KEY) === '1';
            },

            applyDesktop(collapsed) {
                const sb      = document.getElementById('main-sidebar');
                const main    = document.getElementById('mainContent');
                const labels  = document.querySelectorAll('.desk-nav-label');
                const logoLbl = document.getElementById('desktopLogoLabel');
                const userLbl = document.getElementById('desktopUserLabel');
                const secLbl  = document.getElementById('navSectionLabel');

                if (!sb || !main) return;

                if (collapsed) {
                    sb.style.width        = this.COLLAPSED_W;
                    main.style.marginLeft = this.COLLAPSED_W;

                    labels.forEach(el => { el.style.opacity = '0'; el.style.maxWidth = '0'; });
                    if (logoLbl) { logoLbl.style.opacity = '0'; logoLbl.style.width = '0'; }
                    if (userLbl) { userLbl.style.opacity = '0'; userLbl.style.width = '0'; }
                    if (secLbl)  { secLbl.style.opacity  = '0'; secLbl.style.maxWidth = '0'; }

                    document.querySelectorAll('.desk-nav-link').forEach(a => {
                        a.style.justifyContent = 'center';
                        a.style.paddingLeft    = '0';
                        a.style.paddingRight   = '0';
                    });
                } else {
                    sb.style.width        = this.EXPANDED_W;
                    main.style.marginLeft = this.EXPANDED_W;

                    labels.forEach(el => { el.style.opacity = '1'; el.style.maxWidth = '200px'; });
                    if (logoLbl) { logoLbl.style.opacity = '1'; logoLbl.style.width = 'auto'; }
                    if (userLbl) { userLbl.style.opacity = '1'; userLbl.style.width = 'auto'; }
                    if (secLbl)  { secLbl.style.opacity  = '1'; secLbl.style.maxWidth = '200px'; }

                    document.querySelectorAll('.desk-nav-link').forEach(a => {
                        a.style.justifyContent = '';
                        a.style.paddingLeft    = '';
                        a.style.paddingRight   = '';
                    });
                }
            },

            init()          { this.applyDesktop(this.isCollapsed); },
            toggleDesktop() {
                const next = !this.isCollapsed;
                localStorage.setItem(this.STORAGE_KEY, next ? '1' : '0');
                this.applyDesktop(next);
            },
            toggleMobile() {
                const mob = document.getElementById('mob-sidebar');
                const bd  = document.getElementById('mob-backdrop');
                const open = !mob.classList.contains('hidden');
                if (open) {
                    mob.classList.add('hidden');    mob.classList.remove('flex');
                    bd.classList.add('hidden');     document.body.style.overflow = '';
                } else {
                    mob.classList.remove('hidden'); mob.classList.add('flex');
                    bd.classList.remove('hidden');  document.body.style.overflow = 'hidden';
                }
            },
            closeMobile() {
                const mob = document.getElementById('mob-sidebar');
                const bd  = document.getElementById('mob-backdrop');
                if (mob) { mob.classList.add('hidden'); mob.classList.remove('flex'); }
                if (bd)  { bd.classList.add('hidden'); }
                document.body.style.overflow = '';
            }
        };

        document.addEventListener('DOMContentLoaded', function () {
            const btn  = document.getElementById('darkToggle');
            const moon = document.getElementById('iconMoon');
            const sun  = document.getElementById('iconSun');

            function applyDark(isDark) {
                document.documentElement.classList.toggle('dark', isDark);
                // Bulan tampil saat light, matahari tampil saat dark
                if (moon) moon.classList.toggle('hidden', isDark);
                if (sun)  sun.classList.toggle('hidden', !isDark);
            }

            // Baca preferensi tersimpan; jika belum pernah disimpan → false = light mode
            applyDark(localStorage.getItem('darkMode') === 'true');

            if (btn) {
                btn.addEventListener('click', function () {
                    const isDark = document.documentElement.classList.toggle('dark');
                    localStorage.setItem('darkMode', isDark);
                    applyDark(isDark);
                });
            }
        });

        // ── LOAD USER ─────────────────────────────────────────────────────
        async function loadUser() {
            try {
                const res = await fetch('/api/auth/me', {
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF() }
                });
                if (!res.ok) { window.location.href = '/login'; return; }
                const data = await res.json();
                const name = data.user?.name || data.name || 'Supplier';
                ['userNameSidebar', 'topUserName', 'mobUserName'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.textContent = name;
                });
            } catch (e) {}
        }

        // ── LOGOUT ────────────────────────────────────────────────────────
        async function doLogout() {
            try {
                await fetch('/api/logout', {
                    method: 'POST',
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF() }
                });
            } catch (e) {}
            window.location.href = '/login';
        }

        // ── INIT ──────────────────────────────────────────────────────────
        document.addEventListener('DOMContentLoaded', () => {
            Sb.init();
            loadUser();
        });
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') Sb.closeMobile();
        });
    </script>

    @stack('scripts')
</body>

</html>