<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    
    public function showLogin() { return view('auth.login'); }
    public function showRegister() { return view('auth.register'); }

    
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            // Poin 5: Kata sandi dienkripsi aman (Hashing)
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Daftar berhasil! Silakan Login.');
    }

    

     public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        
        return redirect()->intended('/'); 
    }

    return back()->withErrors(['email' => 'Email atau password salah!']);
}
    // Logika Keluar (Logout)
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}