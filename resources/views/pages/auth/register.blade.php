<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Supplier - E-Quotation System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1e3a5f 0%, #0d1f3c 100%);
        }

        .glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        }

        .input-field {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: white;
        }

        .input-field::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .input-field:focus {
            outline: none;
            border-color: #3b82f6;
            background: rgba(255, 255, 255, 0.12);
        }

        .input-match {
            border-color: rgba(74, 222, 128, 0.6) !important;
        }

        .input-mismatch {
            border-color: rgba(248, 113, 113, 0.6) !important;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4 py-10">
    <div class="w-full max-w-xl">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-blue-600 mb-4">
                <i class="fas fa-building text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-white">Daftar Supplier</h1>
            <p class="text-blue-300 mt-1">E-Quotation Procurement System</p>
        </div>

        <div class="glass rounded-2xl p-8">
            <h2 class="text-xl font-semibold text-white mb-6">Informasi Akun & Perusahaan</h2>
            <div id="alertBox" class="hidden mb-4 p-4 rounded-xl text-sm"></div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Nama Lengkap -->
                <div class="md:col-span-2">
                    <label class="block text-sm text-blue-200 mb-2">Nama Lengkap <span
                            class="text-red-400">*</span></label>
                    <div class="relative">
                        <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-blue-400"></i>
                        <input type="text" id="name" placeholder="Nama PIC / Perwakilan"
                            class="input-field w-full pl-11 pr-4 py-3 rounded-xl text-sm">
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm text-blue-200 mb-2">Email <span class="text-red-400">*</span></label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-blue-400"></i>
                        <input type="email" id="email" placeholder="email@perusahaan.com"
                            class="input-field w-full pl-11 pr-4 py-3 rounded-xl text-sm">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm text-blue-200 mb-2">Password <span class="text-red-400">*</span></label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-blue-400"></i>
                        <input type="password" id="password" placeholder="Min. 8 karakter"
                            oninput="checkPasswordMatch()"
                            class="input-field w-full pl-11 pr-4 py-3 rounded-xl text-sm">
                    </div>
                </div>

                <!-- Konfirmasi Password -->
                <div class="md:col-span-2">
                    <label class="block text-sm text-blue-200 mb-2">Konfirmasi Password <span
                            class="text-red-400">*</span></label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-blue-400"></i>
                        <input type="password" id="password_confirm" placeholder="Ulangi password"
                            oninput="checkPasswordMatch()"
                            class="input-field w-full pl-11 pr-4 py-3 rounded-xl text-sm">
                    </div>
                    <p id="pw-match-msg" class="hidden text-xs mt-1.5 pl-1"></p>
                </div>

                <!-- Nama Perusahaan -->
                <div class="md:col-span-2">
                    <label class="block text-sm text-blue-200 mb-2">Nama Perusahaan <span
                            class="text-red-400">*</span></label>
                    <div class="relative">
                        <i class="fas fa-building absolute left-4 top-1/2 -translate-y-1/2 text-blue-400"></i>
                        <input type="text" id="company_name" placeholder="PT / CV / UD ..."
                            class="input-field w-full pl-11 pr-4 py-3 rounded-xl text-sm">
                    </div>
                </div>

                <!-- NPWP -->
                <div>
                    <label class="block text-sm text-blue-200 mb-2">NPWP</label>
                    <div class="relative">
                        <i class="fas fa-id-card absolute left-4 top-1/2 -translate-y-1/2 text-blue-400"></i>
                        <input type="text" id="npwp" placeholder="XX.XXX.XXX.X-XXX.XXX"
                            class="input-field w-full pl-11 pr-4 py-3 rounded-xl text-sm">
                    </div>
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-sm text-blue-200 mb-2">No. Telepon <span
                            class="text-red-400">*</span></label>
                    <div class="relative">
                        <i class="fas fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-blue-400"></i>
                        <input type="text" id="phone" placeholder="08XXXXXXXXXX"
                            class="input-field w-full pl-11 pr-4 py-3 rounded-xl text-sm">
                    </div>
                </div>

                <!-- Alamat -->
                <div class="md:col-span-2">
                    <label class="block text-sm text-blue-200 mb-2">Alamat Perusahaan</label>
                    <div class="relative">
                        <i class="fas fa-map-marker-alt absolute left-4 top-4 text-blue-400"></i>
                        <textarea id="address" rows="3" placeholder="Jl. ..."
                            class="input-field w-full pl-11 pr-4 py-3 rounded-xl text-sm resize-none"></textarea>
                    </div>
                </div>
            </div>

            <button id="btnRegister" onclick="doRegister()"
                class="btn-primary w-full mt-6 py-3 rounded-xl text-white font-semibold text-sm">
                <span id="btnText"><i class="fas fa-user-plus mr-2"></i>Daftarkan Akun</span>
                <span id="btnLoading" class="hidden"><i class="fas fa-spinner fa-spin mr-2"></i>Memproses...</span>
            </button>

            <div class="mt-5 text-center">
                <p class="text-blue-300 text-sm">Sudah punya akun?
                    <a href="/login" class="text-blue-400 hover:text-white font-medium transition-colors">Masuk di
                        sini</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        function checkPasswordMatch() {
            const pw = document.getElementById('password').value;
            const confirm = document.getElementById('password_confirm').value;
            const msg = document.getElementById('pw-match-msg');
            const input = document.getElementById('password_confirm');

            if (!confirm) {
                msg.classList.add('hidden');
                input.classList.remove('input-match', 'input-mismatch');
                return;
            }

            if (pw === confirm) {
                msg.textContent = '✓ Password cocok';
                msg.className = 'text-xs mt-1.5 pl-1 text-green-400';
                input.classList.add('input-match');
                input.classList.remove('input-mismatch');
            } else {
                msg.textContent = '✗ Password tidak cocok';
                msg.className = 'text-xs mt-1.5 pl-1 text-red-400';
                input.classList.add('input-mismatch');
                input.classList.remove('input-match');
            }
            msg.classList.remove('hidden');
        }

        function showAlert(msg, type = 'error') {
            const box = document.getElementById('alertBox');
            box.className =
                `mb-4 p-4 rounded-xl text-sm ${type === 'error' ? 'bg-red-500/20 text-red-300 border border-red-500/30' : 'bg-green-500/20 text-green-300 border border-green-500/30'}`;
            box.textContent = msg;
            box.classList.remove('hidden');
        }

        function setLoading(val) {
            document.getElementById('btnText').classList.toggle('hidden', val);
            document.getElementById('btnLoading').classList.toggle('hidden', !val);
            document.getElementById('btnRegister').disabled = val;
        }

        async function doRegister() {
            const data = {
                name: document.getElementById('name').value.trim(),
                email: document.getElementById('email').value.trim(),
                password: document.getElementById('password').value,
                password_confirmation: document.getElementById('password_confirm').value,
                company_name: document.getElementById('company_name').value.trim(),
                npwp: document.getElementById('npwp').value.trim(),
                phone: document.getElementById('phone').value.trim(),
                address: document.getElementById('address').value.trim(),
            };

            if (!data.name || !data.email || !data.password || !data.password_confirmation || !data.company_name || !
                data.phone) {
                showAlert('Lengkapi semua field yang wajib diisi (*).');
                return;
            }

            if (data.password.length < 8) {
                showAlert('Password minimal 8 karakter.');
                return;
            }

            if (data.password !== data.password_confirmation) {
                showAlert('Password dan konfirmasi password tidak cocok.');
                return;
            }

            setLoading(true);
            try {
                const res = await fetch('/api/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                });
                const result = await res.json();

                if (!res.ok) {
                    const errs = result.errors ? Object.values(result.errors).flat().join(' ') : result.message;
                    showAlert(errs || 'Pendaftaran gagal.');
                } else {
                    showAlert('Pendaftaran berhasil! Tunggu aktivasi dari admin. Anda akan diarahkan ke halaman login.',
                        'success');
                    setTimeout(() => window.location.href = '/login', 3000);
                }
            } catch (e) {
                showAlert('Terjadi kesalahan. Coba lagi.');
            } finally {
                setLoading(false);
            }
        }
    </script>
</body>

</html>
