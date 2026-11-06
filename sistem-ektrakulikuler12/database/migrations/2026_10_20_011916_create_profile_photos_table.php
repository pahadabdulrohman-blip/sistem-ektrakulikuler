<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profile_photos', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('role');
            $table->string('photo_path');
            $table->timestamps();

            $table->unique(['username', 'role']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profile_photos');
    }
};