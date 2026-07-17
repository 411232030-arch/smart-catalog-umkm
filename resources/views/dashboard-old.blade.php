<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dasbor UMKM Kopi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 flex">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-gray-900 text-white min-h-screen flex flex-col justify-between">
        <div>
            <div class="p-6 font-bold text-xl flex items-center gap-2">
                <i class="fas fa-coffee text-amber-500"></i> UMKM Kopi
            </div>
            <nav class="mt-4 px-4 space-y-2">
                <a href="{{ route('dashboard') }}" class="block bg-amber-700 p-3 rounded-lg"><i class="fas fa-chart-pie mr-2"></i> Dasbor Utama</a>
                <a href="{{ route('menu.index') }}" class="block p-3 hover:bg-gray-800 rounded-lg"><i class="fas fa-mug-hot mr-2"></i> Menu Kopi & Produk</a>
                <a href="{{ route('kategori.index') }}" class="block p-3 hover:bg-gray-800 rounded-lg"><i class="fas fa-tag mr-2"></i> Kategori Menu</a>
                <a href="{{ route('pesanan.index') }}" class="block p-3 hover:bg-gray-800 rounded-lg"><i class="fas fa-receipt mr-2"></i> Pesanan Masuk</a>
                <a href="{{ route('laporan.index') }}" class="block p-3 hover:bg-gray-800 rounded-lg"><i class="fas fa-wallet mr-2"></i> Laporan Keuangan</a>
            </nav>
        </div>

        <!-- Tombol Keluar Sistem yang Diperbaiki -->
        <div class="p-4 border-t border-gray-800">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left p-3 hover:bg-red-900 rounded-lg text-red-400">
                    <i class="fas fa-sign-out-alt mr-2"></i> Keluar Sistem
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-8">
        <h1 class="text-2xl font-bold mb-6">Ringkasan Dashboard</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-lg shadow border">
                <h2 class="text-gray-500">Total Menu Kopi</h2>
                <p class="text-3xl font-bold">{{ $total_menu ?? 0 }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow border">
                <h2 class="text-gray-500">Total Pendapatan</h2>
                <p class="text-3xl font-bold text-amber-600">Rp {{ number_format($total_pendapatan ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>
    </main>

</body>
</html>