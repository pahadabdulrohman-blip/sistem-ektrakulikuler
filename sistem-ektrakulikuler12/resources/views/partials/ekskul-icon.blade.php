@php
    /*
     | Ikon ekstrakurikuler berbasis elemen Font Awesome.
     | Mendukung data lama berupa huruf/singkatan (F, C, B, PS, ...),
     | teks nama kegiatan, atau langsung class Font Awesome (fa-solid fa-futbol).
     */

    $ikonRaw = trim((string) ($ikon ?? ''));
    $namaLower = strtolower(trim((string) ($nama ?? '')));

    $petaHuruf = [
        'F' => 'fa-futbol',
        'C' => 'fa-code',
        'B' => 'fa-basketball',
        'PS' => 'fa-hand-fist',
        'PR' => 'fa-campground',
        'V' => 'fa-volleyball',
        'M' => 'fa-music',
    ];

    $petaKata = [
        'futsal' => 'fa-futbol',
        'sepak bola' => 'fa-futbol',
        'sepakbola' => 'fa-futbol',
        'soccer' => 'fa-futbol',
        'basket' => 'fa-basketball',
        'voli' => 'fa-volleyball',
        'badminton' => 'fa-feather-pointed',
        'bulu tangkis' => 'fa-feather-pointed',
        'renang' => 'fa-water',
        'coding' => 'fa-code',
        'pemrograman' => 'fa-code',
        'program' => 'fa-code',
        'robot' => 'fa-robot',
        'komputer' => 'fa-computer',
        'multimedia' => 'fa-photo-film',
        'desain' => 'fa-pen-nib',
        'pencak' => 'fa-hand-fist',
        'silat' => 'fa-hand-fist',
        'karate' => 'fa-hand-fist',
        'taekwondo' => 'fa-hand-fist',
        'pramuka' => 'fa-campground',
        'musik' => 'fa-music',
        'band' => 'fa-music',
        'paduan suara' => 'fa-microphone',
        'tari' => 'fa-masks-theater',
        'dance' => 'fa-masks-theater',
        'drama' => 'fa-masks-theater',
        'teater' => 'fa-masks-theater',
        'seni' => 'fa-palette',
        'lukis' => 'fa-palette',
        'fotografi' => 'fa-camera',
        'jurnal' => 'fa-newspaper',
        'bahasa' => 'fa-language',
        'english' => 'fa-language',
        'matematika' => 'fa-calculator',
        'sains' => 'fa-flask',
        'ipa' => 'fa-flask',
        'pmr' => 'fa-kit-medical',
        'kesehatan' => 'fa-kit-medical',
        'rohis' => 'fa-mosque',
        'osis' => 'fa-users',
    ];

    if (str_contains($ikonRaw, 'fa-')) {
        $kelasIkon = $ikonRaw;
    } else {
        $kelasIkon = $petaHuruf[strtoupper($ikonRaw)] ?? null;

        if (! $kelasIkon) {
            foreach ([$ikonRaw, $namaLower] as $sumber) {
                foreach ($petaKata as $kata => $kelas) {
                    if ($sumber !== '' && str_contains(strtolower($sumber), $kata)) {
                        $kelasIkon = $kelas;
                        break 2;
                    }
                }
            }
        }

        $kelasIkon ??= 'fa-shapes';
    }
@endphp

<i class="fa-solid {{ $kelasIkon }}" aria-hidden="true"></i>
