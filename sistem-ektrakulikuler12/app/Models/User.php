<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const DAFTAR_KELAS = ['X', 'XI', 'XII'];

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'status_pendaftaran',
        'nama_sekolah',
        'kelas',
        'tahun_masuk',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'api_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Tahun ajaran berjalan. Tahun ajaran baru dimulai bulan Juli.
     */
    public static function tahunAjaranSekarang(): int
    {
        return now()->month >= 7 ? now()->year : now()->year - 1;
    }

    /**
     * Hitung tahun masuk (saat kelas X) dari kelas yang dipilih saat daftar.
     */
    public static function tahunMasukDariKelas(string $kelas): int
    {
        $mundur = ['X' => 0, 'XI' => 1, 'XII' => 2];

        return static::tahunAjaranSekarang()
            - ($mundur[strtoupper(trim($kelas))] ?? 0);
    }

    /**
     * Kelas siswa saat ini. Otomatis naik setiap tahun ajaran baru
     * tanpa perlu mengubah data absensi atau penilaiannya.
     */
    public function getKelasSaatIniAttribute(): ?string
    {
        if (! $this->tahun_masuk) {
            return $this->kelas;
        }

        $tingkat = 1 + max(
            0,
            static::tahunAjaranSekarang() - (int) $this->tahun_masuk
        );

        return match (true) {
            $tingkat <= 1 => 'X',
            $tingkat === 2 => 'XI',
            $tingkat === 3 => 'XII',
            default => 'Lulus',
        };
    }

    /**
     * Pilihan ekstrakurikuler milik siswa (dihubungkan lewat username).
     */
    public function pendaftaranEkstrakurikuler()
    {
        return $this->hasMany(PendaftaranEkstrakurikuler::class, 'username', 'username');
    }
}
