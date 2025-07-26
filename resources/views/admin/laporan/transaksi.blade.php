<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
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
        }

        th {
            font-weight: bold;
            text-align: center;
        }

        td {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <h4>Laporan Transaksi</h4>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Invoice</th>
                <th>Penyewa</th>
                <th>Kontrakan</th>
                <th>Total</th>
                <th>Metode</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach ($transaksis as $i => $t)
                @php $grandTotal += $t->total_bayar; @endphp
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $t->invoice_number }}</td>
                    <td>{{ $t->sewa->user->name }}</td>
                    <td>{{ $t->sewa->kontrakan->nama }}</td>
                    <td class="text-right">Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($t->metode) }}</td>
                    <td class="text-center">{!! statusBadgePdf($t->status) !!}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4" class="text-right"><strong>Total Keseluruhan</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($grandTotal, 0, ',', '.') }}</strong></td>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>
</body>

</html>
