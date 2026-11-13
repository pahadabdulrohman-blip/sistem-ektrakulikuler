
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use App\Http\Controllers\EkstrakurikulerController;
use App\Http\Controllers\AdminEkstrakurikulerController;
use App\Http\Controllers\GuruEkstrakurikulerController;
use App\Http\Controllers\JadwalEkstrakurikulerController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\ProfilePhotoController;

use App\Models\PasswordRequest;
use App\Models\Ekstrakurikuler;

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

        // PENILAIAN

        Route::get('/penilaian', function () {
            return view('admin.penilaian');
        })->name('penilaian');

        // LAPORAN

        Route::get('/laporan', function () {
            return view('admin.laporan');
        })->name('laporan');

        // PROFIL

        Route::get('/profil', function () {
            return view('admin.profil');
        })->name('profil');

        // PERMINTAAN PASSWORD

        Route::get('/password-requests', function () {
            $requests = PasswordRequest::latest()->get();

            return view('password-requests', compact('requests'));
        })->name('password.requests');

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

    // FOTO PROFIL

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
        'role' => 'required|in:admin,guru,siswa',
    ]);

    PasswordRequest::create([
        'username' => $validated['username'],
        'role' => $validated['role'],
        'status' => 'menunggu',
    ]);

    return back()->with(
        'success',
        'Permintaan ubah password berhasil dikirim kepada Admin.'
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
