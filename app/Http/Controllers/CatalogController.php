<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CatalogController extends Controller
{
    public function index()
    {
        $produks = Category::all();
        return view('dashboard', compact('produks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('produk', 'public');
        }

        // Perbaikan: Mapping dari input 'nama_produk' ke kolom database 'name'
        Category::create([
            'name'  => $request->nama_produk,
            'image' => $path ?? null,
        ]);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $produk = Category::findOrFail($id);
        if ($produk->image) {
            Storage::disk('public')->delete($produk->image);
        }
        $produk->delete();
        return redirect()->back()->with('success', 'Produk berhasil dihapus!');
    }
}