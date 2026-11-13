<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ekstrakurikuler;

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

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_ekstrakurikuler' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'ikon' => 'nullable|string|max:50',
            'pembina' => 'nullable|string|max:255',
            'jadwal' => 'nullable|string|max:255',
            'tempat' => 'nullable|string|max:255',
        ]);

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

        $data = $request->validate([
            'nama_ekstrakurikuler' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'ikon' => 'nullable|string|max:50',
            'pembina' => 'nullable|string|max:255',
            'jadwal' => 'nullable|string|max:255',
            'tempat' => 'nullable|string|max:255',
        ]);

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
