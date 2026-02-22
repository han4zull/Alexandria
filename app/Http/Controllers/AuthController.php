<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showMasuk()
    {
        return view('akun.masuk');
    }

    public function showDaftar()
    {
        return view('akun.daftar');
    }

    /// ================= REGISTER =================
public function register(Request $request)
{
    $request->validate([
        'username' => 'required|string|max:255',
        'email'    => 'required|email',
        'password' => 'required|min:6',
    ]);

    $email = $request->email;

    if (
        DB::table('admin')->where('email', $email)->exists() ||
        DB::table('petugas')->where('email', $email)->exists() ||
        User::where('email', $email)->exists()
    ) {
        return back()->withErrors(['email' => 'Email sudah terdaftar'])->withInput();
    }

    $lastId = (User::max('id') ?? 0) + 1;
    $noAnggota = 'ALX-' . str_pad($lastId, 5, '0', STR_PAD_LEFT);

    User::create([
        'username' => $request->username,
        'email' => $email,
        'password' => Hash::make($request->password),
        'role' => 'user',
        'no_anggota' => $noAnggota,
        'tanggal_bergabung' => now()->toDateString(),
        'poin' => 0,
    ]);

    // ⛔ JANGAN Auth::login DI SINI
    return redirect()
        ->route('akun.masuk')
        ->with('success', 'Akun berhasil dibuat, silakan login');
}

public function login(Request $request)
{
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    $email = $request->email;
    $password = $request->password;

    // LOGOUT DAN REGENERATE SESSION DULU
    Auth::guard('web')->logout();
    Auth::guard('admin')->logout();
    Auth::guard('petugas')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // COBA ADMIN TERLEBIH DAHULU
    if (Auth::guard('admin')->attempt(['email' => $email, 'password' => $password])) {
        $request->session()->regenerate();
        return redirect()->route('br_admin')->with('success', 'Login admin berhasil');
    }

    // COBA PETUGAS
    if (Auth::guard('petugas')->attempt(['email' => $email, 'password' => $password])) {
        $request->session()->regenerate();
        return redirect()->route('br_petugas')->with('success', 'Login petugas berhasil');
    }

    // COBA USER
    if (Auth::guard('web')->attempt(['email' => $email, 'password' => $password])) {
        $request->session()->regenerate();
        return redirect()->route('br_user')->with('success', 'Login berhasil');
    }

    return back()->withErrors([
        'email' => 'Email atau password salah'
    ])->withInput();
}
    
}