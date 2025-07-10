<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pengajuan Pindah Kontrakan</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            padding: 20px;
        }

        .email-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            max-width: 600px;
            margin: auto;
        }

        h2 {
            color: #0066cc;
            margin-bottom: 20px;
        }

        .label {
            font-weight: bold;
            width: 160px;
            display: inline-block;
        }

        .footer {
            margin-top: 30px;
            font-size: 13px;
            color: #888;
            text-align: center;
        }

        .status {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            background-color: #f0f0f0;
            color: #333;
            font-weight: bold;
            text-transform: capitalize;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <h2>Pengajuan Pindah Kontrakan</h2>

        <p><span class="label">Nama Pengguna:</span> {{ $permintaan->user->name }}</p>
        <p><span class="label">Email:</span> {{ $permintaan->user->email }}</p>
        <p><span class="label">Kontrakan Lama:</span> {{ $permintaan->kontrakanLama->nama }}</p>
        <p><span class="label">Kontrakan Baru:</span> {{ $permintaan->kontrakanBaru->nama }}</p>
        <p><span class="label">Alasan Pindah:</span> {{ $permintaan->alasan }}</p>
        <p><span class="label">Status:</span> <span class="status">{{ $permintaan->status }}</span></p>
        <p><span class="label">Tanggal Pengajuan:</span> {{ $permintaan->created_at->translatedFormat('d M Y H:i') }}
        </p>

        <div class="footer">
            Email ini dikirim secara otomatis oleh sistem kontrakan Bu Sri. Mohon untuk segera menindaklanjuti
            permintaan ini di dashboard admin.
        </div>
    </div>
</body>

</html>
