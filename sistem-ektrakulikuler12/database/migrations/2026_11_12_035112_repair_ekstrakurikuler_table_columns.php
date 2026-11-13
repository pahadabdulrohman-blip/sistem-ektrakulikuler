<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $columns = [
            'nama_ekstrakurikuler' => 'string',
            'pembina' => 'string',
            'jadwal' => 'string',
            'deskripsi' => 'text',
            'ikon' => 'string',
            'tempat' => 'string',
        ];

        foreach ($columns as $column => $type) {
            if (!Schema::hasColumn('ekstrakurikuler', $column)) {
                Schema::table('ekstrakurikuler', function (Blueprint $table) use ($column, $type) {
                    if ($type === 'text') {
                        $table->text($column)->nullable();
                    } else {
                        $table->string($column)->nullable();
                    }
                });
            }
        }
    }

    public function down(): void
    {
        // Tidak menghapus kolom agar data tetap aman.
    }
};