@props(['insightTerlaris','insightStokMenipis'])

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <div class="bg-white p-6 rounded-lg shadow border-t-4 border-green-500">
        <h2 class="text-lg font-bold mb-4 text-gray-800">
            <i class="fas fa-star text-yellow-500 mr-2"></i>System Insight: Produk Terlaris (Best Seller)
        </h2>

        @if($insightTerlaris)
            <div class="bg-green-50 p-4 rounded border border-green-200">
                <div class="mb-3">
                    <p class="text-gray-600 text-sm">Produk</p>
                    <p class="text-xl font-bold text-gray-900">{{ $insightTerlaris['produk']->nama_kopi }}</p>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <div class="bg-white p-2 rounded">
                        <p class="text-gray-500 text-xs">Total Terjual</p>
                        <p class="text-lg font-bold text-green-600">{{ $insightTerlaris['total_qty'] }} unit</p>
                    </div>
                    <div class="bg-white p-2 rounded">
                        <p class="text-gray-500 text-xs">Total Omzet</p>
                        <p class="text-sm font-bold text-green-600">Rp {{ number_format($insightTerlaris['total_omzet'], 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-white p-2 rounded">
                        <p class="text-gray-500 text-xs">Kontribusi</p>
                        <p class="text-lg font-bold text-green-600">{{ $insightTerlaris['kontribusi_persen'] }}%</p>
                    </div>
                </div>

                <p class="text-xs text-gray-500 mt-3">Data periode: {{ $insightTerlaris['periode_hari'] }} hari terakhir</p>
            </div>
        @else
            <p class="text-gray-500 text-center py-4">Belum ada data transaksi</p>
        @endif
    </div>

    <div class="bg-white p-6 rounded-lg shadow border-t-4 border-red-500">
        <h2 class="text-lg font-bold mb-4 text-gray-800">
            <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>System Insight: Status Stok (Menipis)
        </h2>

        @if($insightStokMenipis && count($insightStokMenipis) > 0)
            <div class="space-y-2">
                @foreach(collect($insightStokMenipis)->take(5) as $produk)
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

