
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absensi_siswas', function (Blueprint $table) {
            if (!Schema::hasColumn('absensi_siswas', 'username')) {
                $table->string('username')->nullable();
            }

            if (!Schema::hasColumn('absensi_siswas', 'nama_kegiatan')) {
                $table->string('nama_kegiatan')->nullable();
            }

            if (!Schema::hasColumn('absensi_siswas', 'tanggal')) {
                $table->date('tanggal')->nullable();
            }

            if (!Schema::hasColumn('absensi_siswas', 'status')) {
                $table->enum('status', [
                    'hadir',
                    'izin',
                    'sakit',
                    'alpa'
                ])->nullable();
            }

            if (!Schema::hasColumn('absensi_siswas', 'dicatat_oleh')) {
                $table->string('dicatat_oleh')->nullable();
            }
        });
    }

    public function down(): void
    {
        // Tidak menghapus kolom atau data.
    }
};
