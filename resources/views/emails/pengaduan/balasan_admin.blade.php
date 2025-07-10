@php
    use Illuminate\Support\Carbon;
@endphp

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Balasan Pengaduan</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6;">
    <h2>Halo {{ $user->name }},</h2>

    <p>Admin telah membalas pengaduan Anda yang dikirim pada
        <strong>{{ $balasan->pengaduan->created_at->translatedFormat('d M Y') }}</strong>.</p>

    <hr>
    <p><strong>Isi Balasan:</strong></p>
    <blockquote style="border-left: 4px solid #ccc; padding-left: 10px; color: #333;">
        {{ $balasan->pesan }}
    </blockquote>
    <hr>

    <p>Anda bisa melihat balasan lengkap dan membalas kembali melalui tombol berikut:</p>
    <p>
        <a href="{{ route('user.pengaduan.show', $balasan->pengaduan) }}"
            style="background-color: #0066cc; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
            Lihat Pengaduan
        </a>
    </p>

    <p>Terima kasih telah menggunakan layanan kontrakan Bu Sri.</p>
</body>

</html>
