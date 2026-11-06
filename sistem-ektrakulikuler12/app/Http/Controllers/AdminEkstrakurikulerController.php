<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminEkstrakurikulerController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DATA EKSTRAKURIKULER
    |--------------------------------------------------------------------------
    */

    private function dataEkskul()
    {
        return [
            1 => [
                'id' => 1,
                'nama' => 'Futsal',
                'deskripsi' => 'Ekstrakurikuler olahraga futsal.',
                'icon' => '⚽',
            ],

            2 => [
                'id' => 2,
                'nama' => 'Coding',
                'deskripsi' => 'Ekstrakurikuler pemrograman dan teknologi.',
                'icon' => '💻',
            ],

            3 => [
                'id' => 3,
                'nama' => 'Basket',
                'deskripsi' => 'Ekstrakurikuler olahraga basket.',
                'icon' => '🏀',
            ],

            4 => [
                'id' => 4,
                'nama' => 'Pencak Silat',
                'deskripsi' => 'Ekstrakurikuler bela diri.',
                'icon' => '🥋',
            ],

            5 => [
                'id' => 5,
                'nama' => 'Pramuka',
                'deskripsi' => 'Ekstrakurikuler kepramukaan.',
                'icon' => '🏕️',
            ],

            6 => [
                'id' => 6,
                'nama' => 'Voli',
                'deskripsi' => 'Ekstrakurikuler olahraga voli.',
                'icon' => '🏐',
            ],
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $ekskul = $this->dataEkskul();

        return view('admin.ekstrakurikuler', compact('ekskul'));
    }


    /*
    |--------------------------------------------------------------------------
    | TAMBAH
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('admin.ekstrakurikuler.create');
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
            'icon' => 'nullable',
        ]);

        // Untuk sementara data disimpan di session
        $data = session()->get('ekskul_tambahan', []);

        $id = 7;

        if (!empty($data)) {
            $id = max(array_keys($data)) + 1;
        }

        $data[$id] = [
            'id' => $id,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'icon' => $request->icon ?: '⭐',
        ];

        session()->put('ekskul_tambahan', $data);

        return redirect()
            ->route('admin.ekstrakurikuler')
            ->with('success', 'Ekstrakurikuler berhasil ditambahkan.');
    }


    /*
    |--------------------------------------------------------------------------
    | DETAIL / KELOLA
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $ekskul = $this->dataEkskul();

        // Gabungkan data tambahan
        $tambahan = session()->get('ekskul_tambahan', []);

        $ekskul = $ekskul + $tambahan;

        if (!isset($ekskul[$id])) {
            return redirect()
                ->route('admin.ekstrakurikuler')
                ->with('error', 'Data ekstrakurikuler tidak ditemukan.');
        }

        return view(
            'admin.ekstrakurikuler.show',
            [
                'ekskul' => $ekskul[$id]
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $ekskul = $this->dataEkskul();

        $tambahan = session()->get('ekskul_tambahan', []);

        $ekskul = $ekskul + $tambahan;

        if (!isset($ekskul[$id])) {
            return redirect()
                ->route('admin.ekstrakurikuler')
                ->with('error', 'Data tidak ditemukan.');
        }

        return view(
            'admin.ekstrakurikuler.edit',
            [
                'ekskul' => $ekskul[$id]
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
            'icon' => 'nullable',
        ]);

        $data = session()->get('ekskul_tambahan', []);

        if (!isset($data[$id])) {
            return redirect()
                ->route('admin.ekstrakurikuler')
                ->with('error', 'Data bawaan tidak dapat diubah.');
        }

        $data[$id] = [
            'id' => $id,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'icon' => $request->icon ?: '⭐',
        ];

        session()->put('ekskul_tambahan', $data);

        return redirect()
            ->route('admin.ekstrakurikuler')
            ->with('success', 'Ekstrakurikuler berhasil diperbarui.');
    }


    /*
    |--------------------------------------------------------------------------
    | HAPUS
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $data = session()->get('ekskul_tambahan', []);

        if (isset($data[$id])) {
            unset($data[$id]);

            session()->put('ekskul_tambahan', $data);
        }

        return redirect()
            ->route('admin.ekstrakurikuler')
            ->with('success', 'Ekstrakurikuler berhasil dihapus.');
    }
}