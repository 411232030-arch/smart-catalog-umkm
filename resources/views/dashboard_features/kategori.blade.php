<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Menu - UMKM Coffee</title>
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
                <p class="text-xs text-amber-400/80">Panel Pemilik Toko</p>
            </div>
        </div>
        <nav class="flex-1 p-4 space-y-1.5">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-amber-900/40 text-amber-300"><i class="fas fa-chart-pie w-5 text-center"></i> Ringkasan</a>
            <a href="{{ route('menu.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-amber-900/40 text-amber-300"><i class="fas fa-mug-hot w-5 text-center"></i> Menu Kopi</a>
            <a href="{{ route('kategori.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-amber-800 text-white shadow-md"><i class="fas fa-tags w-5 text-center text-amber-400"></i> Kategori</a>
            <a href="{{ route('pesanan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-amber-900/40 text-amber-300"><i class="fas fa-shopping-basket w-5 text-center"></i> Pesanan</a>
            <a href="{{ route('laporan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-amber-900/40 text-amber-300"><i class="fas fa-wallet w-5 text-center"></i> Keuangan</a>
        </nav>
    </aside>

    <!-- KONTEN -->
    <main class="flex-1 p-6 md:p-8 max-w-7xl mx-auto w-full">
        <header class="mb-8 border-b border-amber-200/60 pb-5">
            <h2 class="text-2xl font-bold text-amber-950 flex items-center gap-2"><i class="fas fa-tags text-amber-700"></i> Pengaturan Kategori Menu</h2>
            <p class="text-sm text-slate-500">Kelompokkan produk kopi Anda (misal: Es Kopi, Hot Coffee, Non-Coffee).</p>
        </header>

        <!-- FORM TAMBAH -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-amber-100 mb-6">
            <form action="{{ route('kategori.store') }}" method="POST" class="flex gap-4">
                @csrf
                <input type="text" name="name" placeholder="Nama Kategori Baru..." required 
                       class="flex-1 border border-amber-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-amber-500 outline-none">
                <button type="submit" class="bg-amber-800 text-white px-6 py-2.5 rounded-xl hover:bg-amber-900 transition font-medium">
                    <i class="fas fa-plus mr-2"></i>Tambah
                </button>
            </form>
        </div>

        <!-- DAFTAR KATEGORI -->
        <div class="bg-white rounded-2xl shadow-sm border border-amber-100 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-amber-50">
                    <tr>
                        <th class="py-4 px-6 font-semibold text-amber-900">Nama Kategori</th>
                        <th class="py-4 px-6 font-semibold text-amber-900 text-center">Jumlah Produk</th>
                        <th class="py-4 px-6 font-semibold text-amber-900 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-amber-100">
                    @forelse($categories as $cat)
                    <tr>
                        <td class="py-4 px-6 font-medium">{{ $cat->name }}</td>
                        <td class="py-4 px-6 text-center text-slate-500">{{ $cat->produk_count }} produk</td>
                        <td class="py-4 px-6 text-center">
                            <form action="{{ route('kategori.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 transition">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="py-10 text-center text-slate-400">Belum ada kategori yang ditambahkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>