<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - RFQ System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        (function() {
            const t = localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ?
                'dark' : 'light');
            if (t === 'dark') document.documentElement.classList.add('dark');
        })()
    </script>
</head>

<body class="dark:bg-gray-900" x-data="{ showPassword: false }">
    <div class="relative z-1 bg-white dark:bg-gray-900">
        <div class="relative flex h-screen w-full flex-col justify-center lg:flex-row dark:bg-gray-900">

            <!-- Form Side -->
            <div class="flex w-full flex-1 flex-col lg:w-1/2">
                <div class="mx-auto w-full max-w-md pt-10 px-4">
                    <a href="/"
                        class="inline-flex items-center text-sm text-gray-500 transition-colors hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Kembali ke Beranda
                    </a>
                </div>
                <div class="mx-auto flex w-full max-w-md flex-1 flex-col justify-center px-4">
                    <div>
                        <div class="mb-8">
                            <div class="flex items-center gap-3 mb-5">
                                <div
                                    class="w-10 h-10 rounded-xl bg-brand-500 flex items-center justify-center shadow-lg shadow-brand-500/30">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <span class="font-extrabold text-2xl text-gray-900 dark:text-white">RFQ<span
                                        class="text-brand-500">System</span></span>
                            </div>
                            <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90 mb-1">Selamat Datang! 👋</h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Masukkan email dan password untuk login
                                ke sistem.</p>
                        </div>

                        <!-- Error alert -->
                        <div id="error-alert"
                            class="hidden mb-4 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl flex items-center gap-2 text-sm text-red-600 dark:text-red-400">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span id="error-msg"></span>
                        </div>

                        <div class="space-y-5">
                            <!-- Email -->
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" id="login-email" placeholder="Masukkan Email"
                                    class="h-11 w-full rounded-xl border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800 transition-colors" />
                            </div>

                            <!-- Password -->
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Password <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input :type="showPassword ? 'text' : 'password'" id="login-password"
                                        placeholder="Masukkan password"
                                        class="h-11 w-full rounded-xl border border-gray-300 bg-transparent py-2.5 pr-11 pl-4 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 transition-colors"
                                        onkeydown="if(event.key==='Enter')doLogin()" />
                                    <button type="button" @click="showPassword=!showPassword"
                                        class="absolute top-1/2 right-4 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                        <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Remember -->
                            <div class="flex items-center justify-between">
                                <label
                                    class="flex items-center gap-2 cursor-pointer text-sm text-gray-600 dark:text-gray-400 select-none"
                                    x-data="{ checked: false }">
                                    <div class="relative">
                                        <input type="checkbox" id="remember" class="sr-only"
                                            @change="checked=!checked" />
                                        <div :class="checked ? 'border-brand-500 bg-brand-500' :
                                            'bg-transparent border-gray-300 dark:border-gray-600'"
                                            class="w-5 h-5 rounded-md border flex items-center justify-center transition-colors">
                                            <svg x-show="checked" class="w-3 h-3 text-white" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                    </div>
                                    Ingat saya
                                </label>
                            </div>

                            <!-- Submit -->
                            <button id="login-btn" onclick="doLogin()"
                                class="w-full flex items-center justify-center gap-2 bg-brand-500 hover:bg-brand-600 disabled:opacity-60 disabled:cursor-not-allowed text-white font-semibold rounded-xl px-4 py-3 text-sm transition-colors shadow-lg shadow-brand-500/30">
                                <svg id="login-spinner" class="hidden animate-spin w-4 h-4" fill="none"
                                    viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4" />
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                                </svg>
                                <span id="login-text">Masuk</span>
                            </button>
                        </div>

                        <p class="mt-6 text-center text-sm text-gray-500 dark:text-gray-400">
                            Belum punya akun? <a href="/register"
                                class="text-brand-500 hover:text-brand-600 font-semibold">Daftar sebagai Supplier</a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Illustration -->
            <div class="bg-brand-950 relative hidden h-full w-full items-center lg:grid lg:w-1/2 dark:bg-white/5">
                <div class="z-1 flex flex-col items-center justify-center p-12 text-center">
                    <div class="w-24 h-24 rounded-3xl bg-white/10 flex items-center justify-center mb-8 shadow-2xl">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-white mb-3">E-Procurement RFQ</h2>
                    <p class="text-brand-200 dark:text-white/60 max-w-sm leading-relaxed">Platform pengadaan barang &
                        jasa digital yang efisien, transparan, dan terstruktur untuk perusahaan Anda.</p>
                    <div class="mt-10 grid grid-cols-3 gap-4 w-full max-w-xs">
                        <div class="bg-white/10 rounded-2xl p-3 text-center">
                            <p class="text-2xl font-bold text-white">RFQ</p>
                            <p class="text-xs text-brand-200 mt-1">Request</p>
                        </div>
                        <div class="bg-white/10 rounded-2xl p-3 text-center">
                            <p class="text-2xl font-bold text-white">QUO</p>
                            <p class="text-xs text-brand-200 mt-1">Quotation</p>
                        </div>
                        <div class="bg-white/10 rounded-2xl p-3 text-center">
                            <p class="text-2xl font-bold text-white">PO</p>
                            <p class="text-xs text-brand-200 mt-1">Purchase</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let isLoading = false;

        async function doLogin() {
            if (isLoading) return;

            const email = document.getElementById('login-email').value.trim();
            const password = document.getElementById('login-password').value;
            const remember = document.getElementById('remember').checked;

            if (!email || !password) {
                showError('Email dan password wajib diisi.');
                return;
            }

            setLoading(true);
            hideError();

            try {
                const res = await fetch('/api/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        email,
                        password,
                        remember
                    })
                });

                const r = await res.json();

                if (r.success) {
                    window.location.href = r.redirect;
                } else {
                    showError(r.message || 'Login gagal.');
                    setLoading(false);
                }
            } catch (e) {
                showError('Terjadi kesalahan jaringan. Coba lagi.');
                setLoading(false);
            }
        }

        function setLoading(v) {
            isLoading = v;
            const btn = document.getElementById('login-btn');
            const spinner = document.getElementById('login-spinner');
            const btnText = document.getElementById('login-text');

            btn.disabled = v;
            btn.classList.toggle('opacity-60', v);
            btn.classList.toggle('cursor-not-allowed', v);
            spinner.classList.toggle('hidden', !v);
            btnText.textContent = v ? 'Memproses...' : 'Masuk';
        }

        function showError(msg) {
            document.getElementById('error-alert').classList.remove('hidden');
            document.getElementById('error-msg').textContent = msg;
        }

        function hideError() {
            document.getElementById('error-alert').classList.add('hidden');
        }
    </script>
</body>

</html>
