<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CatalogController extends Controller
{
    public function index() {
        $total_menu = DB::table('produk')->count();
        $total_pendapatan = DB::table('transaksi_kopi')->sum('nominal_pendapatan') ?? 0;
        return view('dashboard', compact('total_menu', 'total_pendapatan'));
    }

    public function menuList() { $menus = DB::table('produk')->get(); return view('dashboard_features.menu_kopi', compact('menus')); }
    public function kategoriIndex() { return view('dashboard_features.kategori'); }
    public function laporanKeuangan() { $total_pendapatan = DB::table('transaksi_kopi')->sum('nominal_pendapatan') ?? 0; return view('dashboard_features.laporan', compact('total_pendapatan')); }

    public function store(Request $request) {
        $request->validate(['nama_kopi' => 'required', 'harga' => 'required', 'foto_kopi' => 'required|image']);
        $path = $request->file('foto_kopi')->store('foto_produk', 'public');
        DB::table('produk')->insert(['nama_kopi' => $request->nama_kopi, 'harga' => $request->harga, 'foto_kopi' => $path, 'created_at' => now(), 'updated_at' => now()]);
        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambah!');
    }

    public function beli($id) {
        $menu = DB::table('produk')->where('id', $id)->first();
        if ($menu) { DB::table('transaksi_kopi')->insert(['nominal_pendapatan' => $menu->harga, 'created_at' => now()]); }
        return redirect()->route('menu.index')->with('success', 'Pembelian sukses!');
    }

    public function destroy($id) {
        $menu = DB::table('produk')->where('id', $id)->first();
        if ($menu && $menu->foto_kopi) Storage::disk('public')->delete($menu->foto_kopi);
        DB::table('produk')->where('id', $id)->delete();
        return redirect()->route('menu.index')->with('success', 'Menu dihapus.');
    }

    public function hapusPendapatan() { DB::table('transaksi_kopi')->truncate(); return redirect()->route('laporan.index')->with('success', 'Laporan dikosongkan.'); }

    public function exportLaporan()
    {
        $transaksi = DB::table('transaksi_kopi')->orderBy('created_at', 'asc')->get();
        $total_pendapatan = $transaksi->sum('nominal_pendapatan');
        $total_keuntungan = $total_pendapatan * 0.65;

        $filename = 'laporan_keuangan_umkm_coffee_' . now()->format('Y-m-d_His') . '.xls';

        $headers = [
            'Content-Type'        => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($transaksi, $total_pendapatan, $total_keuntungan) {
            echo "\xEF\xBB\xBF";
            echo '<table border="1">';
            echo '<tr><th colspan="3" style="font-size:14px;background:#78350f;color:#fff;">LAPORAN KEUANGAN - UMKM COFFEE</th></tr>';
            echo '<tr><th colspan="3">Dicetak: ' . now()->format('d-m-Y H:i') . '</th></tr>';
            echo '<tr></tr>';
            echo '<tr style="background:#fde68a;font-weight:bold;">';
            echo '<td>No</td><td>Tanggal Transaksi</td><td>Nominal Pendapatan (Rp)</td>';
            echo '</tr>';

            foreach ($transaksi as $index => $row) {
                echo '<tr>';
                echo '<td>' . ($index + 1) . '</td>';
                echo '<td>' . \Carbon\Carbon::parse($row->created_at)->format('d-m-Y H:i') . '</td>';
                echo '<td>' . number_format($row->nominal_pendapatan, 0, ',', '.') . '</td>';
                echo '</tr>';
            }

            echo '<tr></tr>';
            echo '<tr style="font-weight:bold;"><td colspan="2">Total Pendapatan</td><td>' . number_format($total_pendapatan, 0, ',', '.') . '</td></tr>';
            echo '<tr style="font-weight:bold;color:#059669;"><td colspan="2">Estimasi Keuntungan Bersih (65%)</td><td>' . number_format($total_keuntungan, 0, ',', '.') . '</td></tr>';
            echo '</table>';
        };

        return response()->stream($callback, 200, $headers);
    }
}