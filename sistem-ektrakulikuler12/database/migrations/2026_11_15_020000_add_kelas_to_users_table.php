<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('kelas', 10)->nullable()->after('role');
            $table->unsignedSmallInteger('tahun_masuk')->nullable()->after('kelas');
        });

        // Siswa yang sudah terdaftar sebelum kolom kelas ada:
        // dianggap mulai dari kelas X pada tahun ajaran berjalan.
        $tahunAjaran = now()->month >= 7 ? now()->year : now()->year - 1;

        DB::table('users')
            ->where('role', 'siswa')
            ->whereNull('kelas')
            ->update([
                'kelas' => 'X',
                'tahun_masuk' => $tahunAjaran,
            ]);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['kelas', 'tahun_masuk']);
        });
    }
};
