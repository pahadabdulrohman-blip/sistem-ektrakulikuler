<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;

class AdminEkstrakurikulerController extends Controller
{
    /**
     * DATA AWAL EKSTRAKURIKULER
     */
    private function isiDataAwal(): void
    {
        $dataAwal = [
            [
                'nama_ekstrakurikuler' => 'Futsal',
                'deskripsi' => 'Ekstrakurikuler olahraga futsal.',
                'ikon' => '⚽',
                'pembina' => 'Belum ditentukan',
                'jadwal' => 'Belum ditentukan',
                'tempat' => 'Lapangan Sekolah',
            ],
            [
                'nama_ekstrakurikuler' => 'Coding',
                'deskripsi' => 'Ekstrakurikuler pemrograman dan teknologi.',
                'ikon' => '💻',
                'pembina' => 'Belum ditentukan',
                'jadwal' => 'Belum ditentukan',
                'tempat' => 'Laboratorium Komputer',
            ],
            [
                'nama_ekstrakurikuler' => 'Basket',
                'deskripsi' => 'Ekstrakurikuler olahraga basket.',
                'ikon' => '🏀',
                'pembina' => 'Belum ditentukan',
                'jadwal' => 'Belum ditentukan',
                'tempat' => 'Lapangan Basket',
            ],
            [
                'nama_ekstrakurikuler' => 'Pencak Silat',
                'deskripsi' => 'Ekstrakurikuler bela diri.',
                'ikon' => '🥋',
                'pembina' => 'Belum ditentukan',
                'jadwal' => 'Belum ditentukan',
                'tempat' => 'Aula Sekolah',
            ],
            [
                'nama_ekstrakurikuler' => 'Pramuka',
                'deskripsi' => 'Ekstrakurikuler kepramukaan.',
                'ikon' => '🏕️',
                'pembina' => 'Belum ditentukan',
                'jadwal' => 'Belum ditentukan',
                'tempat' => 'Lapangan Sekolah',
            ],
            [
                'nama_ekstrakurikuler' => 'Voli',
                'deskripsi' => 'Ekstrakurikuler olahraga voli.',
                'ikon' => '🏐',
                'pembina' => 'Belum ditentukan',
                'jadwal' => 'Belum ditentukan',
                'tempat' => 'Lapangan Voli',
            ],
        ];

        foreach ($dataAwal as $data) {
            Ekstrakurikuler::firstOrCreate(
                ['nama_ekstrakurikuler' => $data['nama_ekstrakurikuler']],
                $data
            );
        }
    }

    /**
     * FORMAT DATA UNTUK BLADE LAMA
     */
    private function formatEkskul(Ekstrakurikuler $item): array
    {
        return [
            'id' => $item->id,
            'nama' => $item->nama_ekstrakurikuler,
            'ikon' => $item->ikon ?? '⭐',
            'deskripsi' => $item->deskripsi ?? '-',
            'pembina' => $item->pembina ?? '-',
            'jadwal' => $item->jadwal ?? '-',
            'tempat' => $item->tempat ?? '-',
        ];
    }

    /**
     * HALAMAN UTAMA
     */
    public function index()
    {
        $this->isiDataAwal();

        $ekskul = Ekstrakurikuler::orderBy('id', 'asc')
            ->get()
            ->map(fn ($item) => $this->formatEkskul($item))
            ->all();

        return view('admin.ekstrakurikuler', compact('ekskul'));
    }

    /**
     * FORM TAMBAH
     */
    public function create()
    {
        return view('admin.ekstrakurikuler-create');
    }

    /**
     * VALIDASI FORM
     */
    private function validasiEkskul(Request $request): array
    {
        return $request->validate([
            'nama' => 'required|string|max:100',
            'ikon' => 'nullable|string|max:20',
            'deskripsi' => 'required|string|max:1000',
            'pembina' => 'nullable|string|max:100',
            'jadwal' => 'nullable|string|max:100',
            'tempat' => 'nullable|string|max:150',
        ], [
            'nama.required' => 'Nama ekstrakurikuler wajib diisi.',
            'nama.max' => 'Nama maksimal 100 karakter.',
            'ikon.max' => 'Ikon maksimal 20 karakter.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter.',
            'pembina.max' => 'Nama pembina maksimal 100 karakter.',
            'jadwal.max' => 'Jadwal maksimal 100 karakter.',
            'tempat.max' => 'Tempat maksimal 150 karakter.',
        ]);
    }

    /**
     * SIMPAN DATA BARU
     */
    public function store(Request $request)
    {
        $validated = $this->validasiEkskul($request);

        Ekstrakurikuler::create([
            'nama_ekstrakurikuler' => $validated['nama'],
            'ikon' => $validated['ikon'] ?? '⭐',
            'deskripsi' => $validated['deskripsi'],
            'pembina' => $validated['pembina'] ?? '-',
            'jadwal' => $validated['jadwal'] ?? '-',
            'tempat' => $validated['tempat'] ?? '-',
        ]);

        return redirect()
            ->route('admin.ekstrakurikuler')
            ->with('success', 'Ekstrakurikuler berhasil ditambahkan.');
    }

    /**
     * HALAMAN DETAIL
     */
    public function show($id)
    {
        $item = Ekstrakurikuler::find($id);

        if (!$item) {
            return redirect()
                ->route('admin.ekstrakurikuler')
                ->with('error', 'Data ekstrakurikuler tidak ditemukan.');
        }

        $ekskul = $this->formatEkskul($item);

        return view('admin.ekstrakurikuler-detail', [
            'ekskul' => $ekskul,
            'ekstrakurikuler' => $ekskul,
        ]);
    }

    /**
     * FORM EDIT
     */
    public function edit($id)
    {
        $item = Ekstrakurikuler::find($id);

        if (!$item) {
            return redirect()
                ->route('admin.ekstrakurikuler')
                ->with('error', 'Data ekstrakurikuler tidak ditemukan.');
        }

        $ekskul = $this->formatEkskul($item);

        return view('admin.ekstrakurikuler-edit', [
            'ekskul' => $ekskul,
            'ekstrakurikuler' => $ekskul,
        ]);
    }

    /**
     * UPDATE DATA
     */
    public function update(Request $request, $id)
    {
        $validated = $this->validasiEkskul($request);

        $item = Ekstrakurikuler::find($id);

        if (!$item) {
            return redirect()
                ->route('admin.ekstrakurikuler')
                ->with('error', 'Data ekstrakurikuler tidak ditemukan.');
        }

        $item->update([
            'nama_ekstrakurikuler' => $validated['nama'],
            'ikon' => $validated['ikon'] ?? '⭐',
            'deskripsi' => $validated['deskripsi'],
            'pembina' => $validated['pembina'] ?? '-',
            'jadwal' => $validated['jadwal'] ?? '-',
            'tempat' => $validated['tempat'] ?? '-',
        ]);

        return redirect()
            ->route('admin.ekstrakurikuler')
            ->with('success', 'Ekstrakurikuler berhasil diperbarui.');
    }

    /**
     * HAPUS DATA
     */
    public function destroy($id)
    {
        $item = Ekstrakurikuler::find($id);

        if (!$item) {
            return redirect()
                ->route('admin.ekstrakurikuler')
                ->with('error', 'Data ekstrakurikuler tidak ditemukan.');
        }

        $item->delete();

        return redirect()
            ->route('admin.ekstrakurikuler')
            ->with('success', 'Ekstrakurikuler berhasil dihapus.');
    }
}
