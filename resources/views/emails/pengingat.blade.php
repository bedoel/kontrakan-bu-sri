<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Pengingat Sewa Kontrakan</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f7f7f7; padding: 20px;">

    <table width="100%" cellpadding="0" cellspacing="0"
        style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px;">
        <tr>
            <td>
                <h2 style="color: #2c3e50; margin-bottom: 10px;">📅 Pengingat Sewa Kontrakan</h2>

                <p>Halo <strong>{{ $sewa->user->name }}</strong>,</p>

                <p>
                    Kami ingin mengingatkan bahwa masa sewa kontrakan Anda untuk:
                </p>

                <blockquote
                    style="background-color: #f1f1f1; padding: 12px 18px; border-left: 4px solid #3490dc; margin: 20px 0;">
                    🏠 <strong>{{ $sewa->kontrakan->nama }}</strong>
                </blockquote>

                <p>
                    akan <strong>berakhir pada</strong>:
                </p>

                <blockquote
                    style="background-color: #f1f1f1; padding: 12px 18px; border-left: 4px solid #3490dc; margin: 20px 0;">
                    📆 <strong>{{ \Carbon\Carbon::parse($sewa->tanggal_akhir)->translatedFormat('d F Y') }}</strong>
                </blockquote>

                <p>
                    Silakan melakukan perpanjangan sebelum masa sewa berakhir atau hubungi admin jika memerlukan
                    bantuan.
                </p>

                <p style="text-align: center; margin: 30px 0;">
                    <a href="{{ route('user.sewa.index') }}" target="_blank"
                        style="background-color: #38c172; color: white; text-decoration: none; padding: 12px 24px; border-radius: 6px; display: inline-block;">
                        🔄 Perpanjang Sewa
                    </a>
                </p>

                <hr style="margin: 30px 0; border: none; border-top: 1px solid #eee;">

                <p style="font-size: 14px; color: #555;">
                    Jika Anda sudah memperpanjang sewa, abaikan email ini.<br>
                    Terima kasih atas kepercayaan Anda.
                </p>

                <p>
                    Salam hangat,<br>
                    <strong>{{ config('app.name') }}</strong>
                </p>
            </td>
        </tr>
    </table>

</body>

</html>
