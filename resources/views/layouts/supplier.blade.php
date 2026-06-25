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
        tailwind.config = { darkMode: 'class' };
    </script>
</head>

<body class="bg-gray-50 dark:bg-gray-950 text-gray-800 dark:text-white antialiased min-h-screen">

    <div class="flex min-h-screen">

        {{-- ── Overlay (sama persis seperti admin) ─────────────────────── --}}
        <div id="sidebarOverlay"
             class="fixed inset-0 bg-black/50 z-40 hidden md:hidden"></div>

        {{-- ══════════════════════════════════════════════════════════════
            SIDEBAR
        ══════════════════════════════════════════════════════════════ --}}
        <x-sidebar type="supplier" />

        {{-- ══════════════════════════════════════════════════════════════
             PAGE AREA
        ══════════════════════════════════════════════════════════════ --}}
        <div id="mainContent"
             class="flex-1 flex flex-col min-w-0 ml-0 md:ml-64 transition-all duration-300">

            {{-- ── TOPBAR ──────────────────────────────────────────────── --}}
            <x-top-header-suplier />

            {{-- Overlay untuk mobile --}}

            {{-- ── CONTENT ─────────────────────────────────────────────── --}}
            <main class="flex-1 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════════════════════
         GLOBAL SCRIPTS
    ════════════════════════════════════════════════════════════════ --}}
    <script>
        // ═══════════════════════════════════════════════════════════════
        // GLOBAL HELPERS
        // ═══════════════════════════════════════════════════════════════
        const CSRF = () => document.querySelector('meta[name="csrf-token"]')?.content || '';

        window.fmtRp = function (n) {
            return n ? 'Rp ' + parseInt(n).toLocaleString('id-ID') : '—';
        };
        window.fmtDate = function (d) {
            return d ? new Date(d).toLocaleDateString('id-ID', {
                day: 'numeric', month: 'short', year: 'numeric'
            }) : '—';
        };
        window.capitalize = function(str) {
            if (!str) return '—';
            return str.charAt(0).toUpperCase() + str.slice(1);
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
                '">' + window.capitalize(s) + '</span>';
        };
        window.showToast = window.toast = function (msg, type) {
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

        // ═══════════════════════════════════════════════════════════════
        // SIDEBAR COLLAPSE
        // ═══════════════════════════════════════════════════════════════
        (function () {
            const STORAGE_KEY = 'sb_supplier_collapsed';

            function isMobile() {
                return window.innerWidth < 768;
            }

            function applyDesktopState() {
                const sidebar  = document.getElementById('main-sidebar');
                const main     = document.getElementById('mainContent');
                const footer   = document.getElementById('sidebarFooter');
                const labels   = document.querySelectorAll('.nav-label');
                const logoLbl  = document.getElementById('sidebarLogoLabel');
                const userLbl  = document.getElementById('sidebarUserLabel');
                const secLbl   = document.getElementById('navSectionLabel');
                if (!sidebar || !main) return;

                const collapsed = localStorage.getItem(STORAGE_KEY) === '1';

                if (collapsed) {
                    sidebar.style.width = '4rem';
                    main.classList.remove('md:ml-64');
                    main.classList.add('md:ml-16');
                    if (footer) footer.style.display = 'none';

                    labels.forEach(el => { el.style.opacity = '0'; el.style.maxWidth = '0'; });
                    if (logoLbl) { logoLbl.style.opacity = '0'; logoLbl.style.width = '0'; }
                    if (userLbl) { userLbl.style.opacity = '0'; userLbl.style.width = '0'; }
                    if (secLbl)  { secLbl.style.opacity  = '0'; secLbl.style.maxWidth = '0'; }

                    document.querySelectorAll('.nav-link').forEach(a => {
                        a.style.justifyContent = 'center';
                        a.style.paddingLeft    = '0';
                        a.style.paddingRight   = '0';
                    });
                } else {
                    sidebar.style.width = '16rem';
                    main.classList.remove('md:ml-16');
                    main.classList.add('md:ml-64');
                    if (footer) footer.style.display = '';

                    labels.forEach(el => { el.style.opacity = '1'; el.style.maxWidth = '200px'; });
                    if (logoLbl) { logoLbl.style.opacity = '1'; logoLbl.style.width = 'auto'; }
                    if (userLbl) { userLbl.style.opacity = '1'; userLbl.style.width = 'auto'; }
                    if (secLbl)  { secLbl.style.opacity  = '1'; secLbl.style.maxWidth = '200px'; }

                    document.querySelectorAll('.nav-link').forEach(a => {
                        a.style.justifyContent = '';
                        a.style.paddingLeft    = '';
                        a.style.paddingRight   = '';
                    });
                }
            }

            function applyMobileState() {
                const sidebar  = document.getElementById('main-sidebar');
                const main     = document.getElementById('mainContent');
                const overlay  = document.getElementById('sidebarOverlay');
                const footer   = document.getElementById('sidebarFooter');
                if (!sidebar || !main) return;

                sidebar.style.width = '';
                sidebar.classList.add('-translate-x-full');
                if (overlay) overlay.classList.add('hidden');
                main.classList.remove('md:ml-64', 'md:ml-16');
                if (footer) footer.style.display = 'none';

                // Reset nav-link alignment saat mobile
                document.querySelectorAll('.nav-link').forEach(a => {
                    a.style.justifyContent = '';
                    a.style.paddingLeft    = '';
                    a.style.paddingRight   = '';
                });
                // Pastikan label visible saat sidebar terbuka di mobile
                document.querySelectorAll('.nav-label').forEach(el => {
                    el.style.opacity  = '1';
                    el.style.maxWidth = '200px';
                });
                const logoLbl = document.getElementById('sidebarLogoLabel');
                const userLbl = document.getElementById('sidebarUserLabel');
                const secLbl  = document.getElementById('navSectionLabel');
                if (logoLbl) { logoLbl.style.opacity = '1'; logoLbl.style.width = 'auto'; }
                if (userLbl) { userLbl.style.opacity = '1'; userLbl.style.width = 'auto'; }
                if (secLbl)  { secLbl.style.opacity  = '1'; secLbl.style.maxWidth = '200px'; }
            }

            function toggleSidebar() {
                const sidebar = document.getElementById('main-sidebar');
                const overlay = document.getElementById('sidebarOverlay');
                const main    = document.getElementById('mainContent');
                const footer  = document.getElementById('sidebarFooter');
                if (!sidebar || !main) return;

                if (isMobile()) {
                    const isHidden = sidebar.classList.contains('-translate-x-full');
                    sidebar.classList.toggle('-translate-x-full', !isHidden);
                    if (overlay) overlay.classList.toggle('hidden', !isHidden);
                    if (footer) footer.style.display = isHidden ? '' : 'none';
                    return;
                }

                // Desktop collapse
                const collapsed = localStorage.getItem(STORAGE_KEY) === '1';
                localStorage.setItem(STORAGE_KEY, collapsed ? '0' : '1');
                applyDesktopState();
            }

            function handleResize() {
                if (isMobile()) {
                    applyMobileState();
                } else {
                    const sidebar = document.getElementById('main-sidebar');
                    if (sidebar) sidebar.classList.remove('-translate-x-full');
                    applyDesktopState();
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                const btn     = document.getElementById('sidebarToggle');
                const overlay = document.getElementById('sidebarOverlay');

                if (btn)     btn.addEventListener('click', toggleSidebar);
                if (overlay) overlay.addEventListener('click', toggleSidebar);

                // State awal
                if (isMobile()) {
                    applyMobileState();
                } else {
                    const sidebar = document.getElementById('main-sidebar');
                    if (sidebar) sidebar.classList.remove('-translate-x-full');
                    applyDesktopState();
                }

                window.addEventListener('resize', handleResize);
            });

            // ESC tutup mobile sidebar
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && isMobile()) {
                    const sidebar = document.getElementById('main-sidebar');
                    const overlay = document.getElementById('sidebarOverlay');
                    if (sidebar) sidebar.classList.add('-translate-x-full');
                    if (overlay) overlay.classList.add('hidden');
                }
            });
        })();

        // ── Dark Mode ─────────────────────────────────────────────────
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

            if (btn) {
                btn.addEventListener('click', function () {
                    const isDark = document.documentElement.classList.toggle('dark');
                    localStorage.setItem('darkMode', isDark);
                    applyDark(isDark);
                });
            }
        });

        // ── Load User ─────────────────────────────────────────────────
        async function loadUser() {
            try {
                const res = await fetch('/api/auth/me', {
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF() }
                });
                if (!res.ok) { window.location.href = '/login'; return; }
                const data = await res.json();
                const name = data.user?.name || data.name || 'Supplier';
                ['userNameSidebar', 'topUserName'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.textContent = name;
                });
            } catch (e) {}
        }

        // ── Logout ────────────────────────────────────────────────────
        async function doLogout() {
            try {
                await fetch('/api/logout', {
                    method: 'POST',
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF() }
                });
            } catch (e) {}
            window.location.href = '/login';
        }

        // ── Init ──────────────────────────────────────────────────────
        document.addEventListener('DOMContentLoaded', function () {
            loadUser();
        });
    </script>

    @stack('scripts')
</body>

</html>