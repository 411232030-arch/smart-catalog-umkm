<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Storage;

class CatalogController extends Controller
{
    private function pastikanTabelAda() {
        if (!Schema::hasTable('produk')) {
            Schema::create('produk', function (Blueprint $table) {
                $table->id(); $table->string('nama_kopi'); $table->integer('harga'); $table->string('foto_kopi')->nullable(); $table->timestamps();
            });
        }
        if (!Schema::hasTable('transaksi_kopi')) {
            Schema::create('transaksi_kopi', function (Blueprint $table) {
                $table->id(); $table->integer('nominal_pendapatan'); $table->timestamps();
            });
        }
    }

    public function index() { 
        $this->pastikanTabelAda(); 
        $total_menu = DB::table('produk')->count(); 
        $total_pendapatan = DB::table('transaksi_kopi')->sum('nominal_pendapatan') ?? 0; 
        return view('dashboard', compact('total_menu', 'total_pendapatan')); 
    }

    public function menuList() { $this->pastikanTabelAda(); $menus = DB::table('produk')->get(); return view('dashboard_features.menu_kopi', compact('menus')); }
    public function kategoriIndex() { return view('dashboard_features.kategori'); }
    public function laporanKeuangan() { $this->pastikanTabelAda(); $total_pendapatan = DB::table('transaksi_kopi')->sum('nominal_pendapatan') ?? 0; return view('dashboard_features.laporan', compact('total_pendapatan')); }
    
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
}