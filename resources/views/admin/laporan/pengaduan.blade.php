<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Pengaduan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        h4 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        thead {
            background-color: #f2f2f2;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px 8px;
            vertical-align: top;
        }

        th {
            font-weight: bold;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }
    </style>
</head>

<body>
    <h4>Laporan Pengaduan</h4>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama User</th>
                <th>Pesan</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Ditangani Oleh</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengaduans as $i => $p)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $p->user->name }}</td>
                    <td>{{ $p->pesan }}</td>
                    <td class="text-center">{!! statusBadgePdf($p->status) !!}</td>
                    <td>{{ $p->created_at->format('d-m-Y') }}</td>
                    <td>{{ $p->status_diubah_oleh->name ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
