<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .details {
            margin-bottom: 15px;
        }

        .details th,
        .details td {
            padding: 6px 10px;
        }

        .total {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>INVOICE PEMBAYARAN</h2>
        <p>No: {{ $transaksi->invoice_number }}</p>
    </div>

    <table class="details" width="100%" border="1" cellspacing="0">
        <tr>
            <th>Nama Kontrakan</th>
            <td>{{ $transaksi->sewa->kontrakan->nama }}</td>
        </tr>
        <tr>
            <th>Metode</th>
            <td>{{ ucfirst($transaksi->metode) }}</td>
        </tr>
        <tr>
            <th>Diskon</th>
            <td>Rp {{ number_format($transaksi->diskon) }}</td>
        </tr>
        <tr>
            <th>Denda</th>
            <td>Rp {{ number_format($transaksi->denda) }}</td>
        </tr>
        <tr class="total">
            <th>Total Bayar</th>
            <td>Rp {{ number_format($transaksi->total_bayar) }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{!! statusBadge($transaksi->status) !!}</td>
        </tr>
    </table>

    <p>Tanggal Transaksi: {{ $transaksi->created_at->format('d M Y H:i') }}</p>
    <p>Terima kasih telah menggunakan layanan kami.</p>
</body>

</html>
