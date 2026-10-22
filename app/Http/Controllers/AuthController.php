<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DataPenduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'nik' => ['required', 'string'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            if (Auth::user()->peran === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'nik' => 'Kombinasi NIK dan Kata Sandi tidak sesuai.',
        ])->onlyInput('nik');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => ['required', 'string', 'max:16', 'unique:users,nik'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'alamat' => ['required', 'string'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'nik' => $request->nik,
            'no_kk' => $request->no_kk,
            'password' => Hash::make($request->password),
            'peran' => 'warga',
        ]);

        DataPenduduk::create([
            'nik' => $user->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama' => $request->agama,
            'pekerjaan' => $request->pekerjaan,
            'alamat' => $request->alamat,
        ]);

        Auth::login($user);

        return redirect('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
