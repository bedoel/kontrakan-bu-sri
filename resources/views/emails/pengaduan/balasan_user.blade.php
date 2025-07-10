@php
    use Illuminate\Support\Carbon;
@endphp

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Balasan dari User</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6;">
    <h2>Halo Admin,</h2>

    <p>User <strong>{{ $balasan->user->name }}</strong> telah membalas pengaduan pada tanggal
        <strong>{{ $balasan->created_at->translatedFormat('d M Y H:i') }}</strong>.
    </p>

    <hr>
    <p><strong>Isi Balasan:</strong></p>
    <blockquote style="border-left: 4px solid #ccc; padding-left: 10px; color: #333;">
        {{ $balasan->pesan }}
    </blockquote>
    <hr>

    <p>Silakan klik tombol berikut untuk melihat detail pengaduan dan memberikan tanggapan:</p>

    <p>
        <a href="{{ route('admin.pengaduan.show', $balasan->pengaduan) }}"
            style="background-color: #0066cc; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
            Lihat Pengaduan
        </a>
    </p>

    <p>Terima kasih.</p>
</body>

</html>
