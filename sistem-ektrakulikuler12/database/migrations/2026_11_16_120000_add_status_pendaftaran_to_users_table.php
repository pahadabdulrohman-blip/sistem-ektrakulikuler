<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'status_pendaftaran')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('status_pendaftaran', 20)
                    ->default('diterima')
                    ->after('role');
            });
        }

        // Akun yang sudah ada sebelum fitur ini dianggap sudah diterima.
        DB::table('users')
            ->whereNull('status_pendaftaran')
            ->update(['status_pendaftaran' => 'diterima']);
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'status_pendaftaran')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('status_pendaftaran');
            });
        }
    }
};
