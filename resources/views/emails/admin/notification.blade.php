<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Notifikasi Admin</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;">
    <table width="100%" cellpadding="0" cellspacing="0"
        style="background-color: #ffffff; max-width: 600px; margin: 0 auto; padding: 20px; border-radius: 8px;">
        <tr>
            <td>
                <h2 style="color: #2c3e50;">🔔 {{ $subjectText }}</h2>
                <p>Halo Admin,</p>
                <p>Ada aktivitas baru yang memerlukan perhatian Anda:</p>

                <blockquote style="background-color: #f1f1f1; padding: 10px 15px; border-left: 4px solid #3490dc;">
                    <strong>{{ $messageText }}</strong>
                </blockquote>

                @if ($url)
                    <p style="text-align: center; margin: 30px 0;">
                        <a href="{{ $url }}" target="_blank"
                            style="background-color: #3490dc; color: #fff; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block;">
                            🔍 Lihat Detail
                        </a>
                    </p>
                @endif

                <hr>

                <p style="font-size: 14px; color: #7f8c8d;">
                    Jika notifikasi ini tidak sesuai, Anda dapat mengabaikannya.<br>
                    Tetap semangat dan terima kasih atas kontribusi Anda.
                </p>

                <p><strong>Hormat kami,</strong><br>{{ config('app.name') }}</p>
            </td>
        </tr>
    </table>
</body>

</html>
