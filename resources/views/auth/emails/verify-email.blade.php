<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Verifikasi Email</title>
</head>

<body style="margin:0;padding:0;background-color:#f4f6f8;font-family:Arial,Helvetica,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f8;padding:30px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff;border-radius:8px;
                          overflow:hidden;box-shadow:0 4px 12px rgba(0,0,0,0.08);">

                    <!-- HEADER -->
                    <tr>
                        <td style="background-color:#2563eb;padding:24px;text-align:center;color:#ffffff;">
                            <h1 style="margin:0;font-size:22px;">Verifikasi Email</h1>
                            <p style="margin:8px 0 0;font-size:14px;opacity:0.9;">
                                Keamanan Akun Ecovera
                            </p>
                        </td>
                    </tr>

                    <!-- BODY -->
                    <tr>
                        <td style="padding:32px;color:#333333;">
                            <p style="margin:0 0 16px;font-size:15px;">
                                Halo {{ $name ?? 'Pengguna' }},
                            </p>

                            <p style="margin:0 0 16px;font-size:15px;line-height:1.6;">
                                Terima kasih telah mendaftar di Ecovera. Silakan klik tombol di bawah ini untuk
                                memverifikasi alamat email Anda.
                            </p>

                            <div style="text-align:center;margin:32px 0;">
                                <a href="{{ $verificationLink }}" style="background-color:#2563eb;color:#ffffff;text-decoration:none;
                                      padding:14px 28px;border-radius:6px;font-size:15px;
                                      display:inline-block;">
                                    Verifikasi Email
                                </a>
                            </div>

                            <p style="margin:0 0 16px;font-size:14px;line-height:1.6;color:#555555;">
                                Jika Anda tidak merasa mendaftar di Ecovera, silakan abaikan email ini.
                            </p>

                            <p style="margin:24px 0 0;font-size:14px;color:#555555;">
                                Terima kasih,<br>
                                <strong>Tim Ecovera</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td style="background-color:#f9fafb;padding:20px;text-align:center;
                               font-size:12px;color:#777777;">
                            © {{ date('Y') }} Ecovera. All rights reserved.<br>
                            Email ini dikirim otomatis, mohon tidak membalas.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>