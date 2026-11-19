<?php

use App\Http\Controllers\Api\V1\AbsensiController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\EkstrakurikulerController;
use App\Http\Controllers\Api\V1\FotoController;
use App\Http\Controllers\Api\V1\JadwalController;
use App\Http\Controllers\Api\V1\LaporanController;
use App\Http\Controllers\Api\V1\PenilaianController;
use App\Http\Controllers\Api\V1\PenggunaController;
use App\Http\Controllers\Api\V1\PilihanController;
use App\Http\Controllers\Api\V1\ProfilController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API v1 — AKTIVIA
|--------------------------------------------------------------------------
|
| Semua respons memakai format:
|   { "success": bool, "message": string, "data": mixed, "errors": object? }
|
| Autentikasi: header Authorization: Bearer <token> (token dari /api/v1/login)
|
*/

Route::prefix('v1')->name('api.v1.')->group(function () {

    // ---------------------------------------------------------------- Publik
    Route::post('/register', [AuthController::class, 'register'])
        ->middleware('throttle:6,1')->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])
        ->middleware('throttle:5,1')->name('forgot-password');

    // ------------------------------------------------------- Butuh token
    Route::middleware('api.token')->group(function () {

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/me', [AuthController::class, 'me'])->name('me');
        Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

        Route::get('/profil', [ProfilController::class, 'show'])->name('profil.show');
        Route::get('/profil/foto', [FotoController::class, 'fotoProfil'])->name('profil.foto');
        Route::post('/profil/foto', [FotoController::class, 'uploadProfil'])->name('profil.foto.upload');

        // Ekstrakurikuler — semua role bisa lihat
        Route::get('/ekstrakurikuler', [EkstrakurikulerController::class, 'index'])->name('ekstrakurikuler.index');
        Route::get('/ekstrakurikuler/{id}', [EkstrakurikulerController::class, 'show'])
            ->whereNumber('id')->name('ekstrakurikuler.show');

        // Pilihan ekskul — siswa
        Route::middleware('api.role:siswa')->group(function () {
            Route::get('/pilihan-ekstrakurikuler', [PilihanController::class, 'index'])->name('pilihan.index');
            Route::post('/pilihan-ekstrakurikuler', [PilihanController::class, 'store'])->name('pilihan.store');
            Route::delete('/pilihan-ekstrakurikuler', [PilihanController::class, 'destroy'])->name('pilihan.destroy');

            // Alias mengikuti URI web
            Route::post('/ekstrakurikuler/pilih', [PilihanController::class, 'store']);
            Route::post('/ekstrakurikuler/batal', [PilihanController::class, 'destroy']);
        });

        // Kelola ekskul & galeri — admin/guru
        Route::middleware('api.role:admin,guru')->group(function () {
            Route::post('/ekstrakurikuler', [EkstrakurikulerController::class, 'store'])->name('ekstrakurikuler.store');
            Route::put('/ekstrakurikuler/{id}', [EkstrakurikulerController::class, 'update'])
                ->whereNumber('id')->name('ekstrakurikuler.update');
            Route::delete('/ekstrakurikuler/{id}', [EkstrakurikulerController::class, 'destroy'])
                ->whereNumber('id')->name('ekstrakurikuler.destroy');

            Route::post('/ekstrakurikuler/{id}/foto', [FotoController::class, 'uploadKegiatan'])
                ->whereNumber('id')->name('ekstrakurikuler.foto.store');
            Route::delete('/ekstrakurikuler/{id}/foto/{foto}', [FotoController::class, 'hapusKegiatan'])
                ->whereNumber('id')->whereNumber('foto')->name('ekstrakurikuler.foto.hapus');

            Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
            Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');
        });

        // Jadwal & penilaian — lihat semua role, tulis guru
        Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
        Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
        Route::get('/penilaian/{id}', [PenilaianController::class, 'show'])
            ->whereNumber('id')->name('penilaian.show');

        Route::middleware('api.role:guru')->group(function () {
            Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
            Route::put('/jadwal/{id}', [JadwalController::class, 'update'])
                ->whereNumber('id')->name('jadwal.update');
            Route::delete('/jadwal/{id}', [JadwalController::class, 'destroy'])
                ->whereNumber('id')->name('jadwal.destroy');

            Route::post('/penilaian', [PenilaianController::class, 'store'])->name('penilaian.store');
            Route::put('/penilaian/{id}', [PenilaianController::class, 'update'])
                ->whereNumber('id')->name('penilaian.update');
            Route::delete('/penilaian/{id}', [PenilaianController::class, 'destroy'])
                ->whereNumber('id')->name('penilaian.destroy');
        });

        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

        // ------------------------------------------------------- Admin
        Route::middleware('api.role:admin')->prefix('admin')->name('admin.')->group(function () {
            Route::get('/data-guru', [PenggunaController::class, 'dataGuru'])->name('data-guru');
            Route::get('/data-siswa', [PenggunaController::class, 'dataSiswa'])->name('data-siswa');

            Route::get('/penerimaan-siswa', [PenggunaController::class, 'penerimaanIndex'])->name('penerimaan.index');
            Route::put('/penerimaan-siswa/{id}/terima', [PenggunaController::class, 'terima'])
                ->whereNumber('id')->name('penerimaan.terima');
            Route::put('/penerimaan-siswa/{id}/tolak', [PenggunaController::class, 'tolak'])
                ->whereNumber('id')->name('penerimaan.tolak');

            Route::get('/guru', [PenggunaController::class, 'guruIndex'])->name('guru.index');
            Route::post('/guru', [PenggunaController::class, 'guruStore'])->name('guru.store');
            Route::put('/guru/{id}/reset-password', [PenggunaController::class, 'guruResetPassword'])
                ->whereNumber('id')->name('guru.reset-password');
            Route::delete('/guru/{id}', [PenggunaController::class, 'guruDestroy'])
                ->whereNumber('id')->name('guru.destroy');

            Route::get('/password-requests', [PenggunaController::class, 'passwordRequests'])->name('password-requests.index');
            Route::put('/password-requests/{id}/reset', [PenggunaController::class, 'passwordRequestReset'])
                ->whereNumber('id')->name('password-requests.reset');
            Route::delete('/password-requests/{id}', [PenggunaController::class, 'passwordRequestDestroy'])
                ->whereNumber('id')->name('password-requests.destroy');
        });
    });
});
