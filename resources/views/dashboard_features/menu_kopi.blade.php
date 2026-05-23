<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Menu Kopi - UMKM Coffee</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-amber-50 text-slate-800 font-sans min-h-screen flex flex-col md:flex-row">

    <!-- SIDEBAR UTAMA -->
    <aside class="w-full md:w-64 bg-amber-950 text-amber-100 flex flex-col shadow-xl">
        <div class="p-5 flex items-center gap-3 border-b border-amber-900/50">
            <div class="bg-amber-600 p-2.5 rounded-xl shadow-inner">
                <i class="fas fa-coffee text-xl text-white"></i>
            </div>
            <div>
                <h1 class="font-bold text-lg leading-tight tracking-wide text-white">UMKM Coffee</h1>
                <p class="text-xs text-amber-400/80 font-medium">Panel Pemilik Toko</p>
            </div>
        </div>
        
        <nav class="flex-1 p-4 space-y-1.5">
            <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200 font-medium hover:bg-amber-900/40 text-amber-300">
                <i class="fas fa-chart-pie w-5 text-center text-lg"></i> Ringkasan
            </a>
            <a href="{{ url('/dashboard/menu') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200 font-medium bg-amber-800 text-white shadow-md">
                <i class="fas fa-mug-hot w-5 text-center text-lg text-amber-400"></i> Menu Kopi
            </a>
            <a href="{{ url('/dashboard/kategori') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200 font-medium hover:bg-amber-900/40 text-amber-300">
                <i class="fas fa-tags w-5 text-center text-lg"></i> Kategori
            </a>
            <a href="{{ url('/dashboard/pesanan') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200 font-medium hover:bg-amber-900/40 text-amber-300">
                <i class="fas fa-shopping-basket w-5 text-center text-lg"></i> Pesanan
            </a>
            <a href="{{ url('/dashboard/laporan') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200 font-medium hover:bg-amber-900/40 text-amber-300">
                <i class="fas fa-wallet w-5 text-center text-lg"></i> Keuangan
            </a>
        </nav>

        <div class="p-4 border-t border-amber-900/50">
            <form action="{{ url('/logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2.5 px-4 py-3 bg-rose-900/40 hover:bg-rose-900/60 text-rose-300 rounded-xl transition duration-200 font-semibold border border-rose-800/30">
                    <i class="fas fa-sign-out-alt"></i> Keluar Sistem
                </button>
            </form>
        </div>
    </aside>

    <!-- KONTEN UTAMA -->
    <main class="flex-1 p-6 md:p-8 max-w-7xl mx-auto w-full">
        <header class="mb-8 border-b border-amber-200/60 pb-5">
            <h2 class="text-2xl font-bold text-amber-950 flex items-center gap-2">
                <i class="fas fa-mug-hot text-amber-700"></i> Kelola Menu Kopi
            </h2>
            <p class="text-sm text-slate-500 mt-0.5">Tambah, lihat, dan hapus varian produk kopi UMKM Anda.</p>
        </header>

        <!-- Pesan Notifikasi Sukses/Gagal -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-900 rounded-r-xl shadow-sm text-sm font-medium flex items-center gap-2 animate-fade-in">
                <i class="fas fa-check-circle text-emerald-600 text-base"></i> {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- SEKSI FORM TAMBAH MENU -->
            <section class="lg:col-span-5 bg-white p-6 rounded-2xl border border-amber-100 shadow-sm">
                <h3 class="font-bold text-lg text-amber-950 mb-5 flex items-center gap-2">
                    <i class="fas fa-plus-circle text-amber-600"></i> Tambah Menu Baru
                </h3>
                <form action="{{ url('/dashboard/menu/store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Produk Kopi</label>
                        <input type="text" name="nama_kopi" required placeholder="Contoh: Es Kopi Susu Gula Aren" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-600/20 focus:border-amber-600 text-sm transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Harga Jual (IDR)</label>
                        <input type="number" name="harga" required placeholder="Rp 18000" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-600/20 focus:border-amber-600 text-sm transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Foto Produk</label>
                        <input type="file" name="foto_kopi" required class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-amber-100 file:text-amber-900 hover:file:bg-amber-200 file:cursor-pointer border border-dashed border-slate-200 p-2 rounded-xl">
                    </div>
                    <button type="submit" class="w-full bg-amber-700 hover:bg-amber-800 text-white font-bold py-3.5 px-4 rounded-xl transition duration-200 shadow-md flex items-center justify-center gap-2 mt-2">
                        <i class="fas fa-folder-plus"></i> Simpan ke Katalog
                    </button>
                </form>
            </section>

            <!-- SEKSI KATALOG DATA MENU -->
            <section class="lg:col-span-7 bg-white rounded-2xl border border-amber-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h3 class="font-bold text-lg text-amber-950 flex items-center gap-2">
                        <i class="fas fa-list-ul text-amber-600"></i> Katalog Menu Saat Ini
                    </h3>
                    <span class="bg-amber-100 text-amber-900 text-xs font-extrabold px-3 py-1 rounded-full shadow-inner">{{ $menus->count() }} Item</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-100 text-slate-400 uppercase text-[11px] font-bold tracking-wider border-b border-slate-200">
                                <th class="py-4 px-6 text-center">Gambar</th>
                                <th class="py-4 px-4">Nama Varian Kopi</th>
                                <th class="py-4 px-4">Harga Menu</th>
                                <th class="py-4 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($menus as $menu)
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="py-4 px-6 text-center">
                                        @if($menu->foto_kopi)
                                            <img src="{{ asset('storage/' . $menu->foto_kopi) }}" alt="Foto {{ $menu->nama_kopi }}" class="w-14 h-14 object-cover rounded-xl shadow-sm mx-auto border border-amber-100">
                                        @else
                                            <div class="w-14 h-14 bg-amber-100 rounded-xl flex items-center justify-center text-amber-800 mx-auto border border-amber-200"><i class="fas fa-image text-xl"></i></div>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4 font-bold text-slate-700">{{ $menu->nama_kopi }}</td>
                                    <td class="py-4 px-4 font-extrabold text-amber-700">Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                                    <td class="py-4 px-6 text-center whitespace-nowrap">
                                        <div class="flex items-center justify-center gap-2">
                                            <!-- TOMBOL BELI (URL DIREK) -->
                                            <form action="{{ url('/dashboard/menu/beli/' . $menu->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-3.5 py-2 rounded-xl transition shadow-sm flex items-center gap-1 cursor-pointer">
                                                    <i class="fas fa-shopping-basket"></i> Beli
                                                </button>
                                            </form>

                                            <!-- TOMBOL HAPUS KATALOG (URL DIREK) -->
                                            <form action="{{ url('/dashboard/menu/' . $menu->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus varian menu ini dari katalog?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 font-medium text-sm p-2 rounded-xl transition border border-rose-100 cursor-pointer">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-12 px-6 text-center text-slate-400">
                                        <i class="fas fa-box-open text-5xl text-amber-200 mb-3"></i>
                                        <p class="font-semibold text-slate-600">Belum ada menu kopi</p>
                                        <p class="text-xs text-slate-400 mt-1">Silakan tambahkan produk baru lewat form di samping kiri.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
            
        </div>
    </main>

</body>
</html>