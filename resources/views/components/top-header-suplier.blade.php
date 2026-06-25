            <header class="sticky top-0 z-30 flex h-16 items-center gap-3 px-5
                           bg-white dark:bg-gray-900
                           border-b border-gray-200 dark:border-gray-800">

                {{-- Hamburger / Toggle--}}
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

                    {{-- User info --}}
                    <div class="flex items-center gap-2 px-3 py-1.5 rounded-xl
                                hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <div class="w-7 h-7 rounded-lg bg-green-600 flex items-center justify-center
                                    text-white text-xs font-bold flex-shrink-0">
                            S
                        </div>
                        <span id="topUserName"
                              class="text-sm font-medium text-gray-700 dark:text-gray-300
                                     hidden sm:block max-w-[120px] truncate">—</span>
                    </div>

                </div>
            </header>