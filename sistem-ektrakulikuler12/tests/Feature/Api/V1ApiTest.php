<?php

namespace Tests\Feature\Api;

use App\Models\AbsensiSiswa;
use App\Models\Ekstrakurikuler;
use App\Models\Penilaian;
use App\Models\PendaftaranEkstrakurikuler;
use App\Models\ProfilePhoto;
use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class V1ApiTest extends TestCase
{
    private array $pengguna = [];
    private ?Ekstrakurikuler $ekskul = null;

    protected function setUp(): void
    {
        parent::setUp();

        RateLimiter::clear('login-ip:127.0.0.1');

        $suffix = substr(md5(uniqid('', true)), 0, 8);

        $this->pengguna['admin'] = User::create([
            'name' => 'Admin API '.$suffix,
            'username' => 'apiadmin'.$suffix,
            'email' => 'apiadmin'.$suffix.'@gmail.com',
            'password' => 'rahasia123',
            'role' => 'admin',
            'status_pendaftaran' => 'diterima',
        ]);

        $this->pengguna['guru'] = User::create([
            'name' => 'Guru API '.$suffix,
            'username' => 'apiguru'.$suffix,
            'email' => 'apiguru'.$suffix.'@gmail.com',
            'password' => 'rahasia123',
            'role' => 'guru',
            'status_pendaftaran' => 'diterima',
        ]);

        $this->pengguna['siswa'] = User::create([
            'name' => 'Siswa API '.$suffix,
            'username' => 'apisiswa'.$suffix,
            'email' => 'apisiswa'.$suffix.'@gmail.com',
            'password' => 'rahasia123',
            'role' => 'siswa',
            'kelas' => 'X',
            'tahun_masuk' => User::tahunMasukDariKelas('X'),
            'status_pendaftaran' => 'diterima',
        ]);

        $this->ekskul = Ekstrakurikuler::create([
            'nama_ekstrakurikuler' => 'Ekskul API '.$suffix,
            'deskripsi' => 'Ekskul untuk pengujian API.',
            'pembina' => '-',
            'jadwal' => '-',
            'ikon' => 'E',
            'tempat' => 'Aula',
        ]);
    }

    protected function tearDown(): void
    {
        foreach ($this->pengguna as $user) {
            PendaftaranEkstrakurikuler::where('username', $user->username)->delete();
            ProfilePhoto::where('username', $user->username)->delete();
            Penilaian::where('username', $user->username)->delete();
            Penilaian::where('dicatat_oleh', $user->username)->delete();
            AbsensiSiswa::where('username', $user->username)->delete();
            AbsensiSiswa::where('dicatat_oleh', $user->username)->delete();
            $user->delete();
        }

        $this->ekskul?->fotoKegiatan()->delete();
        $this->ekskul?->delete();

        parent::tearDown();
    }

    private function token(string $role): string
    {
        $respons = $this->postJson('/api/v1/login', [
            'username' => $this->pengguna[$role]->username,
            'password' => 'rahasia123',
        ]);

        $respons->assertOk();

        return $respons->json('data.token');
    }

    private function header(string $role): array
    {
        return ['Authorization' => 'Bearer '.$this->token($role)];
    }

    public function test_login_me_dan_token_tidak_valid(): void
    {
        $respons = $this->postJson('/api/v1/login', [
            'username' => $this->pengguna['admin']->username,
            'password' => 'rahasia123',
        ]);

        $respons->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.user.role', 'admin')
            ->assertJsonStructure(['data' => ['token', 'token_type', 'user']]);

        $token = $respons->json('data.token');
        $this->assertNotEmpty($token);

        $this->withHeaders(['Authorization' => 'Bearer '.$token])
            ->getJson('/api/v1/me')
            ->assertOk()
            ->assertJsonPath('data.username', $this->pengguna['admin']->username);

        $this->flushHeaders();
        $this->getJson('/api/v1/me')->assertStatus(401);
        $this->withHeaders(['Authorization' => 'Bearer token-salah'])
            ->getJson('/api/v1/me')->assertStatus(401);

        $this->postJson('/api/v1/login', [
            'username' => $this->pengguna['admin']->username,
            'password' => 'salah',
        ])->assertStatus(401)->assertJsonPath('success', false);
    }

    public function test_logout_mencabut_token(): void
    {
        $header = $this->header('guru');

        $this->withHeaders($header)->postJson('/api/v1/logout')->assertOk();
        $this->withHeaders($header)->getJson('/api/v1/me')->assertStatus(401);
    }

    public function test_pembatasan_role(): void
    {
        $this->withHeaders($this->header('admin'))
            ->getJson('/api/v1/admin/data-guru')->assertOk();

        $this->withHeaders($this->header('guru'))
            ->getJson('/api/v1/admin/data-guru')->assertStatus(403);

        $this->withHeaders($this->header('siswa'))
            ->postJson('/api/v1/ekstrakurikuler', [
                'nama_ekstrakurikuler' => 'Tidak boleh',
                'deskripsi' => 'Tidak boleh',
            ])->assertStatus(403);

        $this->withHeaders($this->header('siswa'))
            ->postJson('/api/v1/jadwal', [])->assertStatus(403);
    }

    public function test_ekstrakurikuler_dan_validasi(): void
    {
        $header = $this->header('admin');

        $this->withHeaders($header)->getJson('/api/v1/ekstrakurikuler')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonStructure(['data' => ['ekstrakurikuler']]);

        $this->withHeaders($header)->getJson('/api/v1/ekstrakurikuler/'.$this->ekskul->id)
            ->assertOk()
            ->assertJsonPath('data.id', $this->ekskul->id);

        $respons = $this->withHeaders($header)->postJson('/api/v1/ekstrakurikuler', [
            'nama_ekstrakurikuler' => 'API Baru '.uniqid(),
            'deskripsi' => 'Deskripsi uji.',
        ]);

        $respons->assertStatus(201)->assertJsonPath('message', 'Ekstrakurikuler berhasil ditambahkan.');
        $idBaru = $respons->json('data.id');

        $this->withHeaders($header)->putJson('/api/v1/ekstrakurikuler/'.$idBaru, [
            'nama_ekstrakurikuler' => 'API Ubah '.uniqid(),
            'deskripsi' => 'Deskripsi ubah.',
        ])->assertOk()->assertJsonPath('message', 'Ekstrakurikuler berhasil diperbarui.');

        $this->withHeaders($header)->postJson('/api/v1/ekstrakurikuler', [])
            ->assertStatus(422)
            ->assertJsonPath('success', false)
            ->assertJsonStructure(['errors']);

        $this->withHeaders($header)->deleteJson('/api/v1/ekstrakurikuler/'.$idBaru)->assertOk();
    }

    public function test_siswa_pilih_dan_batalkan_ekskul(): void
    {
        $header = $this->header('siswa');

        $this->withHeaders($header)->postJson('/api/v1/pilihan-ekstrakurikuler', [
            'pilihan' => [$this->ekskul->id],
        ])->assertOk()->assertJsonPath('message', 'Pilihan ekstrakurikuler berhasil disimpan.');

        $this->withHeaders($header)->getJson('/api/v1/pilihan-ekstrakurikuler')
            ->assertOk()->assertJsonCount(1, 'data.pilihan');

        $this->withHeaders($header)->postJson('/api/v1/pilihan-ekstrakurikuler', ['pilihan' => []])
            ->assertStatus(422);

        $this->withHeaders($header)->deleteJson('/api/v1/pilihan-ekstrakurikuler')
            ->assertOk()->assertJsonPath('message', 'Pilihan ekstrakurikuler berhasil dihapus.');

        $this->withHeaders($header)->getJson('/api/v1/pilihan-ekstrakurikuler')
            ->assertOk()->assertJsonCount(0, 'data.pilihan');
    }

    public function test_guru_jadwal_absensi_dan_penilaian(): void
    {
        $headerGuru = $this->header('guru');
        $nama = 'Kegiatan API '.uniqid();
        $tanggal = now()->addDay()->toDateString();

        $jadwal = $this->withHeaders($headerGuru)->postJson('/api/v1/jadwal', [
            'nama_kegiatan' => $nama,
            'jenis' => 'gabungan',
            'tanggal' => $tanggal,
            'jam_mulai' => '10:00',
            'jam_selesai' => '11:30',
            'lokasi' => 'Aula',
        ]);
        $jadwal->assertStatus(201);
        $jadwalId = $jadwal->json('data.id');

        $this->withHeaders($headerGuru)->getJson('/api/v1/jadwal')->assertOk();

        $absensi = $this->withHeaders($headerGuru)->postJson('/api/v1/absensi', [
            'username' => $this->pengguna['siswa']->username,
            'nama_kegiatan' => $nama,
            'tanggal' => $tanggal,
            'status' => 'hadir',
        ]);
        $absensi->assertOk()->assertJsonPath('data.status', 'hadir');

        $penilaian = $this->withHeaders($headerGuru)->postJson('/api/v1/penilaian', [
            'username' => $this->pengguna['siswa']->username,
            'nama_kegiatan' => $nama,
            'nilai' => 85,
            'keterangan' => 'Uji API',
        ]);
        $penilaian->assertStatus(201)->assertJsonPath('data.predikat', 'Baik');
        $penilaianId = $penilaian->json('data.id');

        $this->withHeaders($this->header('siswa'))->getJson('/api/v1/penilaian')
            ->assertOk()->assertJsonPath('success', true);

        $this->withHeaders($headerGuru)->putJson('/api/v1/penilaian/'.$penilaianId, [
            'nilai' => 92,
        ])->assertOk()->assertJsonPath('data.predikat', 'Sangat Baik');

        $this->withHeaders($headerGuru)->deleteJson('/api/v1/penilaian/'.$penilaianId)->assertOk();
        $this->withHeaders($headerGuru)->deleteJson('/api/v1/jadwal/'.$jadwalId)->assertOk();
    }

    public function test_admin_penerimaan_laporan_dan_profil(): void
    {
        $header = $this->header('admin');

        $this->withHeaders($header)->getJson('/api/v1/admin/penerimaan-siswa?status=menunggu')
            ->assertOk()->assertJsonPath('success', true);

        $this->withHeaders($header)->putJson(
            '/api/v1/admin/penerimaan-siswa/'.$this->pengguna['siswa']->id.'/terima'
        )->assertOk();

        $this->withHeaders($header)->getJson('/api/v1/laporan')
            ->assertOk()->assertJsonPath('success', true);

        $this->withHeaders($header)->getJson('/api/v1/profil')
            ->assertOk()->assertJsonPath('data.username', $this->pengguna['admin']->username);

        $this->withHeaders($header)->postJson('/api/v1/profil/foto', [])
            ->assertStatus(422)->assertJsonPath('success', false);
    }
}
