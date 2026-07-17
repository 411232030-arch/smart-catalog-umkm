@props(['rekomendasiRestock','rekomendasiPromosi'])

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <div class="bg-white p-6 rounded-lg shadow border-t-4 border-blue-500">
        <h2 class="text-lg font-bold mb-4 text-gray-800">
            <i class="fas fa-lightbulb text-blue-500 mr-2"></i>Rekomendasi: Next Action (Restock)
        </h2>

        @if(count($rekomendasiRestock) > 0)
            <div class="space-y-3">
                @foreach(collect($rekomendasiRestock)->take(2) as $item)
                    <div class="bg-blue-50 p-4 rounded border border-blue-200">
                        <div class="flex items-start justify-between gap-3 mb-2">
                            <div>
                                <p class="font-bold text-gray-900">{{ $item['produk']->nama_kopi }}</p>
                                <p class="text-sm text-gray-700 mt-1">{{ $item['pesan'] }}</p>
                            </div>
                            <span class="shrink-0 bg-blue-200 text-blue-900 px-3 py-1 rounded-full text-xs font-bold">Restock</span>
                        </div>

                        <div class="mt-3 grid grid-cols-3 gap-2 text-center">
                            <div class="bg-white p-2 rounded border border-blue-100">
                                <p class="text-[11px] text-gray-500">Stok saat ini</p>
                                <p class="text-sm font-bold text-blue-900">{{ $item['stok_saat_ini'] }} u</p>
                            </div>
                            <div class="bg-white p-2 rounded border border-blue-100">
                                <p class="text-[11px] text-gray-500">Penjualan/hari</p>
                                <p class="text-sm font-bold text-blue-900">{{ $item['rata_rata_terjual_per_hari'] }}</p>
                            </div>
                            <div class="bg-blue-100 p-2 rounded border border-blue-200">
                                <p class="text-[11px] text-gray-500">Qty disarankan</p>
                                <p class="text-sm font-bold text-blue-900">{{ $item['qty_disarankan'] }}</p>
                            </div>
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
            <i class="fas fa-megaphone text-amber-500 mr-2"></i>Rekomendasi: Next Action (Promosi)
        </h2>

        @if(count($rekomendasiPromosi) > 0)
            <div class="space-y-3">
                @foreach(collect($rekomendasiPromosi) as $item)
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

