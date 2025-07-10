<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Status Permintaan Pindah Kontrakan</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f6f8fa;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .email-container {
            max-width: 640px;
            margin: 30px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 32px;
        }

        h2 {
            color: #0066cc;
            margin-top: 0;
        }

        .status {
            padding: 10px 15px;
            border-radius: 4px;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 20px;
        }

        .status.disetujui {
            background-color: #e6f4ea;
            color: #1e7e34;
        }

        .status.ditolak {
            background-color: #fdecea;
            color: #cc1f1a;
        }

        ul {
            padding-left: 20px;
        }

        .footer {
            margin-top: 30px;
            font-size: 13px;
            color: #888;
            border-top: 1px solid #eee;
            padding-top: 15px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <h2>Halo, {{ $permintaan->user->name }}</h2>

        <p>Status permintaan pindah kontrakan Anda telah diperbarui menjadi:</p>

        <div class="status {{ $permintaan->status }}">
            {{ strtoupper($permintaan->status) }}
        </div>

        <h4>Detail Permintaan:</h4>
        <ul>
            <li><strong>Kontrakan Lama:</strong> {{ $permintaan->kontrakanLama->nama }}</li>
            <li><strong>Kontrakan Baru:</strong> {{ $permintaan->kontrakanBaru->nama }}</li>
            <li><strong>Alasan:</strong> {{ $permintaan->alasan }}</li>
            @if ($permintaan->catatan)
                <li><strong>Catatan Admin:</strong> {{ $permintaan->catatan }}</li>
            @endif
            <li><strong>Dikirim Pada:</strong> {{ $permintaan->created_at->translatedFormat('d F Y, H:i') }}</li>
        </ul>

        <p>Silakan cek dashboard Anda untuk informasi lebih lanjut.</p>

        <div class="footer">
            &copy; {{ date('Y') }} Sistem Kontrakan Bu Sri. Semua Hak Dilindungi.
        </div>
    </div>
</body>

</html>
