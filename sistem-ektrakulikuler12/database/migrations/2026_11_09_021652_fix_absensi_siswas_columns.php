
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::table('absensi_siswas', function (Blueprint $table) {
    $table->string('username')->nullable();
    $table->string('nama_kegiatan')->nullable();
    $table->date('tanggal')->nullable();
    $table->enum('status', ['hadir', 'izin', 'sakit', 'alpa'])->nullable();
    $table->string('dicatat_oleh')->nullable();
});
    }

    public function down(): void
    {
        Schema::table('absensi_siswas', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'nama_kegiatan',
                'tanggal',
                'status',
                'dicatat_oleh',
            ]);
        });
    }
};
