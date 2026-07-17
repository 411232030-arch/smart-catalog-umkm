<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\AuthSecurityService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $authSecurityService;

    public function __construct(AuthSecurityService $authSecurityService)
    {
        $this->authSecurityService = $authSecurityService;
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        ], [
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, dan angka',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan Login.');
    }

    public function login(Request $request)
    {
        $email = $request->email;

        // Check login rate limiting
        if (!$this->authSecurityService->canAttemptLogin($email)) {
            $minutes = $request->session()->get('lockout_time', 1);
            return back()->with('error', "Terlalu banyak percobaan login. Silakan coba lagi dalam {$minutes} menit.");
        }

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = $this->authSecurityService->verifyCredentials($email, $request->password);

        if (!$user) {
            $this->authSecurityService->recordFailedAttempt($email);
            $remaining = $this->authSecurityService->getRemainingAttempts($email);

            if ($remaining > 0) {
                return back()->with('warning', "Email atau password salah. Sisa percobaan: {$remaining}");
            } else {
                return back()->with('error', 'Akun Anda terkunci karena terlalu banyak percobaan login yang gagal. Coba lagi dalam 15 menit.');
            }
        }

        
        $this->authSecurityService->clearAttempts($email);

       
        Auth::login($user, $request->remember);
        $request->session()->regenerate();

        return redirect()->intended('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Anda berhasil logout');
    }
}
