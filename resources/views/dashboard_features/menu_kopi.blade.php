<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Kopi - UMKM Coffee</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-amber-50 text-slate-800 font-sans min-h-screen flex flex-col md:flex-row">
    <!-- SIDEBAR -->
    <aside class="w-full md:w-64 bg-amber-950 text-amber-100 flex flex-col shadow-xl">
        <div class="p-5 flex items-center gap-3 border-b border-amber-900/50">
            <div class="bg-amber-600 p-2.5 rounded-xl"><i class="fas fa-coffee text-xl text-white"></i></div>
            <div>
                <h1 class="font-bold text-lg text-white">UMKM Coffee</h1>
            </div>
        </div>
        <nav class="flex-1 p-4 space-y-1.5">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-amber-900/40 text-amber-300"><i class="fas fa-chart-pie w-5 text-center"></i> Ringkasan</a>
            <a href="{{ route('menu.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-amber-800 text-white shadow-md"><i class="fas fa-mug-hot w-5 text-center text-amber-400"></i> Menu Kopi</a>
            <a href="{{ route('kategori.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-amber-900/40 text-amber-300"><i class="fas fa-tags w-5 text-center"></i> Kategori</a>
            <a href="{{ route('pesanan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-amber-900/40 text-amber-300"><i class="fas fa-shopping-basket w-5 text-center"></i> Pesanan</a>
            <a href="{{ route('laporan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-amber-900/40 text-amber-300"><i class="fas fa-wallet w-5 text-center"></i> Keuangan</a>
        </nav>
    </aside>

    <!-- KONTEN -->
    <main class="flex-1 p-6 md:p-8 max-w-7xl mx-auto w-full">
        <header class="mb-8">
            <h2 class="text-2xl font-bold text-amber-950">Kelola Menu Kopi</h2>
        </header>

        <!-- FORM TAMBAH MENU BARU -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-amber-100 mb-8">
            <h3 class="font-bold text-amber-950 mb-4"><i class="fas fa-plus-circle text-amber-700 mr-2"></i>Tambah Menu Baru</h3>
            <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf
                <input type="text" name="nama_kopi" placeholder="Nama Kopi" required class="border border-amber-200 rounded-xl px-4 py-2.5 outline-none">
                
                <select name="category_id" required class="border border-amber-200 rounded-xl px-4 py-2.5 outline-none">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                
                <input type="number" name="harga" placeholder="Harga" required class="border border-amber-200 rounded-xl px-4 py-2.5 outline-none">
                <input type="file" name="foto_kopi" required class="border border-amber-200 rounded-xl px-4 py-2">
                
                <button type="submit" class="md:col-span-2 bg-amber-800 text-white py-2.5 rounded-xl hover:bg-amber-900 transition font-medium">Simpan Menu</button>
            </form>
        </div>

        <!-- FORM TAMBAH STOK (DIPERBAIKI) -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-amber-100 mb-8">
            <h3 class="font-bold text-amber-950 mb-4"><i class="fas fa-boxes text-amber-700 mr-2"></i>Tambah Stok Produk</h3>
            <form action="{{ route('pesanan.store-stok-masuk') }}" method="POST" class="flex flex-wrap gap-4">
                @csrf
                <select name="produk_id" required class="border border-amber-200 rounded-xl px-4 py-2.5 flex-1 outline-none">
                    <option value="">-- Pilih Menu --</option>
                    @foreach($menus as $menu)
                        <option value="{{ $menu->id }}">{{ $menu->nama_kopi }} (Stok: {{ $menu->stok }})</option>
                    @endforeach
                </select>
                
                <!-- Nama input diubah menjadi 'qty' agar sesuai dengan validasi di Controller -->
                <input type="number" name="qty" placeholder="Jumlah" required min="1" class="border border-amber-200 rounded-xl px-4 py-2.5 w-32 outline-none">
                
                <button type="submit" class="bg-amber-800 text-white px-6 py-2.5 rounded-xl hover:bg-amber-900 transition cursor-pointer">
                    Update Stok
                </button>
            </form>
        </div>

        <!-- DAFTAR MENU -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($menus as $menu)
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-amber-100 flex items-center gap-4">
                <img src="{{ asset('storage/' . $menu->foto_kopi) }}" class="w-16 h-16 rounded-xl object-cover">
                <div class="flex-1">
                    <p class="font-bold text-amber-950">{{ $menu->nama_kopi }}</p>
                    <p class="text-sm text-slate-500">Stok: <span class="font-bold text-amber-700">{{ $menu->stok }} unit</span></p>
                </div>
                <form action="{{ route('menu.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Hapus menu ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-400 hover:text-red-600"><i class="fas fa-trash"></i></button>
                </form>
            </div>
            @endforeach
        </div>
    </main>
</body>
</html>