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
    <main class="flex-1 p-8 overflow-auto">
        <h1 class="text-3xl font-bold mb-8">Dashboard UMKM Kopi</h1>

        <!-- KEY METRICS -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Menu Produk</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $total_menu }}</p>
                    </div>
                    <i class="fas fa-box text-4xl text-blue-100"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Stok Produk</p>
                        <p class="text-3xl font-bold text-green-600">{{ $total_stok_produk }} unit</p>
                    </div>
                    <i class="fas fa-cubes text-4xl text-green-100"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-amber-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Transaksi</p>
                        <p class="text-3xl font-bold text-amber-600">{{ $total_transaksi }}</p>
                    </div>
                    <i class="fas fa-receipt text-4xl text-amber-100"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Pendapatan</p>
                        <p class="text-2xl font-bold text-purple-600">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</p>
                    </div>
                    <i class="fas fa-money-bill-wave text-4xl text-purple-100"></i>
                </div>
            </div>
        </div>

        <!-- SALES TIMELINE -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-br from-orange-50 to-orange-100 p-6 rounded-lg shadow border border-orange-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-700 font-semibold">Penjualan Hari Ini</p>
                        <p class="text-2xl font-bold text-orange-900">Rp {{ number_format($hari_ini, 0, ',', '.') }}</p>
                    </div>
                    <i class="fas fa-calendar-day text-4xl text-orange-200"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-cyan-50 to-cyan-100 p-6 rounded-lg shadow border border-cyan-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-cyan-700 font-semibold">Penjualan Minggu Ini</p>
                        <p class="text-2xl font-bold text-cyan-900">Rp {{ number_format($minggu_ini, 0, ',', '.') }}</p>
                    </div>
                    <i class="fas fa-calendar-week text-4xl text-cyan-200"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-pink-50 to-pink-100 p-6 rounded-lg shadow border border-pink-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-pink-700 font-semibold">Penjualan Bulan Ini</p>
                        <p class="text-2xl font-bold text-pink-900">Rp {{ number_format($bulan_ini, 0, ',', '.') }}</p>
                    </div>
                    <i class="fas fa-calendar-alt text-4xl text-pink-200"></i>
                </div>
            </div>
        </div>

        <!-- SYSTEM INSIGHTS -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <div class="bg-white p-6 rounded-lg shadow border-t-4 border-green-500">
                <h2 class="text-lg font-bold mb-4 text-gray-800">
                    <i class="fas fa-star text-yellow-500 mr-2"></i>Produk Terlaris (Best Seller)
                </h2>
                @if($insight_terlaris)
                    <div class="bg-green-50 p-4 rounded border border-green-200">
                        <div class="mb-3">
                            <p class="text-gray-600 text-sm">Produk</p>
                            <p class="text-xl font-bold text-gray-900">{{ $insight_terlaris['produk']->nama_kopi }}</p>
                        </div>
                        <div class="grid grid-cols-3 gap-3">
                            <div class="bg-white p-2 rounded">
                                <p class="text-gray-500 text-xs">Total Terjual</p>
                                <p class="text-lg font-bold text-green-600">{{ $insight_terlaris['total_qty'] }} unit</p>
                            </div>
                            <div class="bg-white p-2 rounded">
                                <p class="text-gray-500 text-xs">Total Omzet</p>
                                <p class="text-sm font-bold text-green-600">Rp {{ number_format($insight_terlaris['total_omzet'], 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-white p-2 rounded">
                                <p class="text-gray-500 text-xs">Kontribusi</p>
                                <p class="text-lg font-bold text-green-600">{{ $insight_terlaris['kontribusi_persen'] }}%</p>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-3">Data periode: {{ $insight_terlaris['periode_hari'] }} hari terakhir</p>
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Belum ada data transaksi</p>
                @endif
            </div>

            <!-- INSIGHT 2: STOK MENIPIS (DIPERBAIKI) -->
            <div class="bg-white p-6 rounded-lg shadow border-t-4 border-red-500">
                <h2 class="text-lg font-bold mb-4 text-gray-800">
                    <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>Status Stok (Menipis)
                </h2>
                @if($insight_stok_menipis && count($insight_stok_menipis) > 0)
                    <div class="space-y-2">
                        @foreach(collect($insight_stok_menipis)->take(5) as $produk)
                        <div class="bg-red-50 p-3 rounded border border-red-200 flex justify-between items-center">
                            <div>
                                <p class="font-semibold text-gray-900">{{ $produk->nama_kopi }}</p>
                                <p class="text-sm text-red-600">Stok: <strong>{{ $produk->stok }} unit</strong></p>
                            </div>
                            <span class="bg-red-200 text-red-800 px-3 py-1 rounded-full text-xs font-bold">⚠️ KRITIS</span>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4 text-green-600">✓ Semua stok normal</p>
                @endif
            </div>
        </div>

        <!-- RECOMMENDATIONS (DIPERBAIKI) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white p-6 rounded-lg shadow border-t-4 border-blue-500">
                <h2 class="text-lg font-bold mb-4 text-gray-800">
                    <i class="fas fa-lightbulb text-blue-500 mr-2"></i>Rekomendasi Restock
                </h2>
                @if(count($rekomendasi_restock) > 0)
                    <div class="space-y-3">
                        @foreach(collect($rekomendasi_restock)->take(2) as $item)
                        <div class="bg-blue-50 p-4 rounded border border-blue-200">
                            <p class="font-bold text-gray-900 mb-2">{{ $item['produk']->nama_kopi }}</p>
                            <p class="text-sm text-gray-700 mb-2">{{ $item['pesan'] }}</p>
                            <div class="bg-blue-100 p-2 rounded text-xs font-semibold text-blue-900">
                                💡 Rekomendasi: Stok masuk {{ $item['qty_disarankan'] }} unit
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Tidak ada rekomendasi restock saat ini</p>
                @endif
            </div>

            <div class="bg-white p-6 rounded-lg shadow border-t-4 border-amber-500">
                <h2 class="text-lg font-bold mb-4 text-gray-800">
                    <i class="fas fa-megaphone text-amber-500 mr-2"></i>Rekomendasi Promosi
                </h2>
                @if(count($rekomendasi_promosi) > 0)
                    <div class="space-y-3">
                        @foreach(collect($rekomendasi_promosi) as $item)
                        <div class="bg-amber-50 p-4 rounded border border-amber-200">
                            <p class="font-bold text-gray-900 mb-2">{{ $item['produk']->nama_kopi }}</p>
                            <p class="text-sm text-gray-700 mb-2">{{ $item['pesan'] }}</p>
                            <div class="bg-amber-100 p-2 rounded text-xs font-semibold text-amber-900">
                                🎯 Aksi: Terapkan strategi promosi bundling
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Tidak ada rekomendasi promosi saat ini</p>
                @endif
            </div>
        </div>
    </main>

</body>
</html>