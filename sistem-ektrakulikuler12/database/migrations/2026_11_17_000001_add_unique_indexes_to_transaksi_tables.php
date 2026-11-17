<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Pengaman terakhir di level database agar data transaksi tidak dobel.
 * Sebelum indeks unik dipasang, baris duplikat lama (kalau ada) dibersihkan
 * dengan menyisakan data terbaru.
 */
return new class extends Migration
{
    public function up(): void
    {
        // 1 siswa hanya punya 1 nilai untuk 1 kegiatan.
        $this->hapusDuplikat('penilaians', ['username', 'nama_kegiatan']);

        // 1 siswa hanya punya 1 absensi untuk 1 kegiatan pada 1 tanggal.
        $this->hapusDuplikat(
            'absensi_siswas',
            ['username', 'nama_kegiatan', 'tanggal']
        );

        // 1 kegiatan tidak boleh dijadwalkan dua kali di tanggal & jam sama.
        $this->hapusDuplikat(
            'jadwal_ekstrakurikulers',
            ['nama_kegiatan', 'tanggal', 'jam_mulai']
        );

        Schema::table('penilaians', function (Blueprint $table) {
            $table->unique(
                ['username', 'nama_kegiatan'],
                'penilaian_unik'
            );
        });

        Schema::table('absensi_siswas', function (Blueprint $table) {
            $table->unique(
                ['username', 'nama_kegiatan', 'tanggal'],
                'absensi_unik'
            );
        });

        Schema::table('jadwal_ekstrakurikulers', function (Blueprint $table) {
            $table->unique(
                ['nama_kegiatan', 'tanggal', 'jam_mulai'],
                'jadwal_unik'
            );
        });
    }

    public function down(): void
    {
        Schema::table('penilaians', function (Blueprint $table) {
            $table->dropUnique('penilaian_unik');
        });

        Schema::table('absensi_siswas', function (Blueprint $table) {
            $table->dropUnique('absensi_unik');
        });

        Schema::table('jadwal_ekstrakurikulers', function (Blueprint $table) {
            $table->dropUnique('jadwal_unik');
        });
    }

    /**
     * Simpan hanya baris dengan id terbesar untuk setiap kombinasi kolom.
     */
    private function hapusDuplikat(string $tabel, array $kolom): void
    {
        $daftarKolom = implode(', ', $kolom);

        DB::statement(
            "DELETE FROM {$tabel}
             WHERE id NOT IN (
                 SELECT id FROM (
                     SELECT MAX(id) AS id
                     FROM {$tabel}
                     GROUP BY {$daftarKolom}
                 ) AS baris_dipertahankan
             )"
        );
    }
};
