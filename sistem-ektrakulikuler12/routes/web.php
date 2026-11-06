
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use App\Http\Controllers\EkstrakurikulerController;
use App\Http\Controllers\AdminEkstrakurikulerController;
use App\Http\Controllers\JadwalEkstrakurikulerController;
use App\Models\PasswordRequest;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\RegisterController;

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
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    if (!session('login')) {
        return redirect()->route('login');
    }

    return match (session('role')) {
        'admin' => redirect()->route('dashboard.admin'),
        'guru'  => redirect()->route('dashboard.guru'),
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
Route::get('/register', [RegisterController::class, 'index'])
    ->name('register');

Route::post('/register', [RegisterController::class, 'store'])
    ->name('register.store');


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware('role:admin')
    ->group(function () {

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
        ])->whereNumber('id')
          ->name('ekstrakurikuler.edit');

        Route::put('/ekstrakurikuler/{id}', [
            AdminEkstrakurikulerController::class,
            'update',
        ])->whereNumber('id')
          ->name('ekstrakurikuler.update');

        Route::delete('/ekstrakurikuler/{id}', [
            AdminEkstrakurikulerController::class,
            'destroy',
        ])->whereNumber('id')
          ->name('ekstrakurikuler.destroy');

        Route::get('/ekstrakurikuler/{id}', [
            AdminEkstrakurikulerController::class,
            'show',
        ])->whereNumber('id')
          ->name('ekstrakurikuler.show');

        Route::get('/penilaian', function () {
            return view('admin.penilaian');
        })->name('penilaian');

        Route::get('/laporan', function () {
            return view('admin.laporan');
        })->name('laporan');

        Route::get('/profil', function () {
            return view('admin.profil');
        })->name('profil');

        Route::get('/password-requests', function () {
            $requests = PasswordRequest::latest()->get();

            return view('password-requests', compact('requests'));
        })->name('password.requests');
        // Absensi Admin
Route::get('/absensi', [AbsensiController::class, 'index'])
    ->name('absensi');

Route::post('/absensi', [AbsensiController::class, 'simpan'])
    ->name('absensi.simpan');
    });


/*
|--------------------------------------------------------------------------
| ALIAS PERMINTAAN PASSWORD ADMIN
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| GURU
|--------------------------------------------------------------------------
*/

Route::middleware('role:guru')->group(function () {

    Route::get('/guru/profil', function () {
        return view('guru.profil');
    })->name('guru.profil');

    Route::get('/guru/kegiatan', function () {
        return view('ekstrakurikuler.index');
    })->name('guru.kegiatan');

    Route::get('/guru/penilaian', function () {
        $nilai = [];

        return view('penilaian', compact('nilai'));
    })->name('guru.penilaian');

    Route::get('/guru/laporan', function () {
        $siswa = [];

        return view('laporan', compact('siswa'));
    })->name('guru.laporan');
    Route::get('/guru/absensi', [AbsensiController::class, 'index'])
    ->name('guru.absensi');

Route::post('/guru/absensi', [AbsensiController::class, 'simpan'])
    ->name('guru.absensi.simpan');
});


/*
|--------------------------------------------------------------------------
| SISWA
|--------------------------------------------------------------------------
*/

Route::middleware('role:siswa')->group(function () {

    Route::get('/ekstrakurikuler', [
        EkstrakurikulerController::class,
        'ekstrakurikuler',
    ])->name('ekstrakurikuler');

    Route::get('/ekstrakurikuler/{id}', [
        EkstrakurikulerController::class,
        'detail',
    ])->whereNumber('id')
      ->name('ekstrakurikuler.detail');

    Route::get('/profil', [
        EkstrakurikulerController::class,
        'profil',
    ])->name('profil');

    Route::get('/profil/foto/{filename}', function ($filename) {
        $filename = basename($filename);
        $path = 'foto-profil/' . $filename;

        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'Foto profil tidak ditemukan.');
        }

        return Storage::disk('public')->response($path);
    })->name('profil.foto');

    Route::post('/profil/foto/upload', function (Request $request) {
    $request->validate([
        'foto' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $filename = $request->file('foto')->hashName();

    $request->file('foto')->storeAs(
        'foto-profil',
        $filename,
        'public'
    );

    return back()->with('success', 'Foto profil berhasil diunggah.');
})->name('profil.foto.upload');

    Route::get('/penilaian', [
        EkstrakurikulerController::class,
        'penilaian',
    ])->name('penilaian');

    Route::get('/penilaian/{id}', [
        EkstrakurikulerController::class,
        'detailNilai',
    ])->whereNumber('id')
      ->name('penilaian.detail');

    Route::get('/laporan', [
        EkstrakurikulerController::class,
        'laporan',
    ])->name('laporan');
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

Route::get('/tes-error-500', function () {
    abort(500);
});