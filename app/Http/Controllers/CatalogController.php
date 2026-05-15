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
        
        $request->validate([
            'nama_produk' => 'required|min:3',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            // Membuat nama file unik
            $nama_file = time() . "_" . $file->getClientOriginalName();
            
            // Simpan file ke folder storage/app/public/uploads
            $file->storeAs('public/uploads', $nama_file);

            
            Category::create([
                'name' => $request->nama_produk, 
                'image' => $nama_file,           
            ]);

            return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke katalog!');
        }
    }
}