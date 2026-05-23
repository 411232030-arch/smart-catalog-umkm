<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Menu - UMKM Coffee</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-amber-50 text-slate-800 font-sans min-h-screen flex flex-col md:flex-row">
    <!-- SIDEBAR -->
    <aside class="w-full md:w-64 bg-amber-950 text-amber-100 flex flex-col shadow-xl">
        <div class="p-5 flex items-center gap-3 border-b border-amber-900/50">
            <div class="bg-amber-600 p-2.5 rounded-xl"><i class="fas fa-coffee text-xl text-white"></i></div>
            <div>
                <h1 class="font-bold text-lg text-white">UMKM Coffee</h1>
                <p class="text-xs text-amber-400/80">Panel Pemilik Toko</p>
            </div>
        </div>
        <nav class="flex-1 p-4 space-y-1.5">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-amber-900/40 text-amber-300"><i class="fas fa-chart-pie w-5 text-center"></i> Ringkasan</a>
            <a href="{{ route('menu.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-amber-900/40 text-amber-300"><i class="fas fa-mug-hot w-5 text-center"></i> Menu Kopi</a>
            <a href="{{ route('kategori.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-amber-800 text-white shadow-md"><i class="fas fa-tags w-5 text-center text-amber-400"></i> Kategori</a>
            <a href="{{ route('pesanan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-amber-900/40 text-amber-300"><i class="fas fa-shopping-basket w-5 text-center"></i> Pesanan</a>
            <a href="{{ route('laporan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-amber-900/40 text-amber-300"><i class="fas fa-wallet w-5 text-center"></i> Keuangan</a>
        </nav>
    </aside>
    <!-- KONTEN -->
    <main class="flex-1 p-6 md:p-8 max-w-7xl mx-auto w-full">
        <header class="mb-8 border-b border-amber-200/60 pb-5">
            <h2 class="text-2xl font-bold text-amber-950 flex items-center gap-2"><i class="fas fa-tags text-amber-700"></i> Pengaturan Kategori Menu</h2>
            <p class="text-sm text-slate-500">Kelompokkan produk kopi Anda (misal: Es Kopi, Hot Coffee, Non-Coffee).</p>
        </header>
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-amber-100 text-center text-slate-400">
            <i class="fas fa-folder-open text-5xl text-amber-200 mb-3"></i>
            <p class="font-medium text-slate-600">Fitur Manajemen Kategori</p>
            <p class="text-xs text-slate-400 max-w-sm mx-auto mt-1">Kategori default saat ini otomatis disesuaikan berdasarkan variasi menu kopi yang Anda tambahkan.</p>
        </div>
    </main>
</body>
</html>