<?php

namespace App\Http\Controllers;

use App\Mail\PasswordBaruMail;
use App\Models\PasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

class AdminPasswordRequestController extends Controller
{
    public function index()
    {
        $requests = PasswordRequest::latest()->get();

        // Data pengguna yang meminta reset password (nama dan email).
        $pengguna = User::whereIn('username', $requests->pluck('username'))
            ->get()
            ->keyBy('username');

        return view('password-requests', compact('requests', 'pengguna'));
    }

    /**
     * Proses permintaan: admin mengubah password lalu password baru
     * dikirim ke email pengguna yang terdaftar.
     */
    public function reset(Request $request, $id)
    {
        $data = $request->validate([
            'password' => 'nullable|string|min:8|max:50',
        ], [
            'password.min' => 'Password minimal 8 karakter.',
            'password.max' => 'Password maksimal 50 karakter.',
        ]);

        $permintaan = PasswordRequest::findOrFail($id);

        $user = User::where('username', $permintaan->username)->first();

        if (! $user) {
            $permintaan->update(['status' => 'gagal']);

            return redirect()
                ->route('admin.password.requests')
                ->withErrors([
                    'password' => 'Akun dengan username '
                        . $permintaan->username
                        . ' tidak ditemukan. Permintaan ditandai gagal.',
                ]);
        }

        if (! in_array($user->role, ['siswa', 'guru'], true)) {
            return redirect()
                ->route('admin.password.requests')
                ->withErrors([
                    'password' => 'Permintaan ini bukan dari akun siswa atau guru.',
                ]);
        }

        if (! $user->email) {
            return redirect()
                ->route('admin.password.requests')
                ->withErrors([
                    'password' => 'Akun ' . $user->name
                        . ' belum memiliki email terdaftar.',
                ]);
        }

        // Admin boleh mengisi password sendiri; jika kosong dibuat otomatis.
        $password = filled($data['password'] ?? null)
            ? $data['password']
            : Str::random(10);

        $mailer = config('mail.default');
        $mailerConfig = config('mail.mailers.' . $mailer, []);

        // Mailer "log"/"array" hanya mencatat pesan, tidak mengirim ke email.
        // Kredensial SMTP juga harus terisi agar email benar-benar terkirim.
        $pengirimanAktif = ! in_array($mailer, ['log', 'array'], true)
            && filled($mailerConfig['username'] ?? null)
            && filled($mailerConfig['password'] ?? null);

        // Di server produksi, password baru tidak boleh ditampilkan di layar.
        // Jadi reset ditolak sampai email benar-benar bisa mengirim password.
        if (! $pengirimanAktif && ! app()->environment('local')) {
            return redirect()
                ->route('admin.password.requests')
                ->withErrors([
                    'password' => 'Email belum aktif. Atur SMTP di file .env '
                        . 'sebelum mereset password agar password baru bisa '
                        . 'dikirim ke pengguna.',
                ]);
        }

        $user->update([
            'password' => $password,
        ]);

        $permintaan->update([
            'status' => 'selesai',
        ]);

        $terkirim = $pengirimanAktif;

        if ($pengirimanAktif) {
            try {
                Mail::to($user->email)->send(
                    new PasswordBaruMail($user, $password)
                );
            } catch (Throwable $e) {
                $terkirim = false;
                report($e);
            }
        }

        $pesan = 'Password akun ' . $user->name . ' berhasil diubah.';

        if ($terkirim) {
            $pesan .= ' Password baru sudah dikirim ke ' . $user->email . '.';
        } elseif (! $pengirimanAktif && app()->environment('local')) {
            // Hanya untuk pengembangan lokal agar admin tetap bisa login.
            $pesan .= ' Email belum aktif (MAIL_MAILER=' . $mailer
                . ' atau kredensial SMTP belum diisi), password baru: ' . $password
                . '. Atur Gmail SMTP di file .env agar email benar-benar terkirim.';
        } else {
            $pesan .= ' Email gagal dikirim. Password baru tidak ditampilkan; '
                . 'silakan reset ulang setelah SMTP diperbaiki.';
        }

        return redirect()
            ->route('admin.password.requests')
            ->with('success', $pesan)
            ->with('mail_gagal', ! $terkirim);
    }

    /**
     * Hapus permintaan tanpa mengubah password.
     */
    public function destroy($id)
    {
        PasswordRequest::findOrFail($id)->delete();

        return redirect()
            ->route('admin.password.requests')
            ->with('success', 'Permintaan ubah password berhasil dihapus.');
    }
}
