<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EkstrakurikulerController extends Controller
{
    public function login()
    {
        return view('login');
    }


    public function prosesLogin(Request $request)
    {
        return redirect()->route('dashboard');
    }


    public function dashboard()
    {
        return view('dashboard');
    }


    public function ekstrakurikuler()
    {
        $ekskul = [
            [
                'id' => 1,
                'nama' => 'Futsal',
                'kategori' => 'Olahraga',
                'jadwal' => 'Senin & Kamis',
                'pembina' => 'Pak A',
                'warna' => 'blue'
            ],
            [
                'id' => 2,
                'nama' => 'Seni',
                'kategori' => 'Seni & Budaya',
                'jadwal' => 'Selasa',
                'pembina' => 'Bu B',
                'warna' => 'purple'
            ],
            [
                'id' => 3,
                'nama' => 'Coding',
                'kategori' => 'Teknologi',
                'jadwal' => 'Rabu & Jumat',
                'pembina' => 'Pak C',
                'warna' => 'dark'
            ],
            [
                'id' => 4,
                'nama' => 'Pencak Silat',
                'kategori' => 'Olahraga',
                'jadwal' => 'Senin & Rabu',
                'pembina' => 'Pak D',
                'warna' => 'green'
            ]
        ];

        return view('ektrakulikuler', compact('ekskul'));
    }


    public function detail($id)
    {
        $data = [
            1 => [
                'nama' => 'Futsal',
                'kategori' => 'Olahraga',
                'pembina' => 'Pak A',
                'jadwal' => 'Senin & Kamis, 15.00',
                'tempat' => 'Lapangan Sekolah',
                'deskripsi' =>
                    'Kegiatan ekstrakurikuler futsal bertujuan untuk mengembangkan bakat, minat dan kedisiplinan siswa dalam bidang olahraga futsal. Selain itu, kegiatan juga dapat meningkatkan kerja sama tim dan sportivitas.'
            ],

            2 => [
                'nama' => 'Seni',
                'kategori' => 'Seni & Budaya',
                'pembina' => 'Bu B',
                'jadwal' => 'Selasa, 15.00',
                'tempat' => 'Ruang Seni',
                'deskripsi' =>
                    'Kegiatan seni membantu siswa mengembangkan kreativitas, bakat dan kemampuan dalam bidang seni dan budaya.'
            ],

            3 => [
                'nama' => 'Coding',
                'kategori' => 'Teknologi',
                'pembina' => 'Pak C',
                'jadwal' => 'Rabu & Jumat, 15.00',
                'tempat' => 'Lab Komputer',
                'deskripsi' =>
                    'Kegiatan coding bertujuan meningkatkan kemampuan siswa dalam pemrograman, teknologi informasi dan pengembangan aplikasi.'
            ],

            4 => [
                'nama' => 'Pencak Silat',
                'kategori' => 'Olahraga',
                'pembina' => 'Pak D',
                'jadwal' => 'Senin & Rabu, 15.00',
                'tempat' => 'Aula Sekolah',
                'deskripsi' =>
                    'Kegiatan pencak silat melatih kedisiplinan, kekuatan, ketangkasan dan sportivitas siswa.'
            ]
        ];

        abort_unless(isset($data[$id]), 404);

        return view('detail-sistemektrakuliuler', [
            'data' => $data[$id],
        ]);
    }


    public function profil()
    {
        return view('profil');
    }


    public function penilaian()
    {
        $nilai = [
            [
                'id' => 1,
                'nama' => 'Futsal',
                'nilai' => 85,
                'grade' => 'A'
            ],
            [
                'id' => 2,
                'nama' => 'Coding',
                'nilai' => 88,
                'grade' => 'A'
            ],
            [
                'id' => 3,
                'nama' => 'Seni',
                'nilai' => 80,
                'grade' => 'B'
            ]
        ];

        return view('penilaian', compact('nilai'));
    }


    public function detailNilai($id)
    {
        $data = [
            'nama' => 'Futsal',
            'nilai' => 85,
            'grade' => 'A',
            'kedisiplinan' => 90,
            'kerja_sama' => 85,
            'keaktifan' => 80,
            'tanggung_jawab' => 90,
            'sikap' => 85
        ];

        return view('detail-nilai', compact('data'));
    }


    public function laporan()
    {
        $siswa = [
            [
                'no' => 1,
                'nama' => 'raka',
                'rata' => 85,
                'grade' => 'A'
            ],
            [
                'no' => 2,
                'nama' => 'Ahmad',
                'rata' => 78,
                'grade' => 'B'
            ],
            [
                'no' => 3,
                'nama' => 'Siti',
                'rata' => 92,
                'grade' => 'A'
            ],
            [
                'no' => 4,
                'nama' => 'Dimas',
                'rata' => 75,
                'grade' => 'B'
            ],
            [
                'no' => 5,
                'nama' => 'Rani',
                'rata' => 88,
                'grade' => 'A'
            ]
        ];

        return view('laporan', compact('siswa'));
    }
}