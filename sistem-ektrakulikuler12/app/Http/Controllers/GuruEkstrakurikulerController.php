<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ekstrakurikuler;
use Illuminate\Validation\ValidationException;

class GuruEkstrakurikulerController extends Controller
{
    public function index()
    {
        $ekskul = Ekstrakurikuler::orderBy('id', 'desc')->get();

        return view('guru.ekstrakurikuler.index', compact('ekskul'));
    }

    public function create()
    {
        return view('guru.ekstrakurikuler.form', [
            'item' => new Ekstrakurikuler(),
            'judul' => 'Tambah Ekstrakurikuler',
            'action' => route('guru.ekstrakurikuler.store'),
            'method' => 'POST',
        ]);
    }

    /**
     * Validasi data ekstrakurikuler sekaligus menolak nama yang sudah ada.
     */
    private function validasiEkstrakurikuler(Request $request, ?int $abaikanId = null): array
    {
        // Rapikan spasi di awal/akhir sebelum divalidasi.
        $request->merge([
            'nama_ekstrakurikuler' => trim((string) $request->input('nama_ekstrakurikuler')),
        ]);

        $data = $request->validate([
            'nama_ekstrakurikuler' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'ikon' => 'nullable|string|max:50',
            'pembina' => 'nullable|string|max:255',
            'jadwal' => 'nullable|string|max:255',
            'tempat' => 'nullable|string|max:255',
        ]);

        // Samakan spasi ganda / spasi tersembunyi menjadi satu spasi.
        $data['nama_ekstrakurikuler'] = Ekstrakurikuler::rapikanNama(
            $data['nama_ekstrakurikuler']
        );

        // Cek nama yang sama (tidak membedakan huruf besar/kecil dan spasi).
        if (Ekstrakurikuler::namaSudahAda($data['nama_ekstrakurikuler'], $abaikanId)) {
            throw ValidationException::withMessages([
                'nama_ekstrakurikuler' => 'Ekstrakurikuler "'
                    . $data['nama_ekstrakurikuler']
                    . '" sudah terdaftar.',
            ]);
        }

        return $data;
    }

    public function store(Request $request)
    {
        $data = $this->validasiEkstrakurikuler($request);

        Ekstrakurikuler::create($data);

        return redirect()->route('guru.ekstrakurikuler.index')
            ->with('success', 'Ekstrakurikuler berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $item = Ekstrakurikuler::findOrFail($id);

        return view('guru.ekstrakurikuler.form', [
            'item' => $item,
            'judul' => 'Edit Ekstrakurikuler',
            'action' => route('guru.ekstrakurikuler.update', $id),
            'method' => 'PUT',
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = Ekstrakurikuler::findOrFail($id);

        $data = $this->validasiEkstrakurikuler($request, (int) $id);

        $item->update($data);

        return redirect()->route('guru.ekstrakurikuler.index')
            ->with('success', 'Ekstrakurikuler berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = Ekstrakurikuler::findOrFail($id);
        $item->delete();

        return redirect()->route('guru.ekstrakurikuler.index')
            ->with('success', 'Ekstrakurikuler berhasil dihapus.');
    }
}
