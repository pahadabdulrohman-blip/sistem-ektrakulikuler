<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ekstrakurikuler', function (Blueprint $table) {
            if (!Schema::hasColumn('ekstrakurikuler', 'ikon')) {
                $table->string('ikon')->nullable();
            }

            if (!Schema::hasColumn('ekstrakurikuler', 'tempat')) {
                $table->string('tempat')->nullable();
            }
        });
    }

    public function down(): void
    {
        // Tidak menghapus kolom agar data tetap aman.
    }
};