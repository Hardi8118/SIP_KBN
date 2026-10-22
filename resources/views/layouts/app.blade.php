<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelurahan Berok Nipah</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Sembunyikan scrollbar untuk navigasi di HP */
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 font-sans min-h-screen flex flex-col overflow-x-hidden">
    <!-- Navbar -->
    <header class="bg-blue-600 text-white shadow-md sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-3 sm:px-4 py-2 sm:py-2.5 flex flex-col md:flex-row justify-between items-center gap-2 md:gap-3">
            
            <!-- Branding -->
            <div class="flex items-center justify-between md:justify-start gap-2.5 w-full md:w-auto">
                <a href="{{ url('/') }}" class="flex items-center gap-2.5">
                    <img src="{{ asset('logo.png') }}" alt="Logo" class="h-8 sm:h-9 w-auto object-contain drop-shadow">
                    <h1 class="text-base sm:text-lg md:text-xl font-bold tracking-wide">Kelurahan Berok Nipah</h1>
                </a>
            </div>
            
            <!-- Navigation -->
            <nav class="flex overflow-x-auto hide-scrollbar w-full md:w-auto justify-start md:justify-end gap-1 sm:gap-1.5 items-center text-xs sm:text-sm font-medium pb-1 md:pb-0">
                @auth
                    @if(auth()->user()->peran === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="px-2.5 py-1.5 rounded-lg hover:bg-blue-700 transition whitespace-nowrap">Dashboard</a>
                        <a href="{{ route('admin.pengajuan.index') }}" class="px-2.5 py-1.5 rounded-lg hover:bg-blue-700 transition whitespace-nowrap">Pengajuan</a>
                        <a href="{{ route('admin.penduduk.index') }}" class="px-2.5 py-1.5 rounded-lg hover:bg-blue-700 transition whitespace-nowrap">Penduduk</a>
                        <a href="{{ route('admin.jenis_surat.index') }}" class="px-2.5 py-1.5 rounded-lg hover:bg-blue-700 transition whitespace-nowrap">Jenis Surat</a>
                        <a href="{{ route('admin.surat_keluar.index') }}" class="px-2.5 py-1.5 rounded-lg hover:bg-blue-700 transition whitespace-nowrap">Surat Keluar</a>
                    @else
                        <a href="{{ route('home') }}" class="px-2.5 py-1.5 rounded-lg hover:bg-blue-700 transition whitespace-nowrap">Beranda</a>
                        <a href="{{ route('warga.riwayat') }}" class="px-2.5 py-1.5 rounded-lg hover:bg-blue-700 transition whitespace-nowrap">Riwayat</a>
                    @endif
                    
                    <form action="{{ route('logout') }}" method="POST" class="inline flex-shrink-0 ml-1">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 sm:px-4 py-1.5 rounded-full font-bold shadow-sm transition whitespace-nowrap text-xs sm:text-sm">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="bg-white text-blue-700 px-3.5 sm:px-4 py-1.5 rounded-full font-bold shadow-sm hover:bg-gray-100 transition whitespace-nowrap text-xs sm:text-sm">Masuk</a>
                    <a href="{{ route('register') }}" class="border border-white text-white px-3.5 sm:px-4 py-1.5 rounded-full font-bold hover:bg-blue-700 transition whitespace-nowrap text-xs sm:text-sm">Daftar</a>
                @endauth
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow w-full max-w-7xl mx-auto p-3 sm:p-5 lg:p-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-800 text-slate-300 text-center py-3 sm:py-4 mt-auto text-xs sm:text-sm">
        <p>&copy; {{ date('Y') }} Kelurahan Berok Nipah. Layanan Administrasi Terpadu & Transparan.</p>
    </footer>
</body>
</html>