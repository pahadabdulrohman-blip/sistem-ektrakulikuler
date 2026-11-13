<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Penilaian;
use App\Models\AbsensiSiswa;
use App\Models\Ekstrakurikuler;
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
    | EKSTRAKURIKULER SISWA - DATABASE
    |--------------------------------------------------------------------------
    */

    public function ekstrakurikuler()
    {
        if (!session('login') || session('role') !== 'siswa') {
            return redirect()->route('login');
        }

        // Mengambil seluruh data ekstrakurikuler dari MySQL
        $ekskul = Ekstrakurikuler::orderBy('id', 'asc')->get();

        return view('ekstrakurikuler.index', compact('ekskul'));
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL EKSTRAKURIKULER
    |--------------------------------------------------------------------------
    */

    public function detail($id)
    {
        if (!session('login') || session('role') !== 'siswa') {
            return redirect()->route('login');
        }

        // Mengambil detail berdasarkan ID dari database
        $ekskul = Ekstrakurikuler::findOrFail($id);

        return view('ekstrakurikuler.detail', compact('ekskul'));
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

        $siswa = User::where('username', session('username'))
            ->where('role', 'siswa')
            ->firstOrFail();

        return view('profil', compact('siswa'));
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

        $username = session('username');

        // Mengambil nilai khusus siswa yang sedang login
        $nilai = Penilaian::where('username', $username)
            ->latest()
            ->get();

        return view('siswa.penilaian', compact('nilai'));
    }

    public function detailNilai($id)
    {
        if (!session('login') || session('role') !== 'siswa') {
            return redirect()->route('login');
        }

        // Siswa hanya dapat melihat nilai miliknya sendiri
        $nilai = Penilaian::where('username', session('username'))
            ->where('id', $id)
            ->firstOrFail();

        return view('penilaian.detail', compact('nilai'));
    }

    /*
    |--------------------------------------------------------------------------
    | LAPORAN GURU
    |--------------------------------------------------------------------------
    */

    public function laporanGuru()
    {
        if (!session('login') || session('role') !== 'guru') {
            return redirect()->route('login');
        }

        $siswa = User::where('role', 'siswa')
            ->orderBy('name')
            ->get();

        return view('laporan', $this->dataLaporan($siswa));
    }

    /*
    |--------------------------------------------------------------------------
    | DATA LAPORAN
    |--------------------------------------------------------------------------
    */

    private function dataLaporan($daftarSiswa)
    {
        $kegiatanPerSiswa = Penilaian::select('username', 'nama_kegiatan')
            ->distinct()
            ->get()
            ->concat(
                AbsensiSiswa::select('username', 'nama_kegiatan')
                    ->distinct()
                    ->get()
            )
            ->groupBy('username')
            ->map(function ($rows) {
                return $rows
                    ->pluck('nama_kegiatan')
                    ->filter()
                    ->map(fn ($kegiatan) => trim($kegiatan))
                    ->unique()
                    ->sort()
                    ->values();
            });

        return [
            'totalSiswa' => User::where('role', 'siswa')->count(),

            'totalKegiatan' => $kegiatanPerSiswa
                ->flatten()
                ->unique()
                ->count(),

            'totalPenilaian' => Penilaian::count(),

            'siswa' => collect($daftarSiswa)
                ->values()
                ->map(function ($item) use ($kegiatanPerSiswa) {
                    $kegiatan = $kegiatanPerSiswa->get(
                        data_get($item, 'username')
                    );

                    return [
                        'nama' => data_get($item, 'name', '-'),
                        'kelas' => data_get($item, 'kelas', '-'),
                        'ekstrakurikuler' => $kegiatan
                            ? $kegiatan->implode(', ')
                            : '-',
                    ];
                }),
        ];
    }
}
