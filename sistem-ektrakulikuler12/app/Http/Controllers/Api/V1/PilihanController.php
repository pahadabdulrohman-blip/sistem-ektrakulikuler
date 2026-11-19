<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\PendaftaranEkstrakurikuler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PilihanController extends ApiController
{
    /**
     * Daftar pilihan ekstrakurikuler siswa yang sedang login.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $pilihan = PendaftaranEkstrakurikuler::where('username', $user->username)
            ->with('ekstrakurikuler')
            ->orderBy('id')
            ->get()
            ->map(fn ($item) => [
                'id' => $item->id,
                'ekstrakurikuler_id' => $item->ekstrakurikuler_id,
                'nama' => optional($item->ekstrakurikuler)->nama_ekstrakurikuler,
            ])
            ->values();

        return $this->sukses([
            'pilihan' => $pilihan,
            'ekstrakurikuler_ids' => $pilihan->pluck('ekstrakurikuler_id')->map(fn ($id) => (string) $id)->values()->all(),
        ]);
    }

    /**
     * Simpan pilihan (menggantikan seluruh pilihan lama), maksimal 2 ekskul.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'pilihan' => 'required|array|min:1|max:2',
            'pilihan.*' => 'integer|distinct|exists:ekstrakurikuler,id',
        ], [
            'pilihan.required' => 'Pilih minimal satu ekstrakurikuler.',
            'pilihan.min' => 'Pilih minimal satu ekstrakurikuler.',
            'pilihan.max' => 'Maksimal memilih 2 ekstrakurikuler.',
            'pilihan.*.exists' => 'Ekstrakurikuler yang dipilih tidak ditemukan.',
        ]);

        $username = $request->user()->username;

        DB::transaction(function () use ($username, $data) {
            PendaftaranEkstrakurikuler::where('username', $username)->delete();

            foreach ($data['pilihan'] as $id) {
                PendaftaranEkstrakurikuler::create([
                    'username' => $username,
                    'ekstrakurikuler_id' => $id,
                ]);
            }
        });

        return $this->sukses(
            ['ekstrakurikuler_ids' => array_map('strval', $data['pilihan'])],
            'Pilihan ekstrakurikuler berhasil disimpan.'
        );
    }

    /**
     * Batalkan seluruh pilihan ekskul siswa.
     */
    public function destroy(Request $request)
    {
        PendaftaranEkstrakurikuler::where('username', $request->user()->username)->delete();

        return $this->sukses(null, 'Pilihan ekstrakurikuler berhasil dihapus.');
    }
}
