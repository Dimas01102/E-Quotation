<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RFQ System - E-Procurement Platform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        (function() {
            const t = localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ?
                'dark' : 'light');
            if (t === 'dark') document.documentElement.classList.add('dark');
        })()
    </script>
</head>

<body class="bg-white dark:bg-gray-950">

    <!-- Navbar -->
    <nav
        class="fixed top-0 w-full bg-white/90 dark:bg-gray-950/90 backdrop-blur-sm border-b border-gray-200 dark:border-gray-800 z-50">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2.5">
                <div
                    class="w-8 h-8 rounded-xl bg-brand-500 flex items-center justify-center shadow-lg shadow-brand-500/30">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <span class="font-extrabold text-gray-900 dark:text-white">RFQ<span
                        class="text-brand-500">System</span></span>
            </a>
            <div class="flex items-center gap-3">
                <a href="/register"
                    class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-brand-500 transition-colors">Daftar
                    Supplier</a>
                <a href="/login"
                    class="px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white text-sm font-semibold rounded-xl transition-colors shadow-lg shadow-brand-500/25">Login</a>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="pt-32 pb-20 px-4">
        <div class="max-w-4xl mx-auto text-center">
            <div
                class="inline-flex items-center gap-2 px-4 py-1.5 bg-brand-50 dark:bg-brand-900/30 text-brand-600 dark:text-brand-400 text-xs font-bold rounded-full mb-6 border border-brand-200 dark:border-brand-700">
                <span class="w-2 h-2 rounded-full bg-brand-500 animate-pulse"></span>
                E-Procurement Platform
            </div>
            <h1 class="text-5xl md:text-6xl font-extrabold text-gray-900 dark:text-white mb-6 leading-tight">
                Pengadaan <span class="text-brand-500">Lebih Cepat</span>,<br>Lebih Transparan
            </h1>
            <p class="text-lg text-gray-500 dark:text-gray-400 max-w-2xl mx-auto mb-10 leading-relaxed">
                Platform Request for Quotation (RFQ) digital untuk proses pengadaan barang & jasa yang efisien,
                terstruktur, dan teraudit.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/login"
                    class="px-8 py-3.5 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-2xl transition-colors shadow-xl shadow-brand-500/30 text-sm">
                    Masuk ke Dashboard →
                </a>
                <a href="/register"
                    class="px-8 py-3.5 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-800 dark:text-white font-bold rounded-2xl transition-colors text-sm">
                    Daftar sebagai Supplier
                </a>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="py-16 px-4 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-5xl mx-auto">
            <h2 class="text-3xl font-extrabold text-center text-gray-900 dark:text-white mb-12">Fitur Lengkap</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-950 rounded-2xl border border-gray-200 dark:border-gray-800 p-6">
                    <div
                        class="w-12 h-12 rounded-2xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 dark:text-white mb-2">Manajemen RFQ</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">Buat, kelola, dan distribusikan
                        permintaan penawaran ke supplier secara digital.</p>
                </div>
                <div class="bg-white dark:bg-gray-950 rounded-2xl border border-gray-200 dark:border-gray-800 p-6">
                    <div
                        class="w-12 h-12 rounded-2xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 dark:text-white mb-2">Perbandingan Harga</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">Bandingkan penawaran dari
                        berbagai supplier secara side-by-side untuk keputusan terbaik.</p>
                </div>
                <div class="bg-white dark:bg-gray-950 rounded-2xl border border-gray-200 dark:border-gray-800 p-6">
                    <div
                        class="w-12 h-12 rounded-2xl bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 dark:text-white mb-2">Notifikasi Email</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">Otomatis kirim email di setiap
                        tahap proses: undangan, submission, approval, dan PO.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Flow -->
    <section class="py-16 px-4">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-3xl font-extrabold text-center text-gray-900 dark:text-white mb-12">Alur Pengadaan</h2>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                @foreach ([['1', 'Supplier Daftar', 'bg-blue-100 text-blue-600'], ['2', 'Admin Aktivasi', 'bg-emerald-100 text-emerald-600'], ['3', 'Buat RFQ', 'bg-purple-100 text-purple-600'], ['4', 'Submit Penawaran', 'bg-amber-100 text-amber-600'], ['5', 'Terbitkan PO', 'bg-indigo-100 text-indigo-600']] as [$n, $label, $color])
                    <div class="flex flex-col items-center text-center gap-2">
                        <div
                            class="w-12 h-12 rounded-2xl {{ $color }} flex items-center justify-center text-xl font-extrabold">
                            {{ $n }}</div>
                        <p class="text-xs font-semibold text-gray-700 dark:text-gray-300 leading-tight">
                            {{ $label }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-8 px-4 border-t border-gray-200 dark:border-gray-800">
        <div class="max-w-5xl mx-auto text-center">
            <p class="text-sm text-gray-400">© {{ date('Y') }} RFQ System — E-Procurement Platform. All rights
                reserved.</p>
        </div>
    </footer>

</body>

</html>
