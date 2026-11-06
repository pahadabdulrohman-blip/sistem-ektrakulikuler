<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('status_pilihan_ekskul', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->boolean('dikunci')->default(false);
            $table->timestamp('dikunci_pada')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('status_pilihan_ekskul');
    }public function kunci(Request $request)
{
    if (
        !session('login') ||
        session('role') !== 'siswa' ||
        !session('username')
    ) {
        return redirect()->route('login');
    }

    $username = session('username');

    $dikunci = DB::table('status_pilihan_ekskul')
    ->where('username', $username)
    ->where('dikunci', true)
    ->exists();

if ($dikunci) {
    return back()->with(
        'pesan',
        'Pilihan sudah dikunci. Kamu tidak bisa mengubah pilihan ekskul.'
    );
}
    return DB::transaction(function () use ($username) {
        $jumlah = \App\Models\PendaftaranEkstrakurikuler::where(
            'username', $username
        )->count();

        if ($jumlah < 1 || $jumlah > 2) {
            return back()->with(
                'pesan',
                'Pilih 1 atau 2 ekstrakurikuler terlebih dahulu.'
            );
        }

        $status = DB::table('status_pilihan_ekskul')
            ->where('username', $username)
            ->lockForUpdate()
            ->first();

        if ($status && $status->dikunci) {
            return back()->with('pesan', 'Pilihan ekskul sudah dikunci.');
        }

        DB::table('status_pilihan_ekskul')->updateOrInsert(
            ['username' => $username],
            [
                'dikunci' => true,
                'dikunci_pada' => now(),
                'updated_at' => now(),
                'created_at' => $status->created_at ?? now(),
            ]
        );

        return back()->with(
            'pesan',
            'Pilihan ekstrakurikuler berhasil dikunci dan tidak bisa diubah lagi.'
        );
    });
}
};

