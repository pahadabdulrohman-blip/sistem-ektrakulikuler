<?php

namespace Tests\Feature;

use App\Models\Ekstrakurikuler;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FotoKegiatanTest extends TestCase
{
    use DatabaseTransactions;

    private const PNG = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg==';

    private function ekskulBaru(string $nama): Ekstrakurikuler
    {
        return Ekstrakurikuler::create([
            'nama_ekstrakurikuler' => $nama,
            'deskripsi' => 'Uji foto kegiatan.',
            'ikon' => 'T',
            'pembina' => 'Guru Uji',
            'jadwal' => 'Jumat',
            'tempat' => 'Aula',
        ]);
    }

    private function sesiAdmin(): array
    {
        return [
            'login' => true,
            'role' => 'admin',
            'username' => 'admin_uji_foto',
            'name' => 'Admin Uji',
        ];
    }

    private function gambar(string $nama): UploadedFile
    {
        return UploadedFile::fake()->createWithContent(
            $nama,
            base64_decode(self::PNG)
        );
    }

    public function test_admin_bisa_unggah_beberapa_foto(): void
    {
        Storage::fake('public');

        $ekskul = $this->ekskulBaru('Ekskul Uji ' . uniqid());

        $response = $this->withSession($this->sesiAdmin())
            ->post(route('ekstrakurikuler.foto.store', $ekskul->id), [
                'foto' => [$this->gambar('a.png'), $this->gambar('b.png')],
                'keterangan' => 'Latihan rutin',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('status_foto');

        $fotos = $ekskul->fotoKegiatan()->get();
        $this->assertCount(2, $fotos);

        foreach ($fotos as $foto) {
            $this->assertStringStartsWith('foto-kegiatan/' . $ekskul->id . '/', $foto->foto_path);
            Storage::disk('public')->assertExists($foto->foto_path);
            $this->assertSame('Latihan rutin', $foto->keterangan);
        }
    }

    public function test_file_bukan_gambar_ditolak(): void
    {
        Storage::fake('public');

        $ekskul = $this->ekskulBaru('Ekskul Tolak ' . uniqid());

        $response = $this->withSession($this->sesiAdmin())
            ->post(route('ekstrakurikuler.foto.store', $ekskul->id), [
                'foto' => [UploadedFile::fake()->create('dokumen.pdf', 10, 'application/pdf')],
            ]);

        $response->assertSessionHasErrors('foto.0');
        $this->assertCount(0, $ekskul->fotoKegiatan()->get());
    }

    public function test_admin_bisa_hapus_foto_beserta_filenya(): void
    {
        Storage::fake('public');

        $ekskul = $this->ekskulBaru('Ekskul Hapus ' . uniqid());

        $this->withSession($this->sesiAdmin())
            ->post(route('ekstrakurikuler.foto.store', $ekskul->id), [
                'foto' => [$this->gambar('a.png')],
            ]);

        $foto = $ekskul->fotoKegiatan()->firstOrFail();
        $path = $foto->foto_path;

        $response = $this->withSession($this->sesiAdmin())
            ->delete(route('ekstrakurikuler.foto.hapus', [$ekskul->id, $foto->id]));

        $response->assertRedirect();
        $response->assertSessionHas('status_foto');

        Storage::disk('public')->assertMissing($path);
        $this->assertDatabaseMissing('ekstrakurikuler_fotos', ['id' => $foto->id]);
    }

    public function test_foto_tidak_bisa_dihapus_lewat_ekskul_lain(): void
    {
        Storage::fake('public');

        $ekskul = $this->ekskulBaru('Ekskul A ' . uniqid());
        $lain = $this->ekskulBaru('Ekskul B ' . uniqid());

        $this->withSession($this->sesiAdmin())
            ->post(route('ekstrakurikuler.foto.store', $ekskul->id), [
                'foto' => [$this->gambar('a.png')],
            ]);

        $foto = $ekskul->fotoKegiatan()->firstOrFail();

        $response = $this->withSession($this->sesiAdmin())
            ->delete(route('ekstrakurikuler.foto.hapus', [$lain->id, $foto->id]));

        $response->assertRedirect();
        $response->assertSessionHas('error');

        $this->assertDatabaseHas('ekstrakurikuler_fotos', ['id' => $foto->id]);
        Storage::disk('public')->assertExists($foto->foto_path);
    }

    public function test_siswa_tidak_boleh_unggah_foto(): void
    {
        Storage::fake('public');

        $ekskul = $this->ekskulBaru('Ekskul Siswa ' . uniqid());

        $response = $this->withSession([
            'login' => true,
            'role' => 'siswa',
            'username' => 'siswa_uji_foto',
        ])->post(route('ekstrakurikuler.foto.store', $ekskul->id), [
            'foto' => [$this->gambar('a.png')],
        ]);

        $response->assertRedirect(route('login'));

        $this->assertCount(0, $ekskul->fotoKegiatan()->get());
    }

    public function test_galeri_tampil_di_detail_siswa(): void
    {
        Storage::fake('public');

        $ekskul = $this->ekskulBaru('Ekskul Detail ' . uniqid());

        $this->withSession($this->sesiAdmin())
            ->post(route('ekstrakurikuler.foto.store', $ekskul->id), [
                'foto' => [$this->gambar('a.png')],
                'keterangan' => 'Dokumentasi uji',
            ]);

        // Buat siswa diterima agar lolos middleware role.
        $siswa = \App\Models\User::create([
            'name' => 'Siswa Uji Foto',
            'username' => 'siswa_uji_foto',
            'email' => 'siswa_uji_foto@example.test',
            'password' => bcrypt('rahasia123'),
            'role' => 'siswa',
            'status_pendaftaran' => 'diterima',
        ]);

        $response = $this->withSession([
            'login' => true,
            'role' => 'siswa',
            'username' => $siswa->username,
        ])->get(route('ekstrakurikuler.detail', $ekskul->id));

        $response->assertOk();
        $response->assertSee('Foto Kegiatan');
        $response->assertSee('Dokumentasi uji');
        $response->assertSee($ekskul->nama_ekstrakurikuler);
    }

    public function test_halaman_admin_dan_guru_menampilkan_galeri(): void
    {
        Storage::fake('public');

        $ekskul = $this->ekskulBaru('Ekskul Kelola ' . uniqid());

        $this->withSession($this->sesiAdmin())
            ->post(route('ekstrakurikuler.foto.store', $ekskul->id), [
                'foto' => [$this->gambar('a.png')],
            ]);

        // Halaman detail & edit admin.
        $this->withSession($this->sesiAdmin())
            ->get(route('admin.ekstrakurikuler.show', $ekskul->id))
            ->assertOk()
            ->assertSee('Foto Kegiatan')
            ->assertSee('Unggah Foto');

        $this->withSession($this->sesiAdmin())
            ->get(route('admin.ekstrakurikuler.edit', $ekskul->id))
            ->assertOk()
            ->assertSee('Unggah Foto');

        // Halaman edit guru memakai view form yang sama.
        $this->withSession([
            'login' => true,
            'role' => 'guru',
            'username' => 'guru_uji_foto',
        ])->get(route('guru.ekstrakurikuler.edit', $ekskul->id))
            ->assertOk()
            ->assertSee('Foto Kegiatan')
            ->assertSee('Unggah Foto');
    }
}
