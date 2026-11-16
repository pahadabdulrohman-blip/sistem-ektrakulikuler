
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use App\Http\Controllers\EkstrakurikulerController;
use App\Http\Controllers\AdminEkstrakurikulerController;
use App\Http\Controllers\AdminGuruController;
use App\Http\Controllers\AdminPasswordRequestController;
use App\Http\Controllers\GuruEkstrakurikulerController;
use App\Http\Controllers\JadwalEkstrakurikulerController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\ProfilePhotoController;

use App\Models\PasswordRequest;
use App\Models\Ekstrakurikuler;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA DAN LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::get('/login', [
    EkstrakurikulerController::class,
    'login',
])->name('login');

Route::post('/login', [
    EkstrakurikulerController::class,
    'prosesLogin',
])->name('login.process');

/*
|--------------------------------------------------------------------------
| REGISTER
|--------------------------------------------------------------------------
*/

Route::get('/register', [
    RegisterController::class,
    'index',
])->name('register');

Route::post('/register', [
    RegisterController::class,
    'store',
])->name('register.store');

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    if (!session('login')) {
        return redirect()->route('login');
    }

    return match (session('role')) {
        'admin' => redirect()->route('dashboard.admin'),
        'guru' => redirect()->route('dashboard.guru'),
        'siswa' => redirect()->route('dashboard.siswa'),
        default => redirect()->route('login'),
    };
})->name('dashboard');

Route::get('/dashboard-admin', function () {
    return view('dashboard-admin');
})->middleware('role:admin')->name('dashboard.admin');

Route::get('/dashboard-guru', function () {
    return view('dashboard-guru');
})->middleware('role:guru')->name('dashboard.guru');

Route::get('/dashboard-siswa', function () {
    return view('dashboard-siswa');
})->middleware('role:siswa')->name('dashboard.siswa');

/*
|--------------------------------------------------------------------------
| LAPORAN UMUM
|--------------------------------------------------------------------------
*/

Route::get('/laporan', function () {
    return redirect()->route('dashboard');
})->name('laporan');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware('role:admin')
    ->group(function () {

        // EKSTRAKURIKULER

        Route::get('/ekstrakurikuler', [
            AdminEkstrakurikulerController::class,
            'index',
        ])->name('ekstrakurikuler');

        Route::get('/ekstrakurikuler/tambah', [
            AdminEkstrakurikulerController::class,
            'create',
        ])->name('ekstrakurikuler.create');

        Route::post('/ekstrakurikuler', [
            AdminEkstrakurikulerController::class,
            'store',
        ])->name('ekstrakurikuler.store');

        Route::get('/ekstrakurikuler/{id}/edit', [
            AdminEkstrakurikulerController::class,
            'edit',
        ])->whereNumber('id')->name('ekstrakurikuler.edit');

        Route::put('/ekstrakurikuler/{id}', [
            AdminEkstrakurikulerController::class,
            'update',
        ])->whereNumber('id')->name('ekstrakurikuler.update');

        Route::delete('/ekstrakurikuler/{id}', [
            AdminEkstrakurikulerController::class,
            'destroy',
        ])->whereNumber('id')->name('ekstrakurikuler.destroy');

        Route::get('/ekstrakurikuler/{id}', [
            AdminEkstrakurikulerController::class,
            'show',
        ])->whereNumber('id')->name('ekstrakurikuler.show');

        // AKUN GURU

        Route::get('/guru', [
            AdminGuruController::class,
            'index',
        ])->name('guru.index');

        Route::post('/guru', [
            AdminGuruController::class,
            'store',
        ])->name('guru.store');

        Route::put('/guru/{id}/reset-password', [
            AdminGuruController::class,
            'resetPassword',
        ])->whereNumber('id')->name('guru.reset');

        Route::delete('/guru/{id}', [
            AdminGuruController::class,
            'destroy',
        ])->whereNumber('id')->name('guru.destroy');

        // PENILAIAN

        Route::get('/penilaian', [
            PenilaianController::class,
            'adminIndex',
        ])->name('penilaian');

        // LAPORAN

        Route::get('/laporan', [
            EkstrakurikulerController::class,
            'laporanAdmin',
        ])->name('laporan');

        // PROFIL

        Route::get('/profil', function () {
            return view('admin.profil');
        })->name('profil');

        // PERMINTAAN PASSWORD

        Route::get('/password-requests', [
            AdminPasswordRequestController::class,
            'index',
        ])->name('password.requests');

        Route::put('/password-requests/{id}/reset', [
            AdminPasswordRequestController::class,
            'reset',
        ])->whereNumber('id')->name('password.requests.reset');

        Route::delete('/password-requests/{id}', [
            AdminPasswordRequestController::class,
            'destroy',
        ])->whereNumber('id')->name('password.requests.destroy');

        // ABSENSI

        Route::get('/absensi', [
            AbsensiController::class,
            'index',
        ])->name('absensi');

        Route::post('/absensi', [
            AbsensiController::class,
            'simpan',
        ])->name('absensi.simpan');
    });

/*
|--------------------------------------------------------------------------
| GURU
|--------------------------------------------------------------------------
*/

Route::prefix('guru')
    ->name('guru.')
    ->middleware('role:guru')
    ->group(function () {

        // PROFIL GURU

        Route::get('/profil', function () {
            return view('guru.profil');
        })->name('profil');

        // DAFTAR EKSTRAKURIKULER

        Route::get('/ekstrakurikuler', [
            GuruEkstrakurikulerController::class,
            'index',
        ])->name('ekstrakurikuler.index');

        // FORM TAMBAH EKSTRAKURIKULER

        Route::get('/ekstrakurikuler/create', [
            GuruEkstrakurikulerController::class,
            'create',
        ])->name('ekstrakurikuler.create');

        // SIMPAN EKSTRAKURIKULER

        Route::post('/ekstrakurikuler', [
            GuruEkstrakurikulerController::class,
            'store',
        ])->name('ekstrakurikuler.store');

        // FORM EDIT EKSTRAKURIKULER

        Route::get('/ekstrakurikuler/{id}/edit', [
            GuruEkstrakurikulerController::class,
            'edit',
        ])->whereNumber('id')
          ->name('ekstrakurikuler.edit');

        // UPDATE EKSTRAKURIKULER

        Route::put('/ekstrakurikuler/{id}', [
            GuruEkstrakurikulerController::class,
            'update',
        ])->whereNumber('id')
          ->name('ekstrakurikuler.update');

        // HAPUS EKSTRAKURIKULER

        Route::delete('/ekstrakurikuler/{id}', [
            GuruEkstrakurikulerController::class,
            'destroy',
        ])->whereNumber('id')
          ->name('ekstrakurikuler.destroy');

        // MENU KEGIATAN LAMA

        Route::get('/kegiatan', function () {
            return redirect()->route('guru.ekstrakurikuler.index');
        })->name('kegiatan');

        // PENILAIAN

        Route::get('/penilaian', [
            PenilaianController::class,
            'index',
        ])->name('penilaian');

        Route::post('/penilaian', [
            PenilaianController::class,
            'simpan',
        ])->name('penilaian.simpan');

        Route::put('/penilaian/{id}', [
            PenilaianController::class,
            'update',
        ])->whereNumber('id')
          ->name('penilaian.update');

        Route::delete('/penilaian/{id}', [
            PenilaianController::class,
            'hapus',
        ])->whereNumber('id')
          ->name('penilaian.hapus');

        // LAPORAN

        Route::get('/laporan', [
            EkstrakurikulerController::class,
            'laporanGuru',
        ])->name('laporan');

        // ABSENSI

        Route::get('/absensi', [
            AbsensiController::class,
            'index',
        ])->name('absensi');

        Route::post('/absensi', [
            AbsensiController::class,
            'simpan',
        ])->name('absensi.simpan');

        // JADWAL KEGIATAN

        Route::get('/jadwal', [
            JadwalEkstrakurikulerController::class,
            'index',
        ])->name('jadwal.index');

        Route::post('/jadwal', [
            JadwalEkstrakurikulerController::class,
            'store',
        ])->name('jadwal.store');

        Route::put('/jadwal/{id}', [
            JadwalEkstrakurikulerController::class,
            'update',
        ])->whereNumber('id')
          ->name('jadwal.update');

        Route::delete('/jadwal/{id}', [
            JadwalEkstrakurikulerController::class,
            'destroy',
        ])->whereNumber('id')
          ->name('jadwal.destroy');
    });

/*
|--------------------------------------------------------------------------
| SISWA
|--------------------------------------------------------------------------
*/

Route::middleware('role:siswa')->group(function () {

    // DAFTAR EKSTRAKURIKULER

    Route::get('/ekstrakurikuler', [
        EkstrakurikulerController::class,
        'ekstrakurikuler',
    ])->name('ekstrakurikuler');

    // SIMPAN / HAPUS PILIHAN EKSTRAKURIKULER

    Route::post('/ekstrakurikuler/pilih', [
        EkstrakurikulerController::class,
        'simpanPilihan',
    ])->name('ekstrakurikuler.simpan');

    Route::post('/ekstrakurikuler/batal', [
        EkstrakurikulerController::class,
        'batalkanPilihan',
    ])->name('ekstrakurikuler.batal');

    // DETAIL EKSTRAKURIKULER

    Route::get('/ekstrakurikuler/{id}', [
        EkstrakurikulerController::class,
        'detail',
    ])->whereNumber('id')->name('ekstrakurikuler.detail');

    // PROFIL SISWA

    Route::get('/profil', [
        EkstrakurikulerController::class,
        'profil',
    ])->name('profil');

    Route::get('/siswa/profil', function () {
        return view('siswa.profil');
    })->name('siswa.profil');

    // PENILAIAN SISWA

    Route::get('/penilaian', [
        EkstrakurikulerController::class,
        'penilaian',
    ])->name('penilaian');

    Route::get('/penilaian/{id}', [
        EkstrakurikulerController::class,
        'detailNilai',
    ])->whereNumber('id')->name('penilaian.detail');
});

/*
|--------------------------------------------------------------------------
| FOTO PROFIL (ADMIN, GURU, SISWA)
|--------------------------------------------------------------------------
*/

Route::middleware('role:admin,guru,siswa')->group(function () {

    // TAMPILKAN FOTO PROFIL

    Route::get('/profil/foto/{filename}', function ($filename) {
        $filename = basename($filename);
        $path = 'foto-profil/' . $filename;

        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'Foto profil tidak ditemukan.');
        }

        return Storage::disk('public')->response($path);
    })->name('profil.foto');

    // UPLOAD FOTO PROFIL

    Route::post('/profil/foto/upload', [
        ProfilePhotoController::class,
        'upload',
    ])->name('profil.foto.upload');
});

/*
|--------------------------------------------------------------------------
| JADWAL EKSTRAKURIKULER
|--------------------------------------------------------------------------
*/

Route::get('/jadwal-ekstrakurikuler', [
    JadwalEkstrakurikulerController::class,
    'index',
])->name('jadwal.ekstrakurikuler');

/*
|--------------------------------------------------------------------------
| LUPA PASSWORD
|--------------------------------------------------------------------------
*/

Route::get('/lupa-password', function () {
    return view('lupa-password');
})->name('password.request');

Route::post('/lupa-password', function (Request $request) {

    $validated = $request->validate([
        'username' => 'required|string|max:255',
        'role' => 'required|in:guru,siswa',
    ]);

    $user = User::where('username', $validated['username'])
        ->where('role', $validated['role'])
        ->first();

    if (! $user) {
        return back()
            ->withInput()
            ->withErrors([
                'username' => 'Akun dengan username dan role tersebut tidak ditemukan.',
            ]);
    }

    if (! $user->email) {
        return back()
            ->withInput()
            ->withErrors([
                'username' => 'Akun tersebut belum memiliki email terdaftar. Hubungi admin.',
            ]);
    }

    $sudahAda = PasswordRequest::where('username', $validated['username'])
        ->where('role', $validated['role'])
        ->where('status', 'menunggu')
        ->exists();

    if ($sudahAda) {
        return back()->with(
            'success',
            'Permintaan ubah password kamu masih diproses admin. Silakan cek email secara berkala.'
        );
    }

    PasswordRequest::create([
        'username' => $validated['username'],
        'role' => $validated['role'],
        'status' => 'menunggu',
    ]);

    return back()->with(
        'success',
        'Permintaan ubah password berhasil dikirim. Password baru akan dikirim ke email terdaftar setelah diproses admin.'
    );

})->name('password.email');

/*
|--------------------------------------------------------------------------
| HUBUNGI ADMIN
|--------------------------------------------------------------------------
*/

Route::get('/hubungi-admin', function () {
    return view('hubungi-admin');
})->name('hubungi.admin');

/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::get('/logout', function () {
    session()->invalidate();
    session()->regenerateToken();

    return redirect()->route('login');
})->name('logout');

/*
|--------------------------------------------------------------------------
| TES ERROR
|--------------------------------------------------------------------------
*/

Route::get('/tes-error-500', function () {
    abort(500);
});
