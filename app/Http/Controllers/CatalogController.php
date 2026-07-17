<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\TransaksiPenjualan;
use App\Models\Category;
use App\Services\InsightService;
use App\Services\ReportService;
use Illuminate\Support\Facades\Storage;

class CatalogController extends Controller
{
    protected $insightService;
    protected $reportService;

    public function __construct(InsightService $insightService, ReportService $reportService)
    {
        $this->middleware('auth');
        $this->insightService = $insightService;
        $this->reportService = $reportService;
    }

    public function index()
    {
        $total_menu = Produk::count();
        $total_pendapatan = TransaksiPenjualan::sum('total_harga') ?? 0;
        $total_transaksi = TransaksiPenjualan::count();
        $total_stok_produk = Produk::sum('stok') ?? 0;

        $insight_terlaris = $this->insightService->produkTerlaris();
        $insight_stok_menipis = $this->insightService->stokMenipis();
        $rekomendasi_restock = $this->insightService->rekomendasiRestock();
        $rekomendasi_promosi = $this->insightService->rekomendasiPromosi(2);

        $hari_ini = TransaksiPenjualan::whereDate('tanggal', today())->sum('total_harga') ?? 0;
        $minggu_ini = TransaksiPenjualan::whereBetween('tanggal', [now()->startOfWeek(), now()->endOfWeek()])->sum('total_harga') ?? 0;
        $bulan_ini = TransaksiPenjualan::whereYear('tanggal', now()->year)->whereMonth('tanggal', now()->month)->sum('total_harga') ?? 0;

        return view('dashboard', compact(
            'total_menu', 'total_pendapatan', 'total_transaksi', 'total_stok_produk',
            'insight_terlaris', 'insight_stok_menipis', 'rekomendasi_restock', 'rekomendasi_promosi',
            'hari_ini', 'minggu_ini', 'bulan_ini'
        ));
    }

    public function menuList()
    {
        $menus = Produk::with('category')->get();
        $categories = Category::all();
        return view('dashboard_features.menu_kopi', compact('menus', 'categories'));
    }

    public function kategoriIndex()
    {
        $categories = Category::withCount('produk')->get();
        return view('dashboard_features.kategori', compact('categories'));
    }

    public function storeKategori(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Category::create(['name' => $request->name]);
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function destroyKategori($id)
    {
        Category::findOrFail($id)->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kopi' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'harga' => 'required|integer|min:0',
            'foto_kopi' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $path = $request->file('foto_kopi')->store('foto_produk', 'public');

        Produk::create([
            'category_id' => $request->category_id,
            'nama_kopi' => $request->nama_kopi,
            'harga' => $request->harga,
            'foto_kopi' => $path,
            'stok' => 0,
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambah!');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        if ($produk->foto_kopi) {
            Storage::disk('public')->delete($produk->foto_kopi);
        }
        $produk->delete();
        return redirect()->route('menu.index')->with('success', 'Menu dihapus.');
    }

    // --- FUNGSI LAPORAN (PENYEBAB ERROR TADI) ---
    public function laporanKeuangan()
    {
        $transaksi = TransaksiPenjualan::with('produk')->orderByDesc('tanggal')->get();
        $total_pendapatan = $transaksi->sum('total_harga');

        return view('dashboard_features.laporan', compact('transaksi', 'total_pendapatan'));
    }

    public function exportLaporan(Request $request)
    {
        $filters = [
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
        ];

        $callback = $this->reportService->generateExcel($filters);

        $filename = 'laporan_penjualan_' . now()->format('Y-m-d_His') . '.xlsx';

        return response()->streamDownload(
            function () use ($callback) {
                $callback();
            },
            $filename,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]
        );
    }

    public function exportPDF(Request $request)
    {
        $filters = [
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
        ];

        $pdf = $this->reportService->generatePDF($filters);

        return $pdf->download('laporan_penjualan_' . now()->format('Y-m-d_His') . '.pdf');
    }


    public function hapusPendapatan(Request $request)
    {
        TransaksiPenjualan::truncate();
        return back()->with('success', 'Data laporan berhasil direset.');
    }
}