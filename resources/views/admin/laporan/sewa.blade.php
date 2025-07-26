<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Data Sewa</title>
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
            text-align: left;
        }

        th {
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>

<body>
    <h4>Laporan Data Sewa</h4>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Penyewa</th>
                <th>Kontrakan</th>
                <th>Mulai</th>
                <th>Akhir</th>
                <th>Status</th>
                <th>Diskon</th>
                <th>Admin</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->kontrakan->nama }}</td>
                    <td>{{ $item->tanggal_mulai->format('d-m-Y') }}</td>
                    <td>{{ $item->tanggal_akhir->format('d-m-Y') }}</td>
                    <td style="text-align: center;">
                        {!! statusBadgePdf($item->status) !!}
                    </td>
                    <td>Rp {{ number_format($item->diskon, 0, ',', '.') }}</td>
                    <td>{{ $item->admin->name ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
