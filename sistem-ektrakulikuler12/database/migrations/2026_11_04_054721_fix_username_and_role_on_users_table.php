<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migrasi ini dulunya duplikat dengan 2026_11_04_051953. Dibuat idempoten
 * supaya migrate pada database baru (termasuk fallback SQLite) tidak berhenti
 * di "duplicate column name: username".
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('users')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'username')) {
                $table->string('username')->nullable()->unique();
            }

            if (! Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'guru', 'siswa'])->default('siswa');
            }
        });
    }

    public function down(): void
    {
        // Sengaja kosong: kolom dikelola migrasi 051953.
    }
};
