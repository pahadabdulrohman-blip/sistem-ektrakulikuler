<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ekstrakurikuler', function (Blueprint $table) {
            // Pengaman terakhir di level database agar nama ekskul tidak dobel.
            $table->unique(
                'nama_ekstrakurikuler',
                'ekstrakurikuler_nama_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('ekstrakurikuler', function (Blueprint $table) {
            $table->dropUnique('ekstrakurikuler_nama_unique');
        });
    }
};
