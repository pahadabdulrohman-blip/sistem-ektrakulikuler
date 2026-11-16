@php
    $rekapEkskul = collect($rekapEkskul ?? []);

    $totalPendaftar = $totalPendaftar ?? $rekapEkskul->sum('jumlah_pendaftar');
    $totalPenilaianRekap = $rekapEkskul->sum('jumlah_penilaian');
    $totalNilai = $totalNilai ?? $rekapEkskul->sum('total_nilai');
    $totalHadir = $totalHadir ?? $rekapEkskul->sum('hadir');
    $totalAbsensi = $totalAbsensi ?? $rekapEkskul->sum('total_absensi');
@endphp

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Ekstrakurikuler</th>
            <th>Pendaftar<br><small>(COUNT)</small></th>
            <th>Penilaian<br><small>(COUNT)</small></th>
            <th>Total Nilai<br><small>(SUM)</small></th>
            <th>Rata-rata<br><small>(AVG)</small></th>
            <th>Hadir</th>
            <th>Izin</th>
            <th>Sakit</th>
            <th>Alpa</th>
            <th>% Hadir</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($rekapEkskul as $index => $rekap)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $rekap['nama'] }}</td>
                <td>{{ number_format($rekap['jumlah_pendaftar'], 0, ',', '.') }}</td>
                <td>{{ number_format($rekap['jumlah_penilaian'], 0, ',', '.') }}</td>
                <td class="nilai">
                    {{ \App\Models\Penilaian::formatNilai($rekap['total_nilai']) }}
                </td>
                <td class="nilai">
                    {{ $rekap['rata_nilai'] !== null
                        ? \App\Models\Penilaian::formatNilai($rekap['rata_nilai'])
                        : '-' }}
                </td>
                <td>{{ number_format($rekap['hadir'], 0, ',', '.') }}</td>
                <td>{{ number_format($rekap['izin'], 0, ',', '.') }}</td>
                <td>{{ number_format($rekap['sakit'], 0, ',', '.') }}</td>
                <td>{{ number_format($rekap['alpa'], 0, ',', '.') }}</td>
                <td>{{ $rekap['persen_hadir'] }}%</td>
            </tr>
        @empty
            <tr>
                <td colspan="11" class="empty">
                    Belum ada data ekstrakurikuler untuk direkap.
                </td>
            </tr>
        @endforelse
    </tbody>

    @if ($rekapEkskul->isNotEmpty())
        <tfoot>
            <tr style="background:#f8fafc; font-weight:bold;">
                <td colspan="2">Total</td>
                <td>{{ number_format($totalPendaftar, 0, ',', '.') }}</td>
                <td>{{ number_format($totalPenilaianRekap, 0, ',', '.') }}</td>
                <td class="nilai">
                    {{ \App\Models\Penilaian::formatNilai($totalNilai) }}
                </td>
                <td>-</td>
                <td>{{ number_format($totalHadir, 0, ',', '.') }}</td>
                <td>{{ number_format($rekapEkskul->sum('izin'), 0, ',', '.') }}</td>
                <td>{{ number_format($rekapEkskul->sum('sakit'), 0, ',', '.') }}</td>
                <td>{{ number_format($rekapEkskul->sum('alpa'), 0, ',', '.') }}</td>
                <td>
                    {{ $totalAbsensi > 0
                        ? (int) round($totalHadir / $totalAbsensi * 100)
                        : 0 }}%
                </td>
            </tr>
        </tfoot>
    @endif
</table>
