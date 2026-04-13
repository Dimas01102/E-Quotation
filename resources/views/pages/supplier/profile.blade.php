@extends('layouts.supplier')
@section('page-title', 'Profil Perusahaan')

@section('content')
    <div class="p-6 max-w-3xl">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-xl font-bold text-gray-800 dark:text-white">Profil Perusahaan</h1>
                <p class="text-sm text-gray-500 mt-0.5">Kelola informasi akun dan perusahaan Anda</p>
            </div>
            <button id="btnEditToggle" onclick="toggleEdit()"
                class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Profil
            </button>
        </div>

        <div id="alertBox" class="hidden mb-5 p-4 rounded-xl text-sm"></div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            <!-- Kartu Info -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6">
                <div class="text-center">
                    <div
                        class="w-16 h-16 bg-blue-100 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <p id="sideCompany" class="font-bold text-gray-800 dark:text-white">—</p>
                    <p id="sideName" class="text-gray-500 text-sm mt-1">—</p>
                    <p id="sideEmail" class="text-gray-400 text-xs mt-0.5">—</p>
                    <div id="sideStatus" class="mt-3"></div>
                </div>
                <div class="mt-5 pt-5 border-t border-gray-100 dark:border-gray-800 space-y-2 text-sm">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span id="sidePhone" class="text-gray-600 dark:text-gray-400">—</span>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span id="sideAddress" class="text-gray-600 dark:text-gray-400">—</span>
                    </div>
                </div>
            </div>

            <!-- Detail / Form -->
            <div class="lg:col-span-2">
                <!-- View Mode -->
                <div id="viewMode"
                    class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6">
                    <h3 class="font-semibold text-gray-800 dark:text-white mb-5">Informasi Detail</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-xs text-gray-400 mb-1">Nama PIC</p>
                            <p id="vName" class="font-medium text-gray-800 dark:text-white">—</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 mb-1">Email</p>
                            <p id="vEmail" class="text-gray-700 dark:text-gray-300">—</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-xs text-gray-400 mb-1">Nama Perusahaan</p>
                            <p id="vCompany" class="font-semibold text-gray-800 dark:text-white">—</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 mb-1">Telepon</p>
                            <p id="vPhone" class="text-gray-700 dark:text-gray-300">—</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 mb-1">NPWP</p>
                            <p id="vNpwp" class="text-gray-700 dark:text-gray-300">—</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-xs text-gray-400 mb-1">Alamat</p>
                            <p id="vAddress" class="text-gray-700 dark:text-gray-300">—</p>
                        </div>
                    </div>
                </div>

                <!-- Edit Mode -->
                <div id="editMode"
                    class="hidden bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6">
                    <h3 class="font-semibold text-gray-800 dark:text-white mb-5">Edit Informasi</h3>
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">Nama
                                    PIC</label>
                                <input id="fName" type="text"
                                    class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 dark:text-white">
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">Telepon</label>
                                <input id="fPhone" type="text"
                                    class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 dark:text-white">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">Nama
                                Perusahaan</label>
                            <input id="fCompany" type="text"
                                class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">NPWP</label>
                            <input id="fNpwp" type="text"
                                class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">Alamat</label>
                            <textarea id="fAddress" rows="2"
                                class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 dark:text-white resize-none"></textarea>
                        </div>

                        <!-- Password section -->
                        <div class="border-t border-gray-100 dark:border-gray-800 pt-4">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Ubah Password</p>
                            <p class="text-xs text-gray-400 mb-3">Kosongkan jika tidak ingin mengubah password.</p>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">Password
                                    Baru</label>
                                <input id="fPassword" type="password" placeholder="Min. 8 karakter"
                                    class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 dark:text-white">
                            </div>
                        </div>

                        <div class="flex gap-3 pt-2">
                            <button onclick="saveProfile()"
                                class="flex-1 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-medium transition-colors">
                                Simpan Perubahan
                            </button>
                            <button onclick="cancelEdit()"
                                class="flex-1 py-2.5 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-xl text-sm transition-colors">
                                Batal
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ✅ FIX 401: Ambil CSRF dari meta tag, BUKAN di-hardcode
        // Setiap request AJAX harus menyertakan header X-CSRF-TOKEN yang fresh
        const getCsrf = () => document.querySelector('meta[name="csrf-token"]')?.content || '';

        let profileData = null;
        let isEditing = false;

        async function loadProfile() {
            try {
                const res = await fetch('/api/supplier/profile', {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': getCsrf()
                    }
                });

                // ✅ FIX: jika 401, redirect ke login
                if (res.status === 401) {
                    window.location.href = '/login';
                    return;
                }
                if (!res.ok) throw new Error('HTTP ' + res.status);

                profileData = await res.json();
                renderProfile(profileData);
            } catch (e) {
                showAlert('Gagal memuat profil: ' + e.message, 'error');
            }
        }

        function renderProfile(data) {
            const supplier = data.supplier || {};
            const user = data.user || {};
            const isActive = Number(data.is_active ?? user.is_active ?? 0);

            // Sidebar
            document.getElementById('sideCompany').textContent = supplier.company_name || '—';
            document.getElementById('sideName').textContent = user.name || '—';
            document.getElementById('sideEmail').textContent = user.email || '—';
            document.getElementById('sidePhone').textContent = supplier.phone || '—';
            document.getElementById('sideAddress').textContent = supplier.address || '—';

            // Status badge
            document.getElementById('sideStatus').innerHTML = isActive === 1 ?
                `<span class="px-3 py-1 bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-full text-xs font-medium">✓ Aktif</span>` :
                `<span class="px-3 py-1 bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 rounded-full text-xs font-medium">Menunggu Aktivasi</span>`;

            // View mode
            document.getElementById('vName').textContent = user.name || '—';
            document.getElementById('vEmail').textContent = user.email || '—';
            document.getElementById('vCompany').textContent = supplier.company_name || '—';
            document.getElementById('vPhone').textContent = supplier.phone || '—';
            document.getElementById('vNpwp').textContent = supplier.npwp || '—';
            document.getElementById('vAddress').textContent = supplier.address || '—';

            // Pre-fill form
            document.getElementById('fName').value = user.name || '';
            document.getElementById('fPhone').value = supplier.phone || '';
            document.getElementById('fCompany').value = supplier.company_name || '';
            document.getElementById('fNpwp').value = supplier.npwp || '';
            document.getElementById('fAddress').value = supplier.address || '';
            document.getElementById('fPassword').value = '';
        }

        function toggleEdit() {
            isEditing = !isEditing;
            document.getElementById('viewMode').classList.toggle('hidden', isEditing);
            document.getElementById('editMode').classList.toggle('hidden', !isEditing);

            const btn = document.getElementById('btnEditToggle');
            if (isEditing) {
                btn.innerHTML =
                    `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg> Batal`;
                btn.className =
                    'flex items-center gap-2 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-xl text-sm font-medium transition-colors';
            } else {
                btn.innerHTML =
                    `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg> Edit Profil`;
                btn.className =
                    'flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition-colors';
            }
        }

        function cancelEdit() {
            // Re-fill form dari data yang sudah ada
            if (profileData) renderProfile(profileData);
            isEditing = false;
            document.getElementById('viewMode').classList.remove('hidden');
            document.getElementById('editMode').classList.add('hidden');
            const btn = document.getElementById('btnEditToggle');
            btn.innerHTML =
                `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg> Edit Profil`;
            btn.className =
                'flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition-colors';
        }

        async function saveProfile() {
            const pw = document.getElementById('fPassword').value;

            const body = {
                name: document.getElementById('fName').value.trim(),
                company_name: document.getElementById('fCompany').value.trim(),
                phone: document.getElementById('fPhone').value.trim(),
                npwp: document.getElementById('fNpwp').value.trim(),
                address: document.getElementById('fAddress').value.trim(),
            };

            if (pw) {
                if (pw.length < 8) {
                    showAlert('Password minimal 8 karakter.', 'error');
                    return;
                }
                body.password = pw;
            }

            if (!body.name || !body.company_name || !body.phone) {
                showAlert('Nama, nama perusahaan, dan telepon wajib diisi.', 'error');
                return;
            }

            try {
                // ✅ FIX 401: Selalu ambil CSRF token terbaru dari meta tag
                const res = await fetch('/api/supplier/profile', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': getCsrf(), // ← SELALU fresh dari meta tag
                    },
                    body: JSON.stringify(body)
                });

                // ✅ FIX 401: Tangani khusus
                if (res.status === 401) {
                    showAlert('Sesi Anda telah berakhir. Silakan login kembali.', 'error');
                    setTimeout(() => window.location.href = '/login', 2000);
                    return;
                }

                const json = await res.json();

                if (!res.ok) {
                    const errMsg = json.errors ?
                        Object.values(json.errors).flat().join(' ') :
                        (json.message || 'Gagal menyimpan');
                    showAlert(errMsg, 'error');
                    return;
                }

                // ✅ Update local data tanpa reload halaman
                profileData = json;
                renderProfile(json);
                showAlert('Profil berhasil diperbarui!', 'success');

                // Kembali ke view mode
                isEditing = true; // agar toggleEdit akan matikan edit
                toggleEdit();

            } catch (e) {
                showAlert('Terjadi kesalahan koneksi. Coba lagi.', 'error');
            }
        }

        function showAlert(msg, type) {
            const box = document.getElementById('alertBox');
            box.className = `mb-5 p-4 rounded-xl text-sm ${
        type === 'success'
            ? 'bg-green-50 text-green-700 border border-green-200 dark:bg-green-900/20 dark:text-green-400 dark:border-green-800'
            : 'bg-red-50 text-red-700 border border-red-200 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800'
    }`;
            box.textContent = msg;
            box.classList.remove('hidden');
            setTimeout(() => box.classList.add('hidden'), 5000);
        }

        loadProfile();
    </script>
@endsection
