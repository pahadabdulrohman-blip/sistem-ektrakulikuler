<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
                'ikon' => 'F',
                'pembina' => 'Belum ditentukan',
                'jadwal' => 'Belum ditentukan',
                'tempat' => 'Lapangan Sekolah',
            ],
            [
                'nama_ekstrakurikuler' => 'Coding',
                'deskripsi' => 'Ekstrakurikuler pemrograman dan teknologi.',
                'ikon' => 'C',
                'pembina' => 'Belum ditentukan',
                'jadwal' => 'Belum ditentukan',
                'tempat' => 'Laboratorium Komputer',
            ],
            [
                'nama_ekstrakurikuler' => 'Basket',
                'deskripsi' => 'Ekstrakurikuler olahraga basket.',
                'ikon' => 'B',
                'pembina' => 'Belum ditentukan',
                'jadwal' => 'Belum ditentukan',
                'tempat' => 'Lapangan Basket',
            ],
            [
                'nama_ekstrakurikuler' => 'Pencak Silat',
                'deskripsi' => 'Ekstrakurikuler bela diri.',
                'ikon' => 'PS',
                'pembina' => 'Belum ditentukan',
                'jadwal' => 'Belum ditentukan',
                'tempat' => 'Aula Sekolah',
            ],
            [
                'nama_ekstrakurikuler' => 'Pramuka',
                'deskripsi' => 'Ekstrakurikuler kepramukaan.',
                'ikon' => 'PR',
                'pembina' => 'Belum ditentukan',
                'jadwal' => 'Belum ditentukan',
                'tempat' => 'Lapangan Sekolah',
            ],
            [
                'nama_ekstrakurikuler' => 'Voli',
                'deskripsi' => 'Ekstrakurikuler olahraga voli.',
                'ikon' => 'V',
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
            'ikon' => $item->ikon ?: strtoupper(substr($item->nama_ekstrakurikuler, 0, 1)),
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
    private function validasiEkskul(Request $request, ?int $abaikanId = null): array
    {
        // Rapikan spasi di awal/akhir sebelum divalidasi.
        $request->merge([
            'nama' => trim((string) $request->input('nama')),
        ]);

        $validated = $request->validate([
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

        // Samakan spasi ganda menjadi satu spasi.
        $validated['nama'] = preg_replace('/\s+/', ' ', $validated['nama']);

        // Cek nama yang sama (tidak membedakan huruf besar/kecil).
        $duplikat = Ekstrakurikuler::query()
            ->whereRaw('LOWER(TRIM(nama_ekstrakurikuler)) = ?', [
                mb_strtolower($validated['nama']),
            ])
            ->when($abaikanId, fn ($query) => $query->where('id', '!=', $abaikanId))
            ->exists();

        if ($duplikat) {
            throw ValidationException::withMessages([
                'nama' => 'Ekstrakurikuler "' . $validated['nama'] . '" sudah terdaftar.',
            ]);
        }

        return $validated;
    }

    /**
     * SIMPAN DATA BARU
     */
    public function store(Request $request)
    {
        $validated = $this->validasiEkskul($request);

        Ekstrakurikuler::create([
            'nama_ekstrakurikuler' => $validated['nama'],
            'ikon' => ($validated['ikon'] ?? '') ?: strtoupper(substr($validated['nama'], 0, 1)),
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
        $validated = $this->validasiEkskul($request, (int) $id);

        $item = Ekstrakurikuler::find($id);

        if (!$item) {
            return redirect()
                ->route('admin.ekstrakurikuler')
                ->with('error', 'Data ekstrakurikuler tidak ditemukan.');
        }

        $item->update([
            'nama_ekstrakurikuler' => $validated['nama'],
            'ikon' => ($validated['ikon'] ?? '') ?: strtoupper(substr($validated['nama'], 0, 1)),
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
