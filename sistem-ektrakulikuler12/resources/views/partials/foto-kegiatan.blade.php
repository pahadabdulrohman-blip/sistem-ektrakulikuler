@php
    /*
     | Galeri foto kegiatan ekstrakurikuler.
     |
     | Variabel yang dipakai:
     | - $ekskul      : model / array ekstrakurikuler (butuh id)
     | - $fotos       : koleksi App\Models\EkstrakurikulerFoto
     | - $bisaKelola  : true untuk admin & guru (tampil tombol unggah/hapus)
     */

    $bisaKelola = $bisaKelola ?? false;
    $fotos = $fotos ?? collect();

    $ekskulId = is_array($ekskul)
        ? ($ekskul['id'] ?? null)
        : ($ekskul->id ?? null);

    // Kumpulkan pesan error khusus unggahan foto (foto, foto.*).
    $galatFoto = [];

    foreach ($errors->getBag('default')->messages() as $field => $pesan) {
        if (str_starts_with($field, 'foto')) {
            $galatFoto = array_merge($galatFoto, $pesan);
        }
    }
@endphp

@once
    <link rel="stylesheet" href="{{ asset('css/foto-kegiatan.css') }}">
@endonce

<section class="fk-section" aria-label="Foto kegiatan ekstrakurikuler">

    <div class="fk-head">
        <h3>
            <i class="fa-solid fa-images"></i>
            Foto Kegiatan
        </h3>

        <span class="fk-hitung">{{ $fotos->count() }} foto</span>
    </div>

    <p class="fk-hint">
        @if($bisaKelola)
            Unggah dokumentasi kegiatan ekstrakurikuler. Bisa beberapa foto sekaligus
            (maksimal 10 foto, masing-masing maksimal 10 MB, format JPG/PNG/WEBP).
        @else
            Dokumentasi kegiatan ekstrakurikuler.
        @endif
    </p>

    @if(session('status_foto'))
        <div class="fk-pesan sukses">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('status_foto') }}
        </div>
    @endif

    @if(!empty($galatFoto))
        <div class="fk-pesan gagal">
            <strong>
                <i class="fa-solid fa-circle-exclamation"></i>
                Foto gagal diunggah:
            </strong>
            <ul>
                @foreach($galatFoto as $pesan)
                    <li>{{ $pesan }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($fotos->isEmpty())
        <div class="fk-kosong">
            <i class="fa-regular fa-image"></i>
            Belum ada foto kegiatan.
            @if($bisaKelola)
                Silakan unggah dokumentasi pertama di bawah.
            @endif
        </div>
    @else
        <div class="fk-galeri">
            @foreach($fotos as $foto)
                <figure class="fk-item">
                    <a href="{{ $foto->url }}" target="_blank" rel="noopener">
                        <img src="{{ $foto->url }}"
                             alt="Foto kegiatan {{ $foto->keterangan ?: 'ekstrakurikuler' }}"
                             loading="lazy">
                    </a>

                    @if($bisaKelola)
                        <form action="{{ route('ekstrakurikuler.foto.hapus', [$ekskulId, $foto->id]) }}"
                              method="POST"
                              onsubmit="return confirm('Hapus foto kegiatan ini?');">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="fk-hapus" title="Hapus foto">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    @endif

                    @if($foto->keterangan)
                        <figcaption class="fk-keterangan">
                            {{ $foto->keterangan }}
                        </figcaption>
                    @endif
                </figure>
            @endforeach
        </div>
    @endif

    @if($bisaKelola && $ekskulId)
        <form class="fk-form"
              action="{{ route('ekstrakurikuler.foto.store', $ekskulId) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <label for="fk-file-{{ $ekskulId }}">
                Pilih foto kegiatan
            </label>

            <input id="fk-file-{{ $ekskulId }}"
                   type="file"
                   name="foto[]"
                   accept="image/jpeg,image/png,image/webp"
                   multiple
                   required>

            <label for="fk-keterangan-{{ $ekskulId }}">
                Keterangan (opsional)
            </label>

            <input id="fk-keterangan-{{ $ekskulId }}"
                   type="text"
                   name="keterangan"
                   maxlength="150"
                   placeholder="Contoh: Latihan rutin Jumat sore">

            <div class="fk-aksi">
                <button type="submit">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    Unggah Foto
                </button>

                <span class="fk-catatan">
                    Maks. 10 foto &middot; 10 MB per foto
                </span>
            </div>
        </form>
    @endif

</section>
