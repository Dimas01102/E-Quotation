
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
                        <svg id="iconMoon" class="w-4 h-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <svg id="iconSun" class="w-4 h-4 hidden" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
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
                                class="w-7 h-7 rounded-lg bg-green-600 flex items-center justify-center
                                       text-white text-xs font-bold flex-shrink-0">
                                A
                            </div>
                            <span id="userName"
                                class="text-sm font-medium text-gray-700 dark:text-gray-300
                                       hidden sm:block max-w-[120px] truncate">
                                Admin
                            </span>
                            <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
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