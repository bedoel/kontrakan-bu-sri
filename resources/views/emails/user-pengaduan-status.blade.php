<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Status Pengaduan Diperbarui</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f9f9f9;
            color: #333;
            padding: 20px;
        }

        .container {
            background-color: white;
            padding: 24px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .btn {
            background-color: #0066cc;
            color: white;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 6px;
            display: inline-block;
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Halo {{ $pengaduan->user->name }},</h2>
        <p>Status pengaduan Anda telah diperbarui menjadi:</p>

        <h3 style="color:#0066cc; text-transform: capitalize;">{{ $pengaduan->status }}</h3>

        <p><strong>Isi pengaduan:</strong></p>
        <blockquote>{{ $pengaduan->pesan }}</blockquote>

        @if ($pengaduan->catatan)
            <p><strong>Catatan dari Admin:</strong></p>
            <blockquote>{{ $pengaduan->catatan }}</blockquote>
        @endif

        <a class="btn" href="{{ route('user.pengaduan.show', $pengaduan->id) }}">
            Lihat Pengaduan
        </a>

        <p style="margin-top: 30px;">Terima kasih telah menggunakan layanan kami.</p>
        <p>Salam hangat, <br><strong>Tim Kontrakan Bu Sri</strong></p>
    </div>
</body>

</html>
