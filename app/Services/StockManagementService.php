<?php

namespace App\Services;

use App\Models\Produk;
use App\Models\StokMasuk;
use App\Models\TransaksiPenjualan;

class StockManagementService
{
    /**
     * Update stok ketika ada transaksi penjualan
     */
    public function decreaseStock(Produk $produk, int $qty): bool
    {
        if ($produk->stok < $qty) {
            return false;
        }

        $produk->decrement('stok', $qty);
        return true;
    }

    /**
     * Update stok ketika ada stok masuk
     */
    public function increaseStock(Produk $produk, int $qty): bool
    {
        $produk->increment('stok', $qty);
        return true;
    }

    /**
     * Get produk dengan stok menipis
     */
    public function getLowStockProducts(int $threshold = 10)
    {
        return Produk::where('stok', '<=', $threshold)
            ->orderBy('stok', 'asc')
            ->get();
    }

    /**
     * Get stok history untuk produk tertentu
     */
    public function getStockHistory(Produk $produk)
    {
        $stok_masuk = StokMasuk::where('produk_id', $produk->id)
            ->orderBy('tanggal', 'desc')
            ->get();

        $penjualan = TransaksiPenjualan::where('produk_id', $produk->id)
            ->orderBy('tanggal', 'desc')
            ->get();

        return [
            'produk' => $produk,
            'stok_masuk' => $stok_masuk,
            'penjualan' => $penjualan,
        ];
    }
}
