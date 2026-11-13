<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penilaian;
use App\Models\User;

class PenilaianController extends Controller
{
    public function index()
    {
        $siswa = User::where('role', 'siswa')
            ->orderBy('name')
            ->get();

        $nilai = Penilaian::latest()->get();

        return view('penilaian', [
            'siswa' => $siswa,
            'nilai' => $nilai,
        ]);
    }

    public function simpan(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|exists:users,username',
            'nama_kegiatan' => 'required|string|max:100',
            'nilai' => 'required|numeric|min:0|max:100',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        $siswa = User::where('username', $data['username'])
            ->where('role', 'siswa')
            ->first();

        if (!$siswa) {
            return back()->withErrors([
                'username' => 'Akun yang dipilih bukan akun siswa.'
            ])->withInput();
        }

        $data['dicatat_oleh'] = session('username');

        Penilaian::create($data);

        return redirect()->route('guru.penilaian')
            ->with('success', 'Penilaian berhasil disimpan.');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        $penilaian = Penilaian::findOrFail($id);
        $penilaian->update($data);

        return redirect()->route('guru.penilaian')
            ->with('success', 'Penilaian berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $penilaian = Penilaian::findOrFail($id);
        $penilaian->delete();

        return redirect()->route('guru.penilaian')
            ->with('success', 'Penilaian berhasil dihapus.');
    }
}
