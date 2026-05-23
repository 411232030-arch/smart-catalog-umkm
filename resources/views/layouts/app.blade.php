<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dasbor UMKM Kopi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-stone-50 font-sans antialiased flex h-screen overflow-hidden">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-stone-900 text-stone-300 flex flex-col justify-between flex-shrink-0">
        <div>
            <div class="px-6 py-5 bg-stone-950 flex items-center gap-3 border-b border-stone-800">
                <i class="fas fa-coffee text-amber-500 text-xl"></i>
                <span class="font-bold text-white text-lg tracking-wide">UMKM Kopi</span>
            </div>

            <nav class="px-4 py-6 space-y-1">
                <!-- Gunakan ($current_page ?? '') agar tidak error jika variabel kosong -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition {{ ($current_page ?? '') == 'dashboard' ? 'bg-amber-700 text-white shadow-md shadow-amber-950/50' : 'hover:bg-stone-800 hover:text-white' }}">
                    <i class="fas fa-chart-pie w-5 text-center"></i> Dasbor Utama
                </a>
                
                <a href="{{ route('menu.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ ($current_page ?? '') == 'menu' ? 'bg-amber-700 text-white shadow-md shadow-amber-950/50' : 'hover:bg-stone-800 hover:text-white' }}">
                    <i class="fas fa-mug-hot w-5 text-center"></i> Menu Kopi & Produk
                </a>

                <a href="{{ route('kategori.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ ($current_page ?? '') == 'kategori' ? 'bg-amber-700 text-white shadow-md shadow-amber-950/50' : 'hover:bg-stone-800 hover:text-white' }}">
                    <i class="fas fa-tags w-5 text-center"></i> Kategori Menu
                </a>

                <a href="{{ route('pesanan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ ($current_page ?? '') == 'pesanan' ? 'bg-amber-700 text-white shadow-md shadow-amber-950/50' : 'hover:bg-stone-800 hover:text-white' }}">
                    <i class="fas fa-receipt w-5 text-center"></i> Pesanan Masuk
                    <span class="ml-auto bg-amber-500/10 text-amber-400 text-xs px-2 py-0.5 rounded-full font-bold">Baru</span>
                </a>

                <a href="{{ route('laporan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ ($current_page ?? '') == 'laporan' ? 'bg-amber-700 text-white shadow-md shadow-amber-950/50' : 'hover:bg-stone-800 hover:text-white' }}">
                    <i class="fas fa-wallet w-5 text-center"></i> Laporan Keuangan
                </a>
            </nav>
        </div>

        <div class="p-4 border-t border-stone-800 bg-stone-950/40">
            <div class="flex items-center gap-3 px-2 py-2">
                <div class="w-8 h-8 rounded-full bg-amber-600 flex items-center justify-center text-white font-bold text-sm shadow">
                    K
                </div>
                <div>
                    <h4 class="text-xs font-bold text-white">Pemilik Kopi</h4>
                    <p class="text-[10px] text-stone-500">owner@umkmcoffee.com</p>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="ml-auto">
                    @csrf
                    <button type="submit" class="text-stone-500 hover:text-red-400 p-1 transition" title="Keluar">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="h-16 bg-white border-b border-stone-100 flex items-center justify-between px-8 flex-shrink-0 shadow-sm z-10">
            <h2 class="font-bold text-stone-800 text-lg">Manajemen Kafe Kedai Kopi ☕</h2>
            <div class="text-xs text-stone-400 font-medium">{{ date('D, d M Y') }}</div>
        </header>

        <main class="flex-1 overflow-y-auto p-8 bg-stone-50/50">
            @yield('content')
        </main>
    </div>

</body>
</html>