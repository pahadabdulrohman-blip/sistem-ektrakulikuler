<?php

namespace App\Http\Controllers\Api\V1;

use App\Mail\PasswordBaruMail;
use App\Models\PasswordRequest;
use App\Models\ProfilePhoto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class PenggunaController extends ApiController
{
    private const STATUS_VALID = ['menunggu', 'diterima', 'ditolak'];

    // ------------------------------------------------------ Data pengguna

    public function dataGuru()
    {
        $guru = User::where('role', 'guru')->orderBy('name')->get()
            ->map(fn ($item) => $this->formatUser($item))
            ->values();

        return $this->sukses([
            'guru' => $guru,
            'total' => $guru->count(),
        ]);
    }

    public function dataSiswa()
    {
        $siswa = User::where('role', 'siswa')->orderBy('name')->get();

        $jumlahPerKelas = $siswa
            ->countBy(fn ($item) => data_get($item, 'kelas_saat_i') ?: 'Belum diisi')
            ->sortKeys();

        return $this->sukses([
            'siswa' => $siswa->map(fn ($item) => $this->formatUser($item))->values(),
            'total' => $siswa->count(),
            'jumlah_per_kelas' => $jumlahPerKelas,
        ]);
    }

    // -------------------------------------------------- Penerimaan siswa

    public function penerimaanIndex(Request $request)
    {
        $status = (string) $request->query('status', 'menunggu');

        if (! in_array($status, array_merge(self::STATUS_VALID, ['semua']), true)) {
            $status = 'menunggu';
        }

        $query = User::where('role', 'siswa');

        if ($status !== 'semua') {
            $query->where('status_pendaftaran', $status);
        }

        $siswa = $query->orderByDesc('created_at')->orderBy('name')->get();

        return $this->sukses([
            'status' => $status,
            'siswa' => $siswa->map(fn ($item) => $this->formatUser($item))->values(),
            'jumlah' => [
                'menunggu' => User::where('role', 'siswa')->where('status_pendaftaran', 'menunggu')->count(),
                'diterima' => User::where('role', 'siswa')->where('status_pendaftaran', 'diterima')->count(),
                'ditolak' => User::where('role', 'siswa')->where('status_pendaftaran', 'ditolak')->count(),
            ],
        ]);
    }

    public function terima(int $id)
    {
        return $this->ubahStatus($id, 'diterima', 'berhasil diterima.');
    }

    public function tolak(int $id)
    {
        return $this->ubahStatus($id, 'ditolak', 'berhasil ditolak.');
    }

    private function ubahStatus(int $id, string $status, string $keterangan)
    {
        $siswa = User::where('role', 'siswa')->findOrFail($id);
        $siswa->update(['status_pendaftaran' => $status]);

        return $this->sukses(
            $this->formatUser($siswa->fresh()),
            'Pendaftaran siswa '.$siswa->name.' '.$keterangan
        );
    }

    // ------------------------------------------------------- Akun guru

    public function guruIndex()
    {
        $guru = User::where('role', 'guru')->orderBy('name')->get()
            ->map(fn ($item) => $this->formatUser($item))
            ->values();

        return $this->sukses(['guru' => $guru, 'total' => $guru->count()]);
    }

    public function guruStore(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ], [
            'name.required' => 'Nama guru wajib diisi.',
            'username.required' => 'Username guru wajib diisi.',
            'username.unique' => 'Username sudah dipakai akun lain.',
            'email.required' => 'Email guru wajib diisi.',
            'email.unique' => 'Email sudah dipakai akun lain.',
            'password.required' => 'Password awal wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $data['role'] = 'guru';
        $data['kelas'] = null;
        $data['tahun_masuk'] = null;

        $guru = User::create($data);

        return $this->sukses($this->formatUser($guru), 'Akun guru berhasil dibuat.', 201);
    }

    public function guruResetPassword(Request $request, int $id)
    {
        $data = $request->validate([
            'password' => 'required|string|min:8',
        ], [
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $guru = User::where('role', 'guru')->findOrFail($id);
        $guru->update(['password' => $data['password']]);

        return $this->sukses(null, 'Password guru '.$guru->name.' berhasil diubah.');
    }

    public function guruDestroy(Request $request, int $id)
    {
        $guru = User::where('role', 'guru')->findOrFail($id);

        if ($guru->username === $request->user()->username) {
            return $this->gagal('Akun yang sedang dipakai tidak dapat dihapus.', 403);
        }

        $foto = ProfilePhoto::where('username', $guru->username)->where('role', 'guru')->first();

        if ($foto?->photo_path) {
            foreach (['local', 'public'] as $disk) {
                if (Storage::disk($disk)->exists($foto->photo_path)) {
                    Storage::disk($disk)->delete($foto->photo_path);
                }
            }
        }

        $foto?->delete();
        PasswordRequest::where('username', $guru->username)->delete();
        $guru->delete();

        return $this->sukses(null, 'Akun guru berhasil dihapus.');
    }

    // -------------------------------------------- Permintaan password

    public function passwordRequests()
    {
        $requests = PasswordRequest::latest()->get();
        $pengguna = User::whereIn('username', $requests->pluck('username'))
            ->get()->keyBy('username');

        return $this->sukses([
            'password_requests' => $requests->map(fn ($item) => [
                'id' => $item->id,
                'username' => $item->username,
                'role' => $item->role,
                'status' => $item->status,
                'nama' => data_get($pengguna->get($item->username), 'name', $item->username),
                'created_at' => optional($item->created_at)->toISOString(),
            ])->values(),
            'total' => $requests->count(),
        ]);
    }

    public function passwordRequestReset(Request $request, int $id)
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

            return $this->gagal(
                'Akun dengan username '.$permintaan->username.' tidak ditemukan. Permintaan ditandai gagal.',
                404
            );
        }

        if (! in_array($user->role, ['siswa', 'guru'], true)) {
            return $this->gagal('Permintaan ini bukan dari akun siswa atau guru.', 422);
        }

        if (! $user->email) {
            return $this->gagal('Akun '.$user->name.' belum memiliki email terdaftar.', 422);
        }

        $password = filled($data['password'] ?? null) ? $data['password'] : Str::random(10);

        $mailer = config('mail.default');
        $mailerConfig = config('mail.mailers.'.$mailer, []);
        $pengirimanAktif = ! in_array($mailer, ['log', 'array'], true)
            && filled($mailerConfig['username'] ?? null)
            && filled($mailerConfig['password'] ?? null);

        if (! $pengirimanAktif && ! app()->environment('local')) {
            return $this->gagal(
                'Email belum aktif. Atur SMTP di file .env sebelum mereset password agar password baru bisa dikirim ke pengguna.',
                422
            );
        }

        $user->update(['password' => $password]);
        $permintaan->update(['status' => 'selesai']);

        $terkirim = false;

        if ($pengirimanAktif) {
            try {
                Mail::to($user->email)->send(new PasswordBaruMail($user, $password));
                $terkirim = true;
            } catch (Throwable $e) {
                report($e);
            }
        }

        $pesan = 'Password akun '.$user->name.' berhasil diubah.';

        if ($terkirim) {
            $pesan .= ' Password baru sudah dikirim ke '.$user->email.'.';
        } elseif (app()->environment('local') && ! $pengirimanAktif) {
            $pesan .= ' Email belum aktif (MAIL_MAILER='.$mailer.' atau kredensial SMTP belum diisi), password baru: '.$password.'. Atur Gmail SMTP di file .env agar email benar-benar terkirim.';
        } else {
            $pesan .= ' Email gagal dikirim. Password baru tidak ditampilkan; silakan reset ulang setelah SMTP diperbaiki.';
        }

        return $this->sukses([
            'username' => $user->username,
            'status' => $permintaan->status,
            'email' => $user->email,
            'email_terkirim' => $terkirim,
        ], $pesan);
    }

    public function passwordRequestDestroy(int $id)
    {
        PasswordRequest::findOrFail($id)->delete();

        return $this->sukses(null, 'Permintaan ubah password berhasil dihapus.');
    }
}
