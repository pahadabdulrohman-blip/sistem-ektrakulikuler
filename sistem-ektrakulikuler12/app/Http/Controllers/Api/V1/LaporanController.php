<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\AbsensiSiswa;
use App\Models\Ekstrakurikuler;
use App\Models\Penilaian;
use App\Models\PendaftaranEkstrakurikuler;
use App\Models\User;
use Illuminate\Http\Request;

class LaporanController extends ApiController
{
    /**
     * Laporan kegiatan ekstrakurikuler. Admin mendapat detail penilaian tambahan.
     */
    public function index(Request $request)
    {
        $siswa = User::where('role', 'siswa')
            ->with('pendaftaranEkstrakurikuler.ekstrakurikuler')
            ->orderBy('name')->get();

        $data = $this->dataLaporan($siswa);

        if (strtolower(trim((string) $request->user()->role)) === 'admin') {
            $penilaian = Penilaian::latest()->get();
            $dataSiswa = $siswa->keyBy('username');

            $data['detail_penilaian'] = $penilaian->map(function ($item) use ($dataSiswa) {
                $pengguna = $dataSiswa->get($item->username);

                return [
                    'nama' => data_get($pengguna, 'name', $item->username),
                    'kelas' => data_get($pengguna, 'kelas_saat_ini', '-'),
                    'kegiatan' => $item->nama_kegiatan ?: '-',
                    'nilai' => Penilaian::formatNilai($item->nilai),
                    'predikat' => Penilaian::predikatDariNilai($item->nilai),
                ];
            })->values()->all();

            $data['rata_nilai'] = $penilaian->isNotEmpty()
                ? Penilaian::formatNilai($penilaian->avg('nilai')) : '-';
        }

        return $this->sukses($data);
    }

    private function rekapEkstrakurikuler(): array
    {
        $ekskul = Ekstrakurikuler::orderBy('nama_ekstrakurikuler')->get();

        $pendaftar = PendaftaranEkstrakurikuler::selectRaw('ekstrakurikuler_id, COUNT(*) as jumlah')
            ->groupBy('ekstrakurikuler_id')->pluck('jumlah', 'ekstrakurikuler_id');

        $penilaian = Penilaian::selectRaw(
            'LOWER(TRIM(nama_kegiatan)) as nama_kegiatan, '
            .'COUNT(*) as jumlah_penilaian, SUM(nilai) as total_nilai, AVG(nilai) as rata_nilai'
        )
            ->whereNotNull('nama_kegiatan')->where('nama_kegiatan', '!=', '')
            ->groupByRaw('LOWER(TRIM(nama_kegiatan))')
            ->get()->keyBy('nama_kegiatan');

        $absensi = AbsensiSiswa::selectRaw(
            'LOWER(TRIM(nama_kegiatan)) as nama_kegiatan, status, COUNT(*) as jumlah'
        )
            ->whereNotNull('nama_kegiatan')->where('nama_kegiatan', '!=', '')
            ->groupByRaw('LOWER(TRIM(nama_kegiatan)), status')
            ->get()->groupBy('nama_kegiatan');

        return $ekskul->map(function ($item) use ($pendaftar, $penilaian, $absensi) {
            $kunci = mb_strtolower(trim((string) $item->nama_ekstrakurikuler));
            $nilai = $penilaian->get($kunci);
            $absen = $absensi->get($kunci, collect())->keyBy('status');

            $hadir = (int) data_get($absen->get('hadir'), 'jumlah', 0);
            $izin = (int) data_get($absen->get('izin'), 'jumlah', 0);
            $sakit = (int) data_get($absen->get('sakit'), 'jumlah', 0);
            $alpa = (int) data_get($absen->get('alpa'), 'jumlah', 0);
            $totalAbsensi = $hadir + $izin + $sakit + $alpa;

            return [
                'id' => $item->id,
                'nama' => $item->nama_ekstrakurikuler,
                'jumlah_pendaftar' => (int) data_get($pendaftar, $item->id, 0),
                'jumlah_penilaian' => (int) data_get($nilai, 'jumlah_penilaian', 0),
                'total_nilai' => (float) data_get($nilai, 'total_nilai', 0),
                'rata_nilai' => $nilai ? (float) data_get($nilai, 'rata_nilai', 0) : null,
                'hadir' => $hadir,
                'izin' => $izin,
                'sakit' => $sakit,
                'alpa' => $alpa,
                'total_absensi' => $totalAbsensi,
                'persen_hadir' => $totalAbsensi > 0 ? (int) round($hadir / $totalAbsensi * 100) : 0,
            ];
        })->values()->all();
    }

    private function dataLaporan($daftarSiswa): array
    {
        $rekap = $this->rekapEkstrakurikuler();

        $kegiatan = collect()
            ->merge(Penilaian::whereNotNull('nama_kegiatan')->where('nama_kegiatan', '!=', '')->pluck('nama_kegiatan'))
            ->merge(AbsensiSiswa::whereNotNull('nama_kegiatan')->where('nama_kegiatan', '!=', '')->pluck('nama_kegiatan'))
            ->merge($daftarSiswa->flatMap(
                fn ($siswa) => $siswa->pendaftaranEkstrakurikuler
                    ->pluck('ekstrakurikuler.nama_ekstrakurikuler')
            ))
            ->map(fn ($nama) => trim((string) $nama))
            ->filter()
            ->unique()
            ->sort()
            ->values();

        $siswaData = $daftarSiswa->map(function ($siswa) {
            $rata = Penilaian::where('username', $siswa->username)->avg('nilai');
            $nilaiRata = $rata !== null ? (float) $rata : null;

            return [
                'nama' => $siswa->name,
                'kelas' => data_get($siswa, 'kelas_saat_ini') ?: ($siswa->kelas ?: '-'),
                'ekstrakurikuler' => $siswa->pendaftaranEkstrakurikuler
                    ->pluck('ekstrakurikuler.nama_ekstrakurikuler')->filter()->implode(', ') ?: '-',
                'nilai' => $nilaiRata !== null ? Penilaian::formatNilai($nilaiRata) : '-',
                'predikat' => $nilaiRata !== null ? Penilaian::predikatDariNilai($nilaiRata) : '-',
            ];
        })->values()->all();

        return [
            'total_siswa' => User::where('role', 'siswa')->count(),
            'total_kegiatan' => $kegiatan->count(),
            'daftar_kegiatan' => $kegiatan->all(),
            'total_penilaian' => Penilaian::count(),
            'rekap_ekstrakurikuler' => $rekap,
            'total_pendaftar' => array_sum(array_column($rekap, 'jumlah_pendaftar')),
            'total_nilai' => array_sum(array_column($rekap, 'total_nilai')),
            'total_hadir' => array_sum(array_column($rekap, 'hadir')),
            'total_absensi' => array_sum(array_column($rekap, 'total_absensi')),
            'siswa' => $siswaData,
        ];
    }
}
