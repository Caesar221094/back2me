<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Back2Me - Lost & Found System</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-2">
                    <i class='bx bx-location-plus text-2xl text-indigo-600'></i>
                    <span class="text-xl font-bold text-slate-900">Back<span class="text-indigo-600">2</span>Me</span>
                </div>
                @if (Route::has('login'))
                    <div class="flex gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 text-slate-700 hover:text-indigo-600 transition">
                                Login
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                    Daftar
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-8 sm:p-12 mb-8">
            <div class="max-w-3xl">
                <h1 class="text-3xl sm:text-4xl font-bold mb-3">
                    <span class="bg-gradient-to-r from-white via-yellow-200 to-indigo-200 bg-clip-text text-transparent">
                        Sistem Lost & Found Terpercaya
                    </span>
                </h1>
                <p class="text-base mb-6">
                    <span class="bg-gradient-to-r from-white to-indigo-100 bg-clip-text text-transparent">
                        Lapor barang hilang atau temukan pemilik barang yang Anda temukan dengan mudah dan cepat
                    </span>
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-indigo-600 rounded-lg hover:bg-indigo-50 transition font-medium">
                        <i class='bx bx-user-plus'></i>
                        Daftar Gratis
                    </a>
                    <a href="{{ route('back2me.reports.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-500 text-white rounded-lg hover:bg-indigo-400 transition font-medium">
                        <i class='bx bx-search-alt'></i>
                        Lihat Laporan
                    </a>
                </div>
            </div>
        </div>

        <!-- Features -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-5 rounded-xl shadow-sm hover:shadow-md transition">
                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mb-3">
                    <i class='bx bx-search text-xl text-indigo-600'></i>
                </div>
                <h3 class="text-base font-semibold text-slate-900 mb-1">Cari Barang</h3>
                <p class="text-slate-600 text-xs">Filter kategori & lokasi</p>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm hover:shadow-md transition">
                <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center mb-3">
                    <i class='bx bx-shield-quarter text-xl text-emerald-600'></i>
                </div>
                <h3 class="text-base font-semibold text-slate-900 mb-1">Verifikasi</h3>
                <p class="text-slate-600 text-xs">Sistem approval aman</p>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm hover:shadow-md transition">
                <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center mb-3">
                    <i class='bx bx-bell text-xl text-amber-600'></i>
                </div>
                <h3 class="text-base font-semibold text-slate-900 mb-1">Notifikasi</h3>
                <p class="text-slate-600 text-xs">Update real-time</p>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm hover:shadow-md transition">
                <div class="w-10 h-10 bg-rose-100 rounded-lg flex items-center justify-center mb-3">
                    <i class='bx bx-image text-xl text-rose-600'></i>
                </div>
                <h3 class="text-base font-semibold text-slate-900 mb-1">Upload Foto</h3>
                <p class="text-slate-600 text-xs">Bukti visual lengkap</p>
            </div>
        </div>

        <!-- Stats & How It Works -->
        <div class="grid md:grid-cols-2 gap-4 mb-8">
            <!-- Stats -->
            <div class="bg-white rounded-xl p-6 shadow-sm">
                <h2 class="text-lg font-bold text-slate-900 mb-4">Statistik</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center">
                        <p class="text-3xl font-bold text-indigo-600">150+</p>
                        <p class="text-xs text-slate-600 mt-1">Total Laporan</p>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-bold text-emerald-600">85+</p>
                        <p class="text-xs text-slate-600 mt-1">Dikembalikan</p>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-bold text-amber-600">15+</p>
                        <p class="text-xs text-slate-600 mt-1">Kategori</p>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-bold text-rose-600">98%</p>
                        <p class="text-xs text-slate-600 mt-1">Kepuasan</p>
                    </div>
                </div>
            </div>

            <!-- How It Works -->
            <div class="bg-white rounded-xl p-6 shadow-sm">
                <h2 class="text-lg font-bold text-slate-900 mb-4">Cara Kerja</h2>
                <div class="space-y-3">
                    <div class="flex gap-3">
                        <div class="w-6 h-6 bg-indigo-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-xs font-bold text-indigo-600">1</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Buat Laporan</p>
                            <p class="text-xs text-slate-600">Upload foto & deskripsi barang</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div class="w-6 h-6 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-xs font-bold text-emerald-600">2</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Terima Klaim</p>
                            <p class="text-xs text-slate-600">Review bukti kepemilikan</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div class="w-6 h-6 bg-amber-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-xs font-bold text-amber-600">3</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Approve & Selesai</p>
                            <p class="text-xs text-slate-600">Koordinasi pengambilan barang</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 text-center">
            <div class="flex items-center justify-center gap-2 text-sm text-slate-600">
                <i class='bx bx-location-plus text-indigo-600'></i>
                <span class="font-semibold">Back<span class="text-indigo-600">2</span>Me</span>
                <span>•</span>
                <span>© 2025</span>
            </div>
        </div>
    </footer>
</body>
</html>
