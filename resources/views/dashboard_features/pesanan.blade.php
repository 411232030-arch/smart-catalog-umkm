<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Masuk - UMKM Coffee</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-amber-50 text-slate-800 font-sans min-h-screen flex flex-col md:flex-row">

    <!-- SIDEBAR UTAMA -->
    <aside class="w-full md:w-64 bg-amber-950 text-amber-100 flex flex-col shadow-xl">
        <div class="p-5 flex items-center gap-3 border-b border-amber-900/50">
            <div class="bg-amber-600 p-2.5 rounded-xl shadow-inner">
                <i class="fas fa-coffee text-xl text-white"></i>
            </div>
            <div>
                <h1 class="font-bold text-lg leading-tight tracking-wide text-white">UMKM Coffee</h1>
                <p class="text-xs text-amber-400/80 font-medium">Panel Pemilik Toko</p>
            </div>
        </div>
        
        <nav class="flex-1 p-4 space-y-1.5">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200 font-medium hover:bg-amber-900/40 text-amber-300">
                <i class="fas fa-chart-pie w-5 text-center text-lg"></i> Ringkasan
            </a>
            <a href="{{ route('menu.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200 font-medium hover:bg-amber-900/40 text-amber-300">
                <i class="fas fa-mug-hot w-5 text-center text-lg"></i> Menu Kopi
            </a>
            <a href="{{ route('kategori.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200 font-medium hover:bg-amber-900/40 text-amber-300">
                <i class="fas fa-tags w-5 text-center text-lg"></i> Kategori
            </a>
            <a href="{{ route('pesanan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200 font-medium bg-amber-800 text-white shadow-md">
                <i class="fas fa-shopping-basket w-5 text-center text-lg text-amber-400"></i> Pesanan
            </a>
            <a href="{{ route('laporan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200 font-medium hover:bg-amber-900/40 text-amber-300">
                <i class="fas fa-wallet w-5 text-center text-lg"></i> Keuangan
            </a>
        </nav>

        <div class="p-4 border-t border-amber-900/50">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2.5 px-4 py-3 bg-rose-900/40 hover:bg-rose-900/60 text-rose-300 rounded-xl transition duration-200 font-semibold border border-rose-800/30">
                    <i class="fas fa-sign-out-alt"></i> Keluar Sistem
                </button>
            </form>
        </div>
    </aside>

    <!-- KONTEN UTAMA -->
    <main class="flex-1 p-6 md:p-8 max-w-7xl mx-auto w-full">
        <header class="mb-8 border-b border-amber-200/60 pb-5">
            <h2 class="text-2xl font-bold text-amber-950 flex items-center gap-2">
                <i class="fas fa-shopping-basket text-amber-700"></i> Daftar Pesanan Masuk
            </h2>
            <p class="text-sm text-slate-500 mt-0.5">Pantau transaksi kasir dan pesanan kopi pelanggan secara langsung.</p>
        </header>

        <div class="bg-white rounded-2xl shadow-sm border border-amber-100 overflow-hidden">
            <div class="p-5 bg-slate-50 border-b border-slate-100">
                <h3 class="font-bold text-amber-950 flex items-center gap-2">
                    <i class="fas fa-clock text-amber-600"></i> Transaksi Hari Ini
                </h3>
            </div>
            <div class="p-12 text-center text-slate-400 py-20">
                <i class="fas fa-receipt text-6xl text-amber-200 mb-4"></i>
                <p class="font-bold text-slate-700 text-lg">Belum Ada Pesanan Baru</p>
                <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto leading-relaxed">Semua transaksi pesanan yang berhasil diproses lewat aplikasi utama akan masuk dan tercatat di tabel antrean ini.</p>
            </div>
        </div>
    </main>

</body>
</html>