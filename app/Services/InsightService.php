<?php

namespace App\Services;

use App\Models\Produk;
use App\Models\TransaksiPenjualan;
use Illuminate\Support\Carbon;

class InsightService
{
    /** Ambang batas stok dianggap menipis */
    protected int $lowStockThreshold = 10;

    /** Jendela waktu analisa penjualan (hari) */
    protected int $windowDays = 30;

    /** Estimasi waktu tunggu pengadaan / lead time restock (hari) */
    protected int $leadTimeDays = 7;

    /**
     * INSIGHT 1: Produk Terlaris (best seller) dalam periode berjalan.
     */
    public function produkTerlaris(): ?array
    {
        $sejak = Carbon::now()->subDays($this->windowDays);

        $rows = TransaksiPenjualan::where('tanggal', '>=', $sejak)
            ->selectRaw('produk_id, SUM(qty) as total_qty, SUM(total_harga) as total_omzet')
            ->groupBy('produk_id')
            ->orderByDesc('total_qty')
            ->with('produk')
            ->get();

        if ($rows->isEmpty()) {
            return null;
        }

        $top = $rows->first();
        $grandTotalOmzet = $rows->sum('total_omzet');
        $kontribusi = $grandTotalOmzet > 0
            ? round(($top->total_omzet / $grandTotalOmzet) * 100, 1)
            : 0;

        return [
            'produk' => $top->produk,
            'total_qty' => (int) $top->total_qty,
            'total_omzet' => (int) $top->total_omzet,
            'kontribusi_persen' => $kontribusi,
            'periode_hari' => $this->windowDays,
        ];
    }

    /**
     * INSIGHT 2: Produk dengan stok menipis (butuh perhatian manajemen).
     */
    public function stokMenipis()
    {
        return Produk::where('stok', '<=', $this->lowStockThreshold)
            ->orderBy('stok')
            ->get();
    }

    /**
     * REKOMENDASI 1: Rekomendasi restock berdasarkan kecepatan penjualan (sales velocity)
     * dibandingkan dengan sisa stok saat ini, supaya tidak kehabisan stok.
     */
    public function rekomendasiRestock(): array
    {
        $sejak = Carbon::now()->subDays($this->windowDays);
        $produkMenipis = $this->stokMenipis();

        $rekomendasi = [];

        foreach ($produkMenipis as $produk) {
            $totalTerjual = TransaksiPenjualan::where('produk_id', $produk->id)
                ->where('tanggal', '>=', $sejak)
                ->sum('qty');

            $rataRataHarian = $totalTerjual > 0
                ? round($totalTerjual / $this->windowDays, 2)
                : 0;

            $proyeksiKebutuhan = (int) ceil($rataRataHarian * $this->leadTimeDays);
            $kekurangan = max($proyeksiKebutuhan - $produk->stok, 0);

            // Hanya tampilkan sebagai rekomendasi kuat jika ada histori penjualan
            // ATAU stok sudah benar-benar kritis (<= 3).
            if ($totalTerjual > 0 || $produk->stok <= 3) {
                $qtyDisarankan = max($kekurangan, $produk->stok <= 3 ? 10 : 0);

                $rekomendasi[] = [
                    'produk' => $produk,
                    'stok_saat_ini' => $produk->stok,
                    'rata_rata_terjual_per_hari' => $rataRataHarian,
                    'qty_disarankan' => $qtyDisarankan > 0 ? $qtyDisarankan : 10,
                    'pesan' => $rataRataHarian > 0
                        ? "Stok \"{$produk->nama_kopi}\" tersisa {$produk->stok} unit, dengan rata-rata penjualan {$rataRataHarian} unit/hari. Diprediksi habis dalam " .
                          ($rataRataHarian > 0 ? floor($produk->stok / $rataRataHarian) : '-') .
                          " hari. Segera lakukan stok masuk minimal " . max($kekurangan, 10) . " unit."
                        : "Stok \"{$produk->nama_kopi}\" tersisa {$produk->stok} unit dan sudah masuk kategori kritis. Lakukan pengecekan dan stok masuk sebelum kehabisan.",
                ];
            }
        }

        // Urutkan: yang paling mendesak (stok paling sedikit dibanding rata-rata jual) di atas
        usort($rekomendasi, fn ($a, $b) => $a['stok_saat_ini'] <=> $b['stok_saat_ini']);

        return $rekomendasi;
    }

    /**
     * REKOMENDASI 2: Produk dengan penjualan paling rendah (slow moving) —
     * kandidat untuk promosi/bundling agar penjualan lebih merata dan tidak
     * membebani biaya penyimpanan/bahan baku.
     */
    public function rekomendasiPromosi(int $limit = 2): array
    {
        $sejak = Carbon::now()->subDays($this->windowDays);

        $terjual = TransaksiPenjualan::where('tanggal', '>=', $sejak)
            ->selectRaw('produk_id, SUM(qty) as total_qty')
            ->groupBy('produk_id')
            ->pluck('total_qty', 'produk_id');

        $semuaProduk = Produk::all();

        if ($semuaProduk->count() <= 1) {
            return [];
        }

        $bestSeller = $this->produkTerlaris();
        $bestSellerId = $bestSeller['produk']->id ?? null;

        $slowMovers = $semuaProduk
            ->filter(fn ($p) => $p->id !== $bestSellerId)
            ->map(function ($p) use ($terjual) {
                $qty = (int) ($terjual[$p->id] ?? 0);
                return [
                    'produk' => $p,
                    'total_qty' => $qty,
                ];
            })
            ->sortBy('total_qty')
            ->take($limit);

        $rekomendasi = [];
        foreach ($slowMovers as $item) {
            $produk = $item['produk'];
            $qty = $item['total_qty'];

            $rekomendasi[] = [
                'produk' => $produk,
                'total_qty' => $qty,
                'pesan' => $qty === 0
                    ? "\"{$produk->nama_kopi}\" belum terjual sama sekali dalam {$this->windowDays} hari terakhir. Pertimbangkan promo diskon, bundling dengan produk terlaris, atau evaluasi apakah menu ini masih relevan."
                    : "\"{$produk->nama_kopi}\" hanya terjual {$qty} unit dalam {$this->windowDays} hari terakhir, jauh di bawah rata-rata. Coba tawarkan promo bundling dengan produk terlaris untuk mendongkrak penjualannya.",
            ];
        }

        return $rekomendasi;
    }
}