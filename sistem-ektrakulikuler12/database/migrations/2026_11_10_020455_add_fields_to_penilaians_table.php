<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penilaians', function (Blueprint $table) {
            if (!Schema::hasColumn('penilaians', 'username')) {
                $table->string('username')->nullable();
            }

            if (!Schema::hasColumn('penilaians', 'nama_kegiatan')) {
                $table->string('nama_kegiatan')->nullable();
            }

            if (!Schema::hasColumn('penilaians', 'nilai')) {
                $table->decimal('nilai', 5, 2)->nullable();
            }

            if (!Schema::hasColumn('penilaians', 'keterangan')) {
                $table->text('keterangan')->nullable();
            }

            if (!Schema::hasColumn('penilaians', 'dicatat_oleh')) {
                $table->string('dicatat_oleh')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('penilaians', function (Blueprint $table) {
            $columns = [
                'username',
                'nama_kegiatan',
                'nilai',
                'keterangan',
                'dicatat_oleh',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('penilaians', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};