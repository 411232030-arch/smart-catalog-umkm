<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan - UMKM Coffee</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-amber-50 text-slate-800 font-sans min-h-screen flex flex-col md:flex-row">

    <!-- Sidebar Utama -->
    <aside class="w-full md:w-64 bg-amber-950 text-amber-100 flex flex-col shadow-xl">
        <div class="p-5 flex items-center gap-3 border-b border-amber-900/50">
            <div class="bg-amber-600 p-2.5 rounded-xl text-white"><i class="fas fa-coffee text-xl"></i></div>
            <h1 class="font-bold text-lg text-white">UMKM Coffee</h1>
        </div>
        
        <nav class="flex-1 p-4 space-y-1.5">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-amber-900/40 transition">
                <i class="fas fa-chart-pie w-5"></i> Ringkasan
            </a>
            <a href="{{ route('menu.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-amber-900/40 transition">
                <i class="fas fa-mug-hot w-5"></i> Menu Kopi
            </a>
            <a href="{{ route('laporan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-amber-800 text-white shadow-md">
                <i class="fas fa-wallet w-5"></i> Keuangan
            </a>
        </nav>

        <div class="p-4 border-t border-amber-900/50">
            <a href="{{ route('logout') }}" class="w-full flex items-center justify-center gap-2.5 px-4 py-3 bg-rose-900/40 hover:bg-rose-900/60 text-rose-300 rounded-xl transition font-semibold">
                <i class="fas fa-sign-out-alt"></i> Keluar Sistem
            </a>
        </div>
    </aside>

    <!-- Konten Laporan Keuangan -->
    <main class="flex-1 p-6 md:p-8">
        <header class="mb-8 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-amber-950">Laporan Keuangan</h2>
                <p class="text-sm text-slate-500">Pantau omzet penjualan kedai Anda hari ini.</p>
            </div>
            <form action="{{ route('laporan.reset') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengosongkan riwayat kas pendapatan kedai?')">
                @csrf @method('DELETE')
                <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition cursor-pointer shadow-sm">Kosongkan Data</button>
            </form>
        </header>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-100 border border-emerald-200 text-emerald-800 rounded-xl flex items-center gap-2 text-sm font-medium">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl border border-amber-100 shadow-sm flex justify-between items-center">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Pendapatan</p>
                    <h3 class="text-3xl font-black text-slate-800">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-amber-100 p-4 rounded-xl text-amber-700"><i class="fas fa-money-bill-wave text-2xl"></i></div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-amber-100 shadow-sm flex justify-between items-center">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Estimasi Keuntungan Bersih (65%)</p>
                    <h3 class="text-3xl font-black text-emerald-600">Rp {{ number_format($total_pendapatan * 0.65, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-emerald-100 p-4 rounded-xl text-emerald-700"><i class="fas fa-coins text-2xl"></i></div>
            </div>
        </div>
    </main>

</body>
</html>