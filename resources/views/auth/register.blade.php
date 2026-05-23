<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - UMKM Kopi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-900 flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md mx-4">
        <h2 class="text-2xl font-bold text-center text-stone-800 mb-6">Daftar Akun Merchant</h2>
        
        <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-stone-600 uppercase">Nama Lengkap</label>
                <input type="text" name="name" class="w-full border border-stone-200 rounded-xl px-4 py-2 mt-1 focus:ring-2 focus:ring-amber-700 outline-none" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-stone-600 uppercase">Alamat Email</label>
                <input type="email" name="email" class="w-full border border-stone-200 rounded-xl px-4 py-2 mt-1 focus:ring-2 focus:ring-amber-700 outline-none" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-stone-600 uppercase">Kata Sandi</label>
                <input type="password" name="password" class="w-full border border-stone-200 rounded-xl px-4 py-2 mt-1 focus:ring-2 focus:ring-amber-700 outline-none" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-stone-600 uppercase">Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" class="w-full border border-stone-200 rounded-xl px-4 py-2 mt-1 focus:ring-2 focus:ring-amber-700 outline-none" required>
            </div>
            <button type="submit" class="w-full bg-amber-700 hover:bg-amber-800 text-white font-bold py-3 rounded-xl transition">
                Daftar Sekarang
            </button>
        </form>
        
        <p class="text-center text-xs text-stone-500 mt-4">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-amber-700 font-bold hover:underline">Masuk di sini</a>
        </p>
    </div>

</body>
</html>