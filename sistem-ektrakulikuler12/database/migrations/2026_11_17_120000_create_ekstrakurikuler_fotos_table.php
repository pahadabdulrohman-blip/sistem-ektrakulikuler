<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ekstrakurikuler_fotos', function (Blueprint $table) {
            $table->id();

            // Foto otomatis terhapus dari database bila ekskulnya dihapus.
            $table->foreignId('ekstrakurikuler_id')
                ->constrained('ekstrakurikuler')
                ->cascadeOnDelete();

            // Lokasi file di storage/app/public (contoh: foto-kegiatan/3/abc.jpg).
            $table->string('foto_path');
            $table->string('keterangan')->nullable();
            $table->string('diunggah_oleh')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ekstrakurikuler_fotos');
    }
};
