<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penilaians', function (Blueprint $table) {
            $table->string('username')->nullable();
            $table->string('nama_kegiatan')->nullable();
            $table->decimal('nilai', 5, 2)->nullable();
            $table->text('keterangan')->nullable();
            $table->string('dicatat_oleh')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('penilaians', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'nama_kegiatan',
                'nilai',
                'keterangan',
                'dicatat_oleh',
            ]);
        });
    }
};