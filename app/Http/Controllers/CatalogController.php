<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CatalogController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $user = Auth::user(); 
        return view('dashboard', compact('categories', 'user'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama_produk' => 'required|min:3',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            
            // 2. Buat nama file unik
            $nama_file = time() . "_" . $file->getClientOriginalName();
            
            // 3. Simpan ke storage/app/public/uploads
            $file->storeAs('uploads', $nama_file, 'public');

            // 4. Simpan ke database (Model Category)
            Category::create([
                'name' => $request->nama_produk, 
                'image' => $nama_file,           
            ]);

            return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
        }
    }
}