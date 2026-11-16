<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Penilaian;
use App\Models\AbsensiSiswa;
use App\Models\Ekstrakurikuler;
use App\Models\PendaftaranEkstrakurikuler;
use Illuminate\Support\Facades\DB;
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

        // Pilihan ekstrakurikuler milik siswa yang sedang login
        $pilihan = PendaftaranEkstrakurikuler::where(
            'username',
            session('username')
        )
            ->orderBy('id')
            ->pluck('ekstrakurikuler_id')
            ->map(fn ($id) => (string) $id)
            ->values()
            ->all();

        return view('ekstrakurikuler.index', compact('ekskul', 'pilihan'));
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN PILIHAN EKSTRAKURIKULER SISWA
    |--------------------------------------------------------------------------
    */

    public function simpanPilihan(Request $request)
    {
        if (!session('login') || session('role') !== 'siswa') {
            return redirect()->route('login');
        }

        $request->validate([
            'pilihan' => 'required|array|min:1|max:2',
            'pilihan.*' => 'integer|distinct|exists:ekstrakurikuler,id',
        ], [
            'pilihan.required' => 'Pilih minimal satu ekstrakurikuler.',
            'pilihan.min' => 'Pilih minimal satu ekstrakurikuler.',
            'pilihan.max' => 'Maksimal memilih 2 ekstrakurikuler.',
            'pilihan.*.exists' => 'Ekstrakurikuler yang dipilih tidak ditemukan.',
        ]);

        $username = session('username');
        $pilihan = $request->input('pilihan', []);

        DB::transaction(function () use ($username, $pilihan) {
            PendaftaranEkstrakurikuler::where('username', $username)->delete();

            foreach ($pilihan as $id) {
                PendaftaranEkstrakurikuler::create([
                    'username' => $username,
                    'ekstrakurikuler_id' => $id,
                ]);
            }
        });

        return redirect()
            ->route('ekstrakurikuler')
            ->with('success', 'Pilihan ekstrakurikuler berhasil disimpan.');
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS PILIHAN EKSTRAKURIKULER SISWA
    |--------------------------------------------------------------------------
    */

    public function batalkanPilihan()
    {
        if (!session('login') || session('role') !== 'siswa') {
            return redirect()->route('login');
        }

        PendaftaranEkstrakurikuler::where(
            'username',
            session('username')
        )->delete();

        return redirect()
            ->route('ekstrakurikuler')
            ->with('success', 'Pilihan ekstrakurikuler berhasil dihapus.');
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
            ->with('pendaftaranEkstrakurikuler.ekstrakurikuler')
            ->orderBy('name')
            ->get();

        return view('laporan', $this->dataLaporan($siswa));
    }

    /*
    |--------------------------------------------------------------------------
    | LAPORAN ADMIN
    |--------------------------------------------------------------------------
    */

    public function laporanAdmin()
    {
        $siswa = User::where('role', 'siswa')
            ->with('pendaftaranEkstrakurikuler.ekstrakurikuler')
            ->orderBy('name')
            ->get();

        $data = $this->dataLaporan($siswa);

        $penilaian = Penilaian::latest()->get();
        $dataSiswa = $siswa->keyBy('username');

        // Rincian setiap penilaian untuk laporan admin.
        $data['detailPenilaian'] = $penilaian->map(function ($item) use ($dataSiswa) {
            $user = $dataSiswa->get($item->username);

            return [
                'nama' => data_get($user, 'name', $item->username),
                'kelas' => data_get($user, 'kelas_saat_ini', '-'),
                'kegiatan' => $item->nama_kegiatan ?: '-',
                'nilai' => Penilaian::formatNilai($item->nilai),
                'predikat' => Penilaian::predikatDariNilai($item->nilai),
            ];
        });

        $data['rataNilai'] = $penilaian->isNotEmpty()
            ? Penilaian::formatNilai($penilaian->avg('nilai'))
            : '-';

        return view('admin.laporan', $data);
    }

    /*
    |--------------------------------------------------------------------------
    | DATA LAPORAN
    |--------------------------------------------------------------------------
    */

    private function dataLaporan($daftarSiswa)
    {
        $siswaCollection = collect($daftarSiswa)->values();

        // Kegiatan dari catatan penilaian dan absensi.
        $catatanKegiatan = Penilaian::select('username', 'nama_kegiatan')
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

        // Gabungkan dengan ekstrakurikuler yang sedang didaftarkan siswa.
        $kegiatanPerSiswa = $siswaCollection->mapWithKeys(
            function ($item) use ($catatanKegiatan) {
                $username = data_get($item, 'username');

                $terdaftar = collect(
                    data_get($item, 'pendaftaranEkstrakurikuler', [])
                )->map(
                    fn ($pendaftaran) => data_get(
                        $pendaftaran,
                        'ekstrakurikuler.nama_ekstrakurikuler'
                    )
                );

                $kegiatan = $catatanKegiatan
                    ->get($username, collect())
                    ->merge($terdaftar)
                    ->filter()
                    ->map(fn ($kegiatan) => trim($kegiatan))
                    ->unique()
                    ->sort()
                    ->values();

                return [$username => $kegiatan];
            }
        );

        $penilaianPerSiswa = Penilaian::select('username', 'nilai')
            ->get()
            ->groupBy('username');

        return [
            'totalSiswa' => User::where('role', 'siswa')->count(),

            'totalKegiatan' => $kegiatanPerSiswa
                ->flatten()
                ->filter()
                ->unique()
                ->count(),

            'totalPenilaian' => Penilaian::count(),

            'siswa' => $siswaCollection->map(
                function ($item) use ($kegiatanPerSiswa, $penilaianPerSiswa) {
                    $username = data_get($item, 'username');

                    $kegiatan = $kegiatanPerSiswa
                        ->get($username, collect());

                    $daftarNilai = $penilaianPerSiswa
                        ->get($username, collect())
                        ->pluck('nilai');

                    $rataNilai = $daftarNilai->isNotEmpty()
                        ? round((float) $daftarNilai->avg(), 1)
                        : null;

                    return [
                        'nama' => data_get($item, 'name', '-'),
                        'kelas' => data_get($item, 'kelas_saat_ini')
                            ?? data_get($item, 'kelas', '-'),
                        'ekstrakurikuler' => $kegiatan->isNotEmpty()
                            ? $kegiatan->implode(', ')
                            : '-',
                        'nilai' => $rataNilai !== null
                            ? Penilaian::formatNilai($rataNilai)
                            : '-',
                        'predikat' => $rataNilai !== null
                            ? Penilaian::predikatDariNilai($rataNilai)
                            : '-',
                    ];
                }
            ),
        ];
    }
}
