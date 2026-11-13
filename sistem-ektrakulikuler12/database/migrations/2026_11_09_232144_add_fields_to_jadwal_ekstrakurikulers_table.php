
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_ekstrakurikulers', function (Blueprint $table) {
            $table->string('nama_kegiatan')->nullable();
            $table->string('jenis')->nullable();
            $table->date('tanggal')->nullable();
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
            $table->string('lokasi')->nullable();
            $table->text('keterangan')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_ekstrakurikulers', function (Blueprint $table) {
            $table->dropColumn([
                'nama_kegiatan',
                'jenis',
                'tanggal',
                'jam_mulai',
                'jam_selesai',
                'lokasi',
                'keterangan',
            ]);
        });
    }
};
