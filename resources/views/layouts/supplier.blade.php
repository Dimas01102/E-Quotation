{{-- resources/views/layouts/supplier.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Supplier') - E-Quotation</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        /*
         * Satu-satunya custom CSS: label transition di sidebar.
         * Tidak bisa murni Tailwind karena butuh max-width transition.
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

<body class="bg-gray-900 text-white antialiased">

    <div class="flex min-h-screen">

        {{-- ── Mobile backdrop ─── --}}
        <div id="mob-backdrop" onclick="Sb.closeMobile()"
            class="fixed inset-0 z-40 hidden bg-black bg-opacity-60 xl:hidden"></div>

        {{-- ══════════════════════════════
         SIDEBAR DESKTOP (in flex row)
    ══════════════════════════════ --}}
        <aside id="main-sidebar"
            class="sb-expanded
                  flex-shrink-0 hidden xl:flex flex-col
                  bg-gray-800 border-r border-gray-700
                  px-3 overflow-hidden
                  transition-all duration-300 ease-in-out
                  w-64">

            {{-- Logo --}}
            <div class="flex h-16 flex-shrink-0 items-center gap-3 px-1">
                <a href="/supplier/dashboard" class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-shopping-cart text-white text-sm"></i>
                    </div>
                    <div class="sb-label leading-tight">
                        <p class="text-white font-bold text-sm">E-Quotation</p>
                        <p class="text-gray-500 text-xs">Supplier Portal</p>
                    </div>
                </a>
            </div>

            {{-- Nav --}}
            <nav class="flex flex-1 flex-col gap-0.5 overflow-y-auto overflow-x-hidden py-3">
                @php
                    $seg = request()->segment(2) ?? '';
                    $active =
                        'flex items-center gap-3 rounded-xl bg-blue-900 bg-opacity-20 px-3 py-2.5 text-sm font-semibold text-blue-400';
                    $normal =
                        'flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-gray-400 transition-colors hover:bg-gray-700 hover:text-white';
                    $ni = fn(bool $on) => $on ? $active : $normal;
                @endphp

                <p class="sb-label mt-1 mb-1 px-3 text-xs font-bold uppercase tracking-widest text-gray-500">Menu</p>

                <a href="/supplier/dashboard" class="{{ $ni($seg === 'dashboard') }}" title="Dashboard">
                    <i class="fas fa-home w-5 text-center flex-shrink-0"></i>
                    <span class="sb-label">Dashboard</span>
                </a>
                <a href="/supplier/rfq" class="{{ $ni($seg === 'rfq') }}" title="RFQ & Undangan">
                    <i class="fas fa-file-invoice w-5 text-center flex-shrink-0"></i>
                    <span class="sb-label">RFQ &amp; Undangan</span>
                </a>
                <a href="/supplier/quotations" class="{{ $ni($seg === 'quotations') }}" title="Penawaran Saya">
                    <i class="fas fa-paper-plane w-5 text-center flex-shrink-0"></i>
                    <span class="sb-label">Penawaran Saya</span>
                </a>
                <a href="/supplier/profile" class="{{ $ni($seg === 'profile') }}" title="Profil Perusahaan">
                    <i class="fas fa-building w-5 text-center flex-shrink-0"></i>
                    <span class="sb-label">Profil Perusahaan</span>
                </a>

                {{-- User info + logout --}}
                <div class="mt-auto border-t border-gray-700 pt-3">
                    <div class="flex items-center gap-3 px-3 mb-2 overflow-hidden">
                        <div class="w-8 h-8 bg-green-900 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-user text-green-400 text-xs"></i>
                        </div>
                        <div class="sb-label min-w-0">
                            <p id="userNameSidebar" class="text-white text-xs font-medium truncate">-</p>
                            <p class="text-gray-500 text-xs">Supplier</p>
                        </div>
                    </div>
                    <button onclick="doLogout()" title="Logout"
                        class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium
                           text-red-400 transition-colors hover:bg-red-900 hover:bg-opacity-20 hover:text-red-300">
                        <i class="fas fa-sign-out-alt w-5 text-center flex-shrink-0"></i>
                        <span class="sb-label">Logout</span>
                    </button>
                </div>
            </nav>
        </aside>

        {{-- ══════════════════════════════
         PAGE AREA
    ══════════════════════════════ --}}
        <div class="flex flex-1 flex-col min-w-0">

            {{-- TOPBAR --}}
            <header
                class="sticky top-0 z-30 flex h-14 items-center justify-between
                       border-b border-gray-700 bg-gray-800 bg-opacity-80 backdrop-blur-sm px-4 xl:px-5">

                <div class="flex items-center gap-3">
                    {{-- Desktop toggle --}}
                    <button onclick="Sb.toggleDesktop()" title="Toggle Sidebar"
                        class="hidden xl:flex h-9 w-9 items-center justify-center rounded-lg
                           border border-gray-700 text-gray-400
                           hover:bg-gray-700 hover:text-white transition-colors">
                        <i class="fas fa-bars text-sm"></i>
                    </button>
                    {{-- Mobile hamburger --}}
                    <button onclick="Sb.toggleMobile()" title="Menu"
                        class="flex xl:hidden h-9 w-9 items-center justify-center rounded-lg
                           border border-gray-700 text-gray-400
                           hover:bg-gray-700 hover:text-white transition-colors">
                        <i class="fas fa-bars text-sm"></i>
                    </button>

                    <p class="text-white font-medium text-sm">@yield('title', 'Dashboard')</p>
                </div>

                <span id="topUserName" class="text-gray-400 text-xs hidden md:block">-</span>
            </header>

            {{-- CONTENT --}}
            <main class="flex-1 p-4 md:p-6">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- ══════════════════════════════
     MOBILE SIDEBAR (fixed overlay)
══════════════════════════════ --}}
    <aside id="mob-sidebar"
        class="fixed inset-y-0 left-0 z-50 hidden w-64 flex-col
              bg-gray-800 border-r border-gray-700 px-3 overflow-hidden xl:hidden">

        <div class="flex h-16 flex-shrink-0 items-center gap-3 px-1">
            <a href="/supplier/dashboard" class="flex items-center gap-3">
                <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-shopping-cart text-white text-sm"></i>
                </div>
                <div class="leading-tight">
                    <p class="text-white font-bold text-sm">E-Quotation</p>
                    <p class="text-gray-500 text-xs">Supplier Portal</p>
                </div>
            </a>
        </div>

        <nav class="flex flex-1 flex-col gap-0.5 overflow-y-auto py-3">
            @php $seg2 = request()->segment(2) ?? ''; @endphp

            <p class="mt-1 mb-1 px-3 text-xs font-bold uppercase tracking-widest text-gray-500">Menu</p>

            <a href="/supplier/dashboard" onclick="Sb.closeMobile()" class="{{ $ni($seg2 === 'dashboard') }}">
                <i class="fas fa-home w-5 text-center flex-shrink-0"></i><span>Dashboard</span>
            </a>
            <a href="/supplier/rfq" onclick="Sb.closeMobile()" class="{{ $ni($seg2 === 'rfq') }}">
                <i class="fas fa-file-invoice w-5 text-center flex-shrink-0"></i><span>RFQ &amp; Undangan</span>
            </a>
            <a href="/supplier/quotations" onclick="Sb.closeMobile()" class="{{ $ni($seg2 === 'quotations') }}">
                <i class="fas fa-paper-plane w-5 text-center flex-shrink-0"></i><span>Penawaran Saya</span>
            </a>
            <a href="/supplier/profile" onclick="Sb.closeMobile()" class="{{ $ni($seg2 === 'profile') }}">
                <i class="fas fa-building w-5 text-center flex-shrink-0"></i><span>Profil Perusahaan</span>
            </a>

            <div class="mt-auto border-t border-gray-700 pt-3">
                <div class="flex items-center gap-3 px-3 mb-2">
                    <div class="w-8 h-8 bg-green-900 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-user text-green-400 text-xs"></i>
                    </div>
                    <div class="min-w-0">
                        <p id="mobUserName" class="text-white text-xs font-medium truncate">-</p>
                        <p class="text-gray-500 text-xs">Supplier</p>
                    </div>
                </div>
                <button onclick="doLogout()"
                    class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium
                       text-red-400 transition-colors hover:bg-red-900 hover:bg-opacity-20 hover:text-red-300">
                    <i class="fas fa-sign-out-alt w-5 text-center flex-shrink-0"></i>
                    <span>Logout</span>
                </button>
            </div>
        </nav>
    </aside>

    <script>
        /* ─── SIDEBAR ─────────────────────────────────────── */
        const Sb = {
            get isCollapsed() {
                return localStorage.getItem('sb_supplier_collapsed') === '1';
            },

            init() {
                const sb = document.getElementById('main-sidebar');
                if (!sb) return;
                if (this.isCollapsed) {
                    sb.classList.remove('w-64', 'sb-expanded');
                    sb.classList.add('w-16', 'sb-collapsed');
                } else {
                    sb.classList.remove('w-16', 'sb-collapsed');
                    sb.classList.add('w-64', 'sb-expanded');
                }
            },

            toggleDesktop() {
                const sb = document.getElementById('main-sidebar');
                if (!sb) return;
                const collapsed = sb.classList.contains('sb-collapsed');
                if (collapsed) {
                    sb.classList.remove('w-16', 'sb-collapsed');
                    sb.classList.add('w-64', 'sb-expanded');
                    localStorage.setItem('sb_supplier_collapsed', '0');
                } else {
                    sb.classList.remove('w-64', 'sb-expanded');
                    sb.classList.add('w-16', 'sb-collapsed');
                    localStorage.setItem('sb_supplier_collapsed', '1');
                }
            },

            toggleMobile() {
                const mob = document.getElementById('mob-sidebar');
                const bd = document.getElementById('mob-backdrop');
                const open = !mob.classList.contains('hidden');
                if (open) {
                    mob.classList.add('hidden');
                    mob.classList.remove('flex');
                    bd.classList.add('hidden');
                    document.body.style.overflow = '';
                } else {
                    mob.classList.remove('hidden');
                    mob.classList.add('flex');
                    bd.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                }
            },

            closeMobile() {
                const mob = document.getElementById('mob-sidebar');
                const bd = document.getElementById('mob-backdrop');
                if (mob) {
                    mob.classList.add('hidden');
                    mob.classList.remove('flex');
                }
                if (bd) {
                    bd.classList.add('hidden');
                }
                document.body.style.overflow = '';
            }
        };

        /* ─── LOGOUT ──────────────────────────────────────── */
        async function doLogout() {
            try {
                await fetch('/api/logout', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    }
                });
            } catch (e) {}
            window.location.href = '/login';
        }

        /* ─── LOAD USER ───────────────────────────────────── */
        async function loadUser() {
            try {
                const res = await fetch('/api/auth/me', {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                if (!res.ok) {
                    window.location.href = '/login';
                    return;
                }
                const data = await res.json();
                const name = data.user?.name || data.name || 'Supplier';
                ['userNameSidebar', 'topUserName', 'mobUserName'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.textContent = name;
                });
            } catch (e) {}
        }

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
