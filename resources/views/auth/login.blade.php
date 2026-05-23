<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - UMKM Kopi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-stone-900 flex items-center justify-center h-screen" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1507133750040-4a8f57021571?q=80&w=1200'); background-size: cover; background-position: center;">

    <div class="bg-white/95 backdrop-blur-sm p-8 rounded-2xl shadow-2xl border border-stone-200 w-full max-w-md mx-4">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-amber-700 rounded-full flex items-center justify-center text-white mx-auto mb-3 text-2xl shadow-lg">
                <i class="fas fa-coffee"></i>
            </div>
            <h2 class="text-2xl font-bold text-stone-800">Masuk Dasbor</h2>
            <p class="text-xs text-stone-500 mt-1">Kelola menu dan transaksi UMKM Kopi Anda</p>
        </div>

        @if(session('error'))
            <div class="bg-red-50 text-red-600 text-xs p-3 rounded-xl mb-4 font-semibold border border-red-100">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-stone-600 uppercase tracking-wider mb-2">Email Owner</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border border-stone-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-700" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-stone-600 uppercase tracking-wider mb-2">Password</label>
                <input type="password" name="password" class="w-full border border-stone-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-700" required>
            </div>
            <button type="submit" class="w-full bg-amber-700 hover:bg-amber-800 text-white font-bold py-3 rounded-xl text-sm transition shadow-md shadow-amber-700/30">
                Masuk Sistem
            </button>
        </form>

        <!-- Tambahan Link Daftar -->
        <div class="text-center mt-4">
            <p class="text-xs text-stone-500">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-amber-700 font-bold hover:underline">Daftar di sini</a>
            </p>
        </div>
    </div>

</body>
</html>