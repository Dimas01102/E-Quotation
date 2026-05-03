<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Supplier - E-Quotation System</title>
    <link rel="icon" type="image/png" href="/assets/images/logo.jpg">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background: #f0f4f2;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        .card-wrap {
            display: flex;
            width: 100%;
            max-width: 860px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.13);
            background: #fff;
        }

        .sidebar {
            width: 260px;
            flex-shrink: 0;
            background: #16352a;
            padding: 2.5rem 1.75rem;
            display: flex;
            flex-direction: column;
        }

        .sidebar-title {
            color: #fff;
            font-size: 22px;
            font-weight: 600;
            line-height: 1.35;
            margin: 0 0 0.75rem;
        }

        .sidebar-desc {
            color: rgba(255, 255, 255, 0.55);
            font-size: 13px;
            line-height: 1.65;
            margin: 0 0 2rem;
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 1.25rem;
        }

        .feature-icon {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .feature-icon i {
            color: #4ade80;
            font-size: 14px;
        }

        .feature-text strong {
            display: block;
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .feature-text span {
            color: rgba(255, 255, 255, 0.5);
            font-size: 12px;
            line-height: 1.5;
        }

        .sidebar-img {
            margin-top: auto;
            border-radius: 10px;
            overflow: hidden;
            height: 110px;
            padding-top: 2rem;
        }

        .form-panel {
            flex: 1;
            background: #fff;
            padding: 2.5rem 2rem;
            height: auto;
            overflow: visible;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 1.25rem;
            padding-bottom: 0.875rem;
            border-bottom: 1px solid #e8ede9;
        }

        .section-num {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #16352a;
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            margin: 0;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.75rem;
        }

        .field-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .field-group.full {
            grid-column: 1 / -1;
        }

        .field-label {
            font-size: 11px;
            font-weight: 600;
            color: #6b7a72;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        input.field-input,
        textarea.field-input {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #dde3de !important;
            border-radius: 8px;
            font-size: 14px;
            color: #1a1a1a;
            background: #fff;
            outline: none;
        }

        input.field-input:focus {
            border-color: #16352a !important;
            box-shadow: 0 0 0 3px rgba(22, 53, 42, 0.1);
        }

        .pw-wrapper {
            position: relative;
            width: 100%;
        }

        .pw-wrapper .field-input {
            padding-right: 40px;
        }

        .pw-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #9ca3af;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pw-toggle:hover {
            color: #16352a;
        }

        .input-match {
            border-color: #22c55e !important;
        }

        .input-mismatch {
            border-color: #ef4444 !important;
        }

        #btnRegister {
            width: 100%;
            padding: 14px;
            background: #16352a;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
        }

        #btnRegister:hover {
            background: #0e2419;
            transform: translateY(-1px);
        }

        #btnRegister:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .login-hint {
            text-align: center;
            margin-top: 1rem;
            font-size: 13px;
            color: #6b7a72;
        }

        .login-hint a {
            color: #16352a;
            font-weight: 600;
            text-decoration: none;
        }

        .hidden {
            display: none;
        }

        @media (max-width: 640px) {
            body {
                padding: 0;
            }

            .card-wrap {
                flex-direction: column;
                border-radius: 0;
                box-shadow: none;
            }

            .sidebar {
                width: 100%;
            }

            .sidebar-img {
                display: none;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="card-wrap">
        <aside class="sidebar">
            <h1 class="sidebar-title">Pendaftaran<br>Mitra Supplier</h1>
            <p class="sidebar-desc">Bergabunglah dengan ekosistem digital kami untuk proses pengadaan yang transparan,
                efisien, dan berkelanjutan.</p>

            <div class="feature-item">
                <div class="feature-icon"><i class="fas fa-check-circle"></i></div>
                <div class="feature-text">
                    <strong>Verifikasi Cepat</strong>
                    <span>Proses validasi dokumen dalam 2×24 jam kerja.</span>
                </div>
            </div>

            <div class="feature-item">
                <div class="feature-icon"><i class="fas fa-lock"></i></div>
                <div class="feature-text">
                    <strong>Data Aman</strong>
                    <span>Enkripsi tingkat tinggi untuk seluruh dokumen perusahaan.</span>
                </div>
            </div>

            <div class="sidebar-img">
                <svg viewBox="0 0 260 110" xmlns="http://www.w3.org/2000/svg" width="200">
                    <rect width="260" height="110" fill="#1a4a32" rx="10" />
                    <circle cx="50" cy="50" r="20" fill="#4ade80" opacity="0.2" />
                </svg>
            </div>
        </aside>

        <main class="form-panel">
            <div id="alertBox" class="hidden mb-4 p-4 rounded-xl text-sm"></div>

            <div class="section-header">
                <div class="section-num">01</div>
                <h2 class="section-title">Identitas Perusahaan</h2>
            </div>

            <div class="form-grid">
                <div class="field-group full">
                    <label class="field-label">Nama Lengkap PIC <span class="text-red-400">*</span></label>
                    <input type="text" id="name" placeholder="Nama PIC / Perwakilan" class="field-input">
                </div>

                <div class="field-group full">
                    <label class="field-label">Nama Perusahaan <span class="text-red-400">*</span></label>
                    <input type="text" id="company_name" placeholder="PT / CV / UD ..." class="field-input">
                </div>

                <div class="field-group">
                    <label class="field-label">NPWP</label>
                    <input type="text" id="npwp" placeholder="XX.XXX.XXX.X-XXX.XXX" class="field-input">
                </div>

                <div class="field-group">
                    <label class="field-label">No. Telepon <span class="text-red-400">*</span></label>
                    <input type="text" id="phone" placeholder="08XXXXXXXXXX" class="field-input">
                </div>

                <div class="field-group full">
                    <label class="field-label">Alamat Perusahaan</label>
                    <textarea id="address" rows="2" placeholder="Jl. ..." class="field-input"></textarea>
                </div>
            </div>

            <div class="section-header">
                <div class="section-num">02</div>
                <h2 class="section-title">Kontak & Keamanan</h2>
            </div>

            <div class="form-grid">
                <div class="field-group">
                    <label class="field-label">Email <span class="text-red-400">*</span></label>
                    <input type="email" id="email" placeholder="email@perusahaan.com" class="field-input">
                </div>

                <div class="field-group">
                    <label class="field-label">Password <span class="text-red-400">*</span></label>
                    <div class="pw-wrapper">
                        <input type="password" id="password" placeholder="Min. 8 karakter"
                            oninput="checkPasswordMatch()" class="field-input">
                        <button type="button" class="pw-toggle" onclick="togglePassword('password', 'eye-1')">
                            <i id="eye-1" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="field-group full">
                    <label class="field-label">Konfirmasi Password <span class="text-red-400">*</span></label>
                    <div class="pw-wrapper">
                        <input type="password" id="password_confirm" placeholder="Ulangi password"
                            oninput="checkPasswordMatch()" class="field-input">
                        <button type="button" class="pw-toggle"
                            onclick="togglePassword('password_confirm', 'eye-2')">
                            <i id="eye-2" class="fas fa-eye"></i>
                        </button>
                    </div>
                    <p id="pw-match-msg" class="hidden text-xs mt-1.5 pl-1"></p>
                </div>
            </div>

            <button id="btnRegister" onclick="doRegister()">
                <span id="btnText">Daftar Sekarang</span>
                <span id="btnLoading" class="hidden"><i class="fas fa-spinner fa-spin"></i>&nbsp; Memproses...</span>
            </button>

            <p class="login-hint">Sudah punya akun? <a href="/login">Masuk di sini</a></p>
        </main>
    </div>

    <script>
        // FUNCTION: Toggle Password Visibility
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        // FUNCTION: Real-time Password Matching
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
                msg.className = 'text-xs mt-1.5 pl-1 text-green-600';
                input.classList.add('input-match');
                input.classList.remove('input-mismatch');
            } else {
                msg.textContent = '✗ Password tidak cocok';
                msg.className = 'text-xs mt-1.5 pl-1 text-red-500';
                input.classList.add('input-mismatch');
                input.classList.remove('input-match');
            }
            msg.classList.remove('hidden');
        }

        // FUNCTION: Handle Loading UI State
        function setLoading(isLoading) {
            const btn = document.getElementById('btnRegister');
            const btnText = document.getElementById('btnText');
            const btnLoading = document.getElementById('btnLoading');

            if (isLoading) {
                btn.disabled = true;
                btnText.classList.add('hidden');
                btnLoading.classList.remove('hidden');
            } else {
                btn.disabled = false;
                btnText.classList.remove('hidden');
                btnLoading.classList.add('hidden');
            }
        }

        // FUNCTION: Show Alerts
        function showAlert(message, type = 'error') {
            const alertBox = document.getElementById('alertBox');
            alertBox.textContent = message;
            alertBox.classList.remove('hidden');
            
            if (type === 'success') {
                alertBox.className = 'mb-4 p-4 rounded-xl text-sm bg-green-100 text-green-700';
            } else {
                alertBox.className = 'mb-4 p-4 rounded-xl text-sm bg-red-100 text-red-700';
            }
            
            // Optional: Auto-scroll to top of form to see alert
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // MAIN: Register Logic
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

            // Validation
            if (!data.name || !data.email || !data.password || !data.password_confirmation || !data.company_name || !data.phone) {
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
                        // Ensure CSRF token is handled correctly in your backend (Laravel/etc)
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                    },
                    body: JSON.stringify(data)
                });
                
                const result = await res.json();

                if (!res.ok) {
                    const errs = result.errors ? Object.values(result.errors).flat().join(' ') : result.message;
                    showAlert(errs || 'Pendaftaran gagal.');
                } else {
                    showAlert('Pendaftaran berhasil! Tunggu aktivasi dari admin. Anda akan diarahkan ke halaman login.', 'success');
                    setTimeout(() => window.location.href = '/login', 3000);
                }
            } catch (e) {
                showAlert('Terjadi kesalahan koneksi. Coba lagi.');
                console.error(e);
            } finally {
                setLoading(false);
            }
        }
    </script>
</body>

</html>