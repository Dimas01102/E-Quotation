<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page-title', 'Admin') - E-Quotation</title>
    <link rel="icon" type="image/png" href="/assets/images/logo.jpg">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class'
        };
    </script>
</head>

<body class="bg-gray-50 dark:bg-gray-950 min-h-screen">

    <div class="flex min-h-screen">

        {{--  Sidebar --}}
        <x-sidebar type="admin" />

        {{-- Overlay untuk mobile --}}

        <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden"></div>


        {{--  Main Content --}}
        <div id="mainContent" class="flex-1 flex flex-col min-w-0 ml-0 md:ml-64 transition-all duration-300">

            {{-- Top Bar --}}
            <x-top-header-admin />

            {{-- Overlay untuk mobile --}}


            {{-- Page Content --}}
            <main class="flex-1 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>

    {{--  Edit Profile Modal --}}
    <x-profile-modal-admin />

    {{--  Footer --}}

    {{--  GLOBAL JS --}}
    <script>
        // GLOBAL HELPERS

        window.CSRF = function() {
            return document.querySelector('meta[name="csrf-token"]')?.content || '';
        };
        window.getCSRF = window.CSRF;

        window.fmtDate = function(d) {
            if (!d) return '—';
            return new Date(d).toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            });
        };

        window.fmtRp = function(n) {
            if (n == null || n === '') return '—';
            return 'Rp ' + parseInt(n).toLocaleString('id-ID');
        };

        window.capitalize = function(str) {
            if (!str) return '—';
            return str.charAt(0).toUpperCase() + str.slice(1);
        };

        window.statusBadge = window.badge = function(s) {
            const m = {
                open: 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                draft: 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400',
                closed: 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400',
                pending: 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                approved: 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                rejected: 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400',
                invited: 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                submitted: 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                winner: 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
            };
            return '<span class="px-2.5 py-1 rounded-full text-xs font-medium ' +
                (m[s] || 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400') +
                '">' + window.capitalize(s) + '</span>';
        };

        window.toast = function(msg, type) {
            const t = document.createElement('div');
            const bg = type === 'error' ? 'bg-red-600' : type === 'info' ? 'bg-blue-600' : 'bg-green-600';
            t.className = 'fixed bottom-5 right-5 px-5 py-3 rounded-xl text-white text-sm z-[9999] shadow-xl ' + bg;
            t.textContent = msg;
            document.body.appendChild(t);
            setTimeout(() => t.remove(), 3500);
        };

        window.showModal = function(id) {
            const el = document.getElementById(id);
            if (!el) return;
            el.style.display = 'flex';
        };
        window.hideModal = function(id) {
            const el = document.getElementById(id);
            if (el) el.style.display = 'none';
        };

        // SIDEBAR COLLAPSE (icon-only expanded)
        (function() {
            const STORAGE_KEY = 'sb_admin_collapsed';

            function isMobile() {
                return window.innerWidth < 768;
            }

            // Terapkan state yang benar sesuai kondisi viewport saat ini
            function applyDesktopState() {
                const sidebar = document.getElementById('sidebar');
                const main = document.getElementById('mainContent');
                const footer = document.getElementById('sidebarFooter');
                if (!sidebar || !main) return;

                const collapsed = localStorage.getItem(STORAGE_KEY) === '1';

                if (collapsed) {
                    sidebar.style.width = '4rem';
                    main.classList.remove('md:ml-64');
                    main.classList.add('md:ml-16');
                    if (footer) footer.style.display = 'none'; // sembunyikan
                } else {
                    sidebar.style.width = '16rem';
                    main.classList.remove('md:ml-16');
                    main.classList.add('md:ml-64');
                    if (footer) footer.style.display = ''; // tampilkan
                }
            }

            function applyMobileState() {
                const sidebar = document.getElementById('sidebar');
                const main = document.getElementById('mainContent');
                const overlay = document.getElementById('sidebarOverlay');
                const footer = document.getElementById('sidebarFooter');
                if (!sidebar || !main) return;

                sidebar.style.width = '';
                sidebar.classList.add('-translate-x-full');
                if (overlay) overlay.classList.add('hidden');
                main.classList.remove('md:ml-64', 'md:ml-16');
                if (footer) footer.style.display = 'none'; // sembunyikan di mobile
            }

            // Reset semua inline style dan class saat di-mobile
            function applyMobileState() {
                const sidebar = document.getElementById('sidebar');
                const main = document.getElementById('mainContent');
                const overlay = document.getElementById('sidebarOverlay');
                if (!sidebar || !main) return;

                // Hapus width inline yang di-set oleh desktop logic
                sidebar.style.width = '';

                // Pastikan sidebar tersembunyi (mobile default: off-screen)
                sidebar.classList.add('-translate-x-full');
                if (overlay) overlay.classList.add('hidden');

                // Reset margin main content ke default mobile (tanpa ml)
                main.classList.remove('md:ml-64', 'md:ml-16');
            }

            function toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebarOverlay');
                const main = document.getElementById('mainContent');
                const footer = document.getElementById('sidebarFooter');
                if (!sidebar || !main) return;

                if (isMobile()) {
                    const isHidden = sidebar.classList.contains('-translate-x-full');
                    sidebar.classList.toggle('-translate-x-full', !isHidden);
                    if (overlay) overlay.classList.toggle('hidden', !isHidden);
                    if (footer) footer.style.display = isHidden ? '' : 'none'; // toggle footer
                    return;
                }

                const collapsed = localStorage.getItem(STORAGE_KEY) === '1';
                localStorage.setItem(STORAGE_KEY, collapsed ? '0' : '1');
                applyDesktopState();
            }

            // Saat resize antar breakpoint, terapkan ulang state yang sesuai
            function handleResize() {
                if (isMobile()) {
                    applyMobileState();
                } else {
                    // Desktop: pastikan sidebar tidak tertahan di -translate-x-full dari mobile
                    const sidebar = document.getElementById('sidebar');
                    if (sidebar) sidebar.classList.remove('-translate-x-full');
                    applyDesktopState();
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                const btn = document.getElementById('sidebarToggle');
                const overlay = document.getElementById('sidebarOverlay');

                if (btn) btn.addEventListener('click', toggleSidebar);
                if (overlay) overlay.addEventListener('click', toggleSidebar);

                // Terapkan state awal
                if (isMobile()) {
                    applyMobileState();
                } else {
                    const sidebar = document.getElementById('sidebar');
                    if (sidebar) sidebar.classList.remove('-translate-x-full');
                    applyDesktopState();
                }

                // perubahan ukuran window
                window.addEventListener('resize', handleResize);
            });
        })();

        // Dark Mode
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('darkToggle');
            const moon = document.getElementById('iconMoon');
            const sun = document.getElementById('iconSun');

            function applyDark(isDark) {
                document.documentElement.classList.toggle('dark', isDark);
                if (moon) moon.classList.toggle('hidden', isDark);
                if (sun) sun.classList.toggle('hidden', !isDark);
            }

            applyDark(localStorage.getItem('darkMode') === 'true');

            if (btn) btn.addEventListener('click', function() {
                const isDark = document.documentElement.classList.toggle('dark');
                localStorage.setItem('darkMode', isDark);
                applyDark(isDark);
            });
        });

        // Active Nav Link
        document.addEventListener('DOMContentLoaded', function() {
            const path = window.location.pathname;
            const links = document.querySelectorAll('.nav-link');
            links.forEach(function(a) {
                const p = a.getAttribute('data-path');
                if (p && path.includes(p)) {
                    a.classList.add(
                        'bg-green-50',
                        'dark:bg-green-900/30',
                        'text-green-700',
                        'dark:text-green-400'
                    );
                    a.classList.remove('text-gray-600', 'dark:text-gray-400');
                }
            });
        });

        // User Dropdown + load user info
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('userMenuBtn');
            const dropdown = document.getElementById('userDropdown');
            if (!btn || !dropdown) return;

            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const vis = dropdown.style.display !== 'none' && dropdown.style.display !== '';
                dropdown.style.display = vis ? 'none' : 'block';
            });

            document.addEventListener('click', function(e) {
                if (!document.getElementById('userMenuWrapper')?.contains(e.target)) {
                    dropdown.style.display = 'none';
                }
            });

            fetch('/api/auth/me', {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF()
                    }
                })
                .then(r => r.ok ? r.json() : null)
                .then(res => {
                    if (!res) return;
                    const data = res.data || res;
                    const name = data.name || 'Admin';
                    const email = data.email || '';
                    const avatar = name.charAt(0).toUpperCase();
                    const set = (id, val) => {
                        const el = document.getElementById(id);
                        if (el) el.textContent = val;
                    };
                    set('userName', name);
                    set('userAvatar', avatar);
                    set('dropdownName', name);
                    set('dropdownEmail', email);
                })
                .catch(() => {});
        });

        // Logout 
        window.doLogout = async function() {
            try {
                await fetch('/api/logout', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': CSRF(),
                        'Accept': 'application/json'
                    }
                });
            } catch (e) {}
            window.location.href = '/login';
        };

        // Edit Profile Modal 
        window.openProfileModal = function() {
            document.getElementById('userDropdown').style.display = 'none';

            fetch('/api/auth/me', {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF()
                    }
                })
                .then(r => r.ok ? r.json() : {})
                .then(res => {
                    const data = res.data || res;
                    document.getElementById('profileName').value = data.name || '';
                    document.getElementById('profileEmail').value = data.email || '';
                    document.getElementById('profilePassword').value = '';
                    document.getElementById('profilePasswordConfirm').value = '';
                    document.getElementById('profileAlert').classList.add('hidden');
                });

            document.getElementById('profileModal').style.display = 'flex';
        };

        window.closeProfileModal = function() {
            document.getElementById('profileModal').style.display = 'none';
        };

        window.saveProfile = async function() {
            const name = document.getElementById('profileName').value.trim();
            const pw = document.getElementById('profilePassword').value;
            const pwConf = document.getElementById('profilePasswordConfirm').value;
            const alertEl = document.getElementById('profileAlert');

            function showAlert(msg, ok) {
                alertEl.className = 'p-3 rounded-xl text-sm ' + (ok ?
                    'bg-green-50 text-green-700 border border-green-200 dark:bg-green-900/20 dark:text-green-400' :
                    'bg-red-50 text-red-700 border border-red-200 dark:bg-red-900/20 dark:text-red-400');
                alertEl.textContent = msg;
                alertEl.classList.remove('hidden');
            }

            if (!name) {
                showAlert('Nama wajib diisi.');
                return;
            }
            if (pw && pw.length < 8) {
                showAlert('Password minimal 8 karakter.');
                return;
            }
            if (pw && pw !== pwConf) {
                showAlert('Konfirmasi password tidak cocok.');
                return;
            }

            const body = {
                name
            };
            if (pw) {
                body.password = pw;
                body.password_confirmation = pwConf;
            }

            try {
                const res = await fetch('/api/admin/profile', {
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
                    // Jika password ikut diubah, otomatis logout 
                    if (pw) {
                        showAlert('Password berhasil diubah. Anda akan logout...', true);
                        setTimeout(doLogout, 1500);
                        return;
                    }

                    showAlert('Profil berhasil diperbarui!', true);
                    const set = (id, val) => {
                        const el = document.getElementById(id);
                        if (el) el.textContent = val;
                    };
                    set('userName', name);
                    set('userAvatar', name.charAt(0).toUpperCase());
                    set('dropdownName', name);
                    setTimeout(closeProfileModal, 1500);
                } else {
                    const msg = json.errors ?
                        Object.values(json.errors).flat().join(' ') :
                        (json.message || 'Gagal menyimpan.');
                    showAlert(msg);
                }
            } catch (e) {
                showAlert('Terjadi kesalahan koneksi.');
            }
        };

        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('profileModal');
            if (modal) modal.addEventListener('click', function(e) {
                if (e.target === modal) closeProfileModal();
            });
        });
    </script>

    @stack('scripts')
</body>

</html>