<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EkstrakurikulerController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */

    public function login()
    {
        return view('login');
    }

    /*
    |--------------------------------------------------------------------------
    | PROSES LOGIN
    |--------------------------------------------------------------------------
    */

    
public function prosesLogin(Request $request)
{
    $request->validate([
        'role' => 'required|in:admin,guru,siswa',
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    $user = User::where('username', $request->username)
        ->where('role', $request->role)
        ->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return back()
            ->withInput($request->only('username', 'role'))
            ->with('error', 'Username, password, atau role salah!');
    }

    $request->session()->regenerate();

    session([
        'login' => true,
        'role' => $user->role,
        'username' => $user->username,
        'user_id' => $user->id,
    ]);

    return match ($user->role) {
        'admin' => redirect()->route('dashboard.admin'),
        'guru' => redirect()->route('dashboard.guru'),
        'siswa' => redirect()->route('dashboard.siswa'),
    };
}

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        if (!session('login')) {
            return redirect()->route('login');
        }

        switch (session('role')) {
            case 'admin':
                return redirect()->route('dashboard.admin');

            case 'guru':
                return redirect()->route('dashboard.guru');

            case 'siswa':
                return redirect()->route('dashboard.siswa');

            default:
                session()->invalidate();

                return redirect()->route('login');
        }
    }

    /*
    |--------------------------------------------------------------------------
    | EKSTRAKURIKULER
    |--------------------------------------------------------------------------
    */

    public function ekstrakurikuler()
    {
        if (!session('login')) {
            return redirect()->route('login');
        }

        return view('ekstrakurikuler.index');
    }

    public function detail($id)
    {
        if (!session('login')) {
            return redirect()->route('login');
        }

        return view('ekstrakurikuler.detail', compact('id'));
    }

    /*
    |--------------------------------------------------------------------------
    | PROFIL SISWA
    |--------------------------------------------------------------------------
    */

    public function profil()
    {
        if (!session('login') || session('role') !== 'siswa') {
            return redirect()->route('login');
        }

        return view('profil');
    }

    /*
    |--------------------------------------------------------------------------
    | PENILAIAN SISWA
    |--------------------------------------------------------------------------
    */

    public function penilaian()
    {
        if (!session('login') || session('role') !== 'siswa') {
            return redirect()->route('login');
        }

        $nilai = [];

        return view('penilaian', compact('nilai'));
    }

    public function detailNilai($id)
    {
        if (!session('login') || session('role') !== 'siswa') {
            return redirect()->route('login');
        }

        return view('penilaian.detail', compact('id'));
    }

    /*
    |--------------------------------------------------------------------------
    | LAPORAN SISWA
    |--------------------------------------------------------------------------
    */

    public function laporan()
    {
        if (!session('login') || session('role') !== 'siswa') {
            return redirect()->route('login');
        }

        $siswa = [];

        return view('laporan', compact('siswa'));
    }
}
