<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - RFQ System</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script>
        (function() {
            const t = localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ?
                'dark' : 'light');
            if (t === 'dark') document.documentElement.classList.add('dark');
        })()
    </script>
    
    <style>
        * { box-sizing: border-box; }

        body {
            min-height: 100vh;
            margin: 0;
            background: #f0f4f2;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        .card-wrap {
            display: flex;
            width: 100%;
            max-width: 820px;
            min-height: 520px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.13);
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: 300px;
            flex-shrink: 0;
            background: #16352a;
            padding: 3rem 2rem;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

        .sidebar::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 3rem;
            position: relative;
        }

        .sidebar-logo-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(255,255,255,0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sidebar-logo-icon svg { width: 22px; height: 22px; stroke: #4ade80; fill: none; }

        .sidebar-logo-text {
            font-size: 20px;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.3px;
        }

        .sidebar-logo-text span { color: #4ade80; }

        .sidebar-heading {
            color: #fff;
            font-size: 24px;
            font-weight: 700;
            line-height: 1.3;
            margin: 0 0 0.75rem;
            letter-spacing: -0.4px;
            position: relative;
        }

        .sidebar-desc {
            color: rgba(255,255,255,0.5);
            font-size: 13px;
            line-height: 1.7;
            margin: 0 0 2.5rem;
            position: relative;
        }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            position: relative;
        }

        .stat-box {
            background: rgba(255,255,255,0.07);
            border-radius: 12px;
            padding: 12px 8px;
            text-align: center;
            border: 1px solid rgba(255,255,255,0.06);
        }

        .stat-box .val {
            font-size: 15px;
            font-weight: 800;
            color: #fff;
            letter-spacing: 0.5px;
            display: block;
        }

        .stat-box .lbl {
            font-size: 11px;
            color: rgba(255,255,255,0.45);
            margin-top: 3px;
            display: block;
        }

        /* ── FORM PANEL ── */
        .form-panel {
            flex: 1;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 3rem 2.5rem;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #9ca3af;
            text-decoration: none;
            margin-bottom: 2.5rem;
            transition: color 0.15s;
        }
        .back-link:hover { color: #16352a; }
        .back-link svg { width: 15px; height: 15px; stroke: currentColor; fill: none; }

        .form-title { font-size: 22px; font-weight: 700; color: #111827; margin: 0 0 5px; letter-spacing: -0.3px; }
        .form-subtitle { font-size: 13px; color: #6b7280; margin: 0 0 2rem; }

        #error-alert {
            display: none;
            margin-bottom: 1.25rem;
            padding: 12px 16px;
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            font-size: 13px;
            color: #b91c1c;
            align-items: center;
            gap: 8px;
        }
        #error-alert svg { width: 16px; height: 16px; stroke: currentColor; fill: none; flex-shrink: 0; }

        .form-stack { display: flex; flex-direction: column; gap: 1.25rem; }

        .field-group { display: flex; flex-direction: column; gap: 6px; }

        .field-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #6b7280;
        }

        .field-label span { color: #ef4444; }

        .field-input {
            height: 44px;
            width: 100%;
            padding: 0 14px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            font-size: 14px;
            color: #111827;
            background: #f9fafb;
            font-family: inherit;
            transition: all 0.15s;
            outline: none;
        }
        .field-input:focus {
            border-color: #16352a;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(22,53,42,0.1);
        }

        .pw-wrapper { position: relative; }
        .pw-wrapper .field-input { padding-right: 44px; }
        
        .pw-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #9ca3af;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px; /* Font Awesome size */
        }
        .pw-toggle:hover { color: #16352a; }

        .remember-row {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        #login-btn {
            width: 100%;
            height: 46px;
            background: #16352a;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.15s;
        }
        #login-btn:hover { background: #0e2419; transform: translateY(-1px); }
        #login-btn:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

        .register-hint {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 13px;
            color: #9ca3af;
        }
        .register-hint a { color: #16352a; font-weight: 700; text-decoration: none; }

        /* Spinner for loading */
        .animate-spin {
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .hidden { display: none; }

        @media (max-width: 640px) {
            .card-wrap { flex-direction: column; min-height: unset; }
            .sidebar { width: 100%; padding: 2rem 1.5rem; }
            .stat-grid { display: none; }
            .form-panel { padding: 2rem 1.5rem; }
        }
    </style>
</head>

<body>
<div class="card-wrap">

    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="sidebar-logo-icon">
                <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <span class="sidebar-logo-text">RFQ<span>System</span></span>
        </div>

        <h1 class="sidebar-heading">Selamat Datang<br>Kembali 👋</h1>
        <p class="sidebar-desc">Platform pengadaan barang & jasa digital yang efisien, transparan, dan terstruktur untuk perusahaan Anda.</p>

        <div class="stat-grid">
            <div class="stat-box"><span class="val">RFQ</span><span class="lbl">Request</span></div>
            <div class="stat-box"><span class="val">QUO</span><span class="lbl">Quotation</span></div>
            <div class="stat-box"><span class="val">PO</span><span class="lbl">Purchase</span></div>
        </div>
    </aside>

    <main class="form-panel">
        <a href="/" class="back-link">
            <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Beranda
        </a>

        <h2 class="form-title">Masuk ke Akun</h2>
        <p class="form-subtitle">Masukkan email dan password untuk login ke sistem.</p>

        <div id="error-alert">
            <svg viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span id="error-msg"></span>
        </div>

        <div class="form-stack">
            <div class="field-group">
                <label class="field-label" for="login-email">Email <span>*</span></label>
                <input type="email" id="login-email" placeholder="Masukkan Email" class="field-input">
            </div>

            <div class="field-group">
                <label class="field-label" for="login-password">Password <span>*</span></label>
                <div class="pw-wrapper">
                    <input type="password" id="login-password" placeholder="Masukkan password" class="field-input" onkeydown="if(event.key==='Enter')doLogin()">
                    
                    <button type="button" class="pw-toggle" onclick="togglePassword()">
                        <i id="toggle-icon" class="fas fa-eye"></i>
                    </button>
                </div>
            </div>



            <button id="login-btn" onclick="doLogin()">
                <i id="login-spinner" class="fas fa-circle-notch animate-spin hidden"></i>
                <span id="login-text">Masuk</span>
            </button>
        </div>

        <p class="register-hint">
            Belum punya akun? <a href="/register">Daftar sebagai Supplier</a>
        </p>
    </main>
</div>

<script>
    let isLoading = false;

    // Fungsi Toggle Password menggunakan Vanilla JS & Font Awesome
    function togglePassword() {
        const passwordInput = document.getElementById('login-password');
        const icon = document.getElementById('toggle-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    async function doLogin() {
        if (isLoading) return;

        const email = document.getElementById('login-email').value.trim();
        const password = document.getElementById('login-password').value;

        if (!email || !password) {
            showError('Email dan password wajib diisi.');
            return;
        }

        setLoading(true);
        hideError();

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            
            const res = await fetch('/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ email, password })
            });

            const r = await res.json();

            if (r.success) {
                window.location.href = r.redirect;
            } else {
                showError(r.message || 'Login gagal.');
                setLoading(false);
            }
        } catch (e) {
            showError('Terjadi kesalahan jaringan atau konfigurasi.');
            setLoading(false);
        }
    }

    function setLoading(v) {
        isLoading = v;
        const btn = document.getElementById('login-btn');
        const spinner = document.getElementById('login-spinner');
        const btnText = document.getElementById('login-text');

        btn.disabled = v;
        spinner.classList.toggle('hidden', !v);
        btnText.textContent = v ? 'Memproses...' : 'Masuk';
    }

    function showError(msg) {
        const el = document.getElementById('error-alert');
        el.style.display = 'flex';
        document.getElementById('error-msg').textContent = msg;
    }

    function hideError() {
        document.getElementById('error-alert').style.display = 'none';
    }
</script>
</body>
</html>