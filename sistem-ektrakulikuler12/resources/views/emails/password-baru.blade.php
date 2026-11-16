<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Baru Akun AKTIVIA</title>
</head>
<body style="margin:0;padding:0;background:#f3f6fa;font-family:Arial,sans-serif;color:#1f2937;">

    <div style="max-width:560px;margin:0 auto;padding:30px 16px;">

        <div style="background:#116b43;color:#ffffff;padding:24px;border-radius:14px 14px 0 0;">
            <h1 style="margin:0;font-size:22px;">AKTIVIA</h1>
            <p style="margin:6px 0 0;font-size:13px;opacity:.9;">
                Sistem Ekstrakurikuler Sekolah
            </p>
        </div>

        <div style="background:#ffffff;padding:26px;border-radius:0 0 14px 14px;">

            <p style="margin:0 0 14px;font-size:15px;">
                Halo <strong>{{ $user->name }}</strong>,
            </p>

            <p style="margin:0 0 14px;font-size:14px;line-height:1.7;">
                Permintaan ubah password akun kamu sudah diproses oleh admin.
                Berikut password baru untuk akun AKTIVIA kamu:
            </p>

            <div style="background:#f0fdf4;border:1px dashed #116b43;border-radius:10px;padding:16px;text-align:center;margin:0 0 16px;">
                <div style="font-size:12px;color:#4b5563;margin-bottom:6px;">
                    Password Baru
                </div>
                <div style="font-size:20px;font-weight:bold;letter-spacing:2px;color:#116b43;">
                    {{ $password }}
                </div>
            </div>

            <table style="width:100%;border-collapse:collapse;font-size:14px;margin-bottom:16px;">
                <tr>
                    <td style="padding:8px 0;color:#6b7280;width:120px;">Username</td>
                    <td style="padding:8px 0;font-weight:bold;">{{ $user->username }}</td>
                </tr>
                @if ($user->role === 'siswa' && $user->kelas_saat_ini)
                    <tr>
                        <td style="padding:8px 0;color:#6b7280;">Kelas</td>
                        <td style="padding:8px 0;font-weight:bold;">{{ $user->kelas_saat_ini }}</td>
                    </tr>
                @endif
                <tr>
                    <td style="padding:8px 0;color:#6b7280;">Peran</td>
                    <td style="padding:8px 0;font-weight:bold;">{{ ucfirst($user->role) }}</td>
                </tr>
            </table>

            <p style="margin:0 0 14px;font-size:14px;line-height:1.7;">
                Silakan login memakai password baru tersebut, lalu segera ubah
                password dari halaman profil agar akun tetap aman.
            </p>

            <p style="margin:0;font-size:12px;color:#6b7280;line-height:1.7;">
                Jika kamu tidak merasa meminta perubahan password, segera
                hubungi admin sekolah.
            </p>

        </div>

        <p style="text-align:center;font-size:11px;color:#9ca3af;margin:16px 0 0;">
            Email ini dikirim otomatis oleh sistem AKTIVIA.
        </p>

    </div>

</body>
</html>
