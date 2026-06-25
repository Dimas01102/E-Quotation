@php
    $type       = $type ?? 'admin';     
    $isAdmin    = $type === 'admin';
    $isSupplier = $type === 'supplier';


    $accent        = $isAdmin ? 'blue'  : 'green';
    $storageKey    = $isAdmin ? 'sb_admin_collapsed' : 'sb_supplier_collapsed';
    $basePath      = $isAdmin ? '/admin' : '/supplier';
    $sidebarId     = $isAdmin ? 'sidebar' : 'main-sidebar';


    $seg    = request()->segment(2) ?? '';
    $active = "nav-link flex items-center gap-3 rounded-xl bg-{$accent}-50 dark:bg-{$accent}-900/20 px-3 py-2.5 text-sm font-semibold text-{$accent}-700 dark:text-{$accent}-400";
    $normal = "nav-link flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-400 transition-colors hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white";
    $ni     = fn(bool $on) => $on ? $active : $normal;
@endphp

{{-- ── Overlay (mobile) ──────────────────────────────────────────── --}}
<div id="sidebarOverlay"
     class="fixed inset-0 bg-black/50 z-40 hidden md:hidden"></div>

{{-- ══════════════════════════════════════════════════════════════════
     SIDEBAR
══════════════════════════════════════════════════════════════════ --}}
<aside id="{{ $sidebarId }}"
    class="fixed inset-y-0 left-0 z-50 flex flex-col
           bg-white dark:bg-gray-900
           {{ $isAdmin ? '' : 'border-r border-gray-200 dark:border-gray-800' }}
           px-3 overflow-hidden
           transform -translate-x-full md:translate-x-0
           transition-all duration-300"
    style="width: 16rem;">

    {{-- ── Logo ──────────────────────────────────────────────────────── --}}
    <div class="flex h-16 flex-shrink-0 items-center gap-3 px-1
                border-b border-gray-100 dark:border-gray-800">

        @if ($isAdmin)
            {{-- Admin Logo --}}
            <img id="sidebarLogo" src="/assets/images/logo.jpg" alt="Logo"
                class="w-8 h-8 rounded-xl object-cover flex-shrink-0"
                onerror="this.style.display='none'; document.getElementById('sidebarLogoFallback').style.display='flex';">

            <div id="sidebarLogoLabel"
                 class="flex items-center gap-2 min-w-0 overflow-hidden"
                 style="transition: opacity 0.2s ease, width 0.25s ease;">
                <span class="font-bold text-gray-800 dark:text-white text-sm whitespace-nowrap">Dashboard</span>
                <span class="text-xs font-semibold px-2 py-0.5 bg-blue-100 text-blue-700
                             dark:bg-blue-900/30 dark:text-blue-400 rounded-full whitespace-nowrap flex-shrink-0">
                    Admin
                </span>
            </div>

        @else
            {{-- Supplier Logo --}}
            <a href="/supplier/dashboard" class="flex items-center gap-3 min-w-0">
                <div class="w-9 h-9 bg-green-600 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-shopping-cart text-white text-sm"></i>
                </div>
                <div id="sidebarLogoLabel"
                     class="leading-tight overflow-hidden"
                     style="transition: opacity 0.2s ease, width 0.3s ease; opacity: 1; width: auto;">
                    <p class="text-gray-800 dark:text-white font-bold text-sm whitespace-nowrap">E-Quotation</p>
                    <p class="text-gray-400 dark:text-gray-500 text-xs whitespace-nowrap">Supplier Portal</p>
                </div>
            </a>
        @endif

    </div>

    {{-- ── Nav ────────────────────────────────────────────────────────── --}}
    <nav class="flex flex-1 flex-col gap-0.5 overflow-y-auto overflow-x-hidden py-4" id="sidebarNav">

        @if ($isAdmin)
            {{-- ════ ADMIN NAV ════ --}}
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

        @else
            {{-- ════ SUPPLIER NAV ════ --}}
            <p id="navSectionLabel"
               class="mt-1 mb-1 px-3 text-xs font-bold uppercase tracking-widest
                      text-gray-400 dark:text-gray-500 whitespace-nowrap overflow-hidden"
               style="transition: opacity 0.2s ease, max-width 0.3s ease; max-width: 200px; opacity: 1;">
                Menu
            </p>

            <a href="/supplier/dashboard" class="{{ $ni($seg === 'dashboard') }}" title="Dashboard">
                <i class="fas fa-home w-5 text-center flex-shrink-0"></i>
                <span class="nav-label whitespace-nowrap overflow-hidden"
                      style="transition: opacity 0.2s ease, max-width 0.3s ease; max-width: 200px; opacity: 1;">
                    Dashboard
                </span>
            </a>

            <a href="/supplier/rfq" class="{{ $ni($seg === 'rfq') }}" title="RFQ & Undangan">
                <i class="fas fa-file-invoice w-5 text-center flex-shrink-0"></i>
                <span class="nav-label whitespace-nowrap overflow-hidden"
                      style="transition: opacity 0.2s ease, max-width 0.3s ease; max-width: 200px; opacity: 1;">
                    RFQ &amp; Undangan
                </span>
            </a>

            <a href="/supplier/quotations" class="{{ $ni($seg === 'quotations') }}" title="Penawaran Saya">
                <i class="fas fa-paper-plane w-5 text-center flex-shrink-0"></i>
                <span class="nav-label whitespace-nowrap overflow-hidden"
                      style="transition: opacity 0.2s ease, max-width 0.3s ease; max-width: 200px; opacity: 1;">
                    Penawaran Saya
                </span>
            </a>

            <a href="/supplier/profile" class="{{ $ni($seg === 'profile') }}" title="Profil Perusahaan">
                <i class="fas fa-building w-5 text-center flex-shrink-0"></i>
                <span class="nav-label whitespace-nowrap overflow-hidden"
                      style="transition: opacity 0.2s ease, max-width 0.3s ease; max-width: 200px; opacity: 1;">
                    Profil Perusahaan
                </span>
            </a>

            {{-- User info + logout (supplier only) --}}
            <div class="mt-auto border-t border-gray-100 dark:border-gray-800 pt-3">
                <div class="flex items-center gap-3 px-3 mb-2 overflow-hidden">
                    <div class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-lg
                                flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-user text-green-600 dark:text-green-400 text-xs"></i>
                    </div>
                    <div id="sidebarUserLabel"
                         class="min-w-0 overflow-hidden"
                         style="transition: opacity 0.2s ease, width 0.3s ease; opacity: 1; width: auto;">
                        <p id="userNameSidebar"
                           class="text-gray-800 dark:text-white text-xs font-medium truncate whitespace-nowrap">—</p>
                        <p class="text-gray-400 dark:text-gray-500 text-xs whitespace-nowrap">Supplier</p>
                    </div>
                </div>
                <button onclick="doLogout()" title="Logout"
                    class="nav-link flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium
                           text-red-500 dark:text-red-400 transition-colors
                           hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 dark:hover:text-red-300">
                    <i class="fas fa-sign-out-alt w-5 text-center flex-shrink-0"></i>
                    <span class="nav-label whitespace-nowrap overflow-hidden"
                          style="transition: opacity 0.2s ease, max-width 0.3s ease; max-width: 200px; opacity: 1;">
                        Logout
                    </span>
                </button>
            </div>

        @endif

    </nav>

    {{-- ── Footer ─────────────────────────────────────────────────────── --}}
    <div id="sidebarFooter"
         class="p-4 border-t border-gray-100 dark:border-gray-800 flex-shrink-0 overflow-hidden">
        <p id="sidebarFooterText"
           class="text-xs text-gray-400 text-center whitespace-nowrap overflow-hidden"
           style="transition: opacity 0.2s ease, max-width 0.3s ease; max-width: 200px; opacity: 1;">
            E-Quotation System
        </p>
    </div>

</aside>
