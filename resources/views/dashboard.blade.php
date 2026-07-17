@extends('layouts.app')

@section('content')
    <div class="space-y-8">
        <h1 class="text-3xl font-bold">Dashboard UMKM Kopi</h1>

        <!-- KEY METRICS -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-stone-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Menu Produk</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $total_menu }}</p>
                    </div>
                    <i class="fas fa-box text-4xl text-blue-100"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-stone-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Stok Produk</p>
                        <p class="text-3xl font-bold text-green-600">{{ $total_stok_produk }} unit</p>
                    </div>
                    <i class="fas fa-cubes text-4xl text-green-100"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-stone-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Transaksi</p>
                        <p class="text-3xl font-bold text-amber-600">{{ $total_transaksi }}</p>
                    </div>
                    <i class="fas fa-receipt text-4xl text-amber-100"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-stone-200">
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
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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
        <x-management.system-insights :insightTerlaris="$insight_terlaris" :insightStokMenipis="$insight_stok_menipis" />

        <!-- RECOMMENDATIONS -->
        <x-management.recommendations :rekomendasiRestock="$rekomendasi_restock" :rekomendasiPromosi="$rekomendasi_promosi" />
    </div>
@endsection

