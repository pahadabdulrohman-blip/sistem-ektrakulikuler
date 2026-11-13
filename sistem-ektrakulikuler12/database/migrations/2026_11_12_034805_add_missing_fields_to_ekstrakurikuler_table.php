<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ekstrakurikuler', function (Blueprint $table) {
            $table->string('nama_ekstrakurikuler')->nullable();
            $table->string('pembina')->nullable();
            $table->string('jadwal')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('ikon')->nullable();
            $table->string('tempat')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('ekstrakurikuler', function (Blueprint $table) {
            $table->dropColumn([
                'nama_ekstrakurikuler',
                'pembina',
                'jadwal',
                'deskripsi',
                'ikon',
                'tempat',
            ]);
        });
    }
};