<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\StokMasuk;
use App\Models\TransaksiPenjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $produkList = Produk::orderBy('nama_kopi')->get();
        $riwayatPenjualan = TransaksiPenjualan::with('produk')->orderByDesc('tanggal')->limit(15)->get();
        $riwayatStokMasuk = StokMasuk::with('produk')->orderByDesc('tanggal')->limit(15)->get();

        return view('dashboard_features.pesanan', compact('produkList', 'riwayatPenjualan', 'riwayatStokMasuk'));
    }

    public function storePenjualan(Request $request)
    {
        // Diubah dari 'produks' menjadi 'produk'
        $validated = $request->validate([
            'produk_id' => 'required|exists:produk,id', 
            'qty' => 'required|integer|min:1',
            'merchant_code' => 'required|string|max:50',
        ]);

        return DB::transaction(function () use ($validated) {
            $produk = Produk::lockForUpdate()->findOrFail($validated['produk_id']);

            if ($produk->stok < $validated['qty']) {
                return back()->withInput()->with('error', "Stok \"{$produk->nama_kopi}\" tidak mencukupi.");
            }

            $nomorTransaksi = $this->generateCode('TRX', TransaksiPenjualan::class);

            TransaksiPenjualan::create([
                'nomor_transaksi' => $nomorTransaksi,
                'tanggal' => now(),
                'produk_id' => $produk->id,
                'qty' => $validated['qty'],
                'merchant_code' => $validated['merchant_code'],
                'harga_satuan' => $produk->harga,
                'total_harga' => $produk->harga * $validated['qty'],
            ]);

            $produk->decrement('stok', $validated['qty']);

            return redirect()->route('pesanan.index')
                ->with('success', "Transaksi penjualan {$nomorTransaksi} berhasil dicatat.");
        });
    }

    public function storeStokMasuk(Request $request)
    {
        // Diubah dari 'produks' menjadi 'produk'
        $validated = $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'qty' => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($validated) {
            $produk = Produk::lockForUpdate()->findOrFail($validated['produk_id']);

            $stockCode = $this->generateCode('STK', StokMasuk::class);

            StokMasuk::create([
                'stock_code' => $stockCode,
                'tanggal' => now(),
                'produk_id' => $produk->id,
                'qty' => $validated['qty'],
            ]);

            $produk->increment('stok', $validated['qty']);

            return redirect()->back()
                ->with('success', "Stok masuk berhasil dicatat. Stok \"{$produk->nama_kopi}\" bertambah {$validated['qty']} unit.");
        });
    }

    protected function generateCode(string $prefix, string $model): string
    {
        $today = now()->format('Ymd');
        $countToday = $model::whereDate('created_at', now()->toDateString())->count();
        $urut = str_pad((string) ($countToday + 1), 4, '0', STR_PAD_LEFT);
        return "{$prefix}-{$today}-{$urut}";
    }
}