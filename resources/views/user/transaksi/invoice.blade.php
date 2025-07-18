<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Invoice Pembayaran</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 14px;
            margin: 40px;
            color: #333;
        }

        .invoice-box {
            max-width: 700px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h2 {
            margin-bottom: 5px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .info-table th,
        .info-table td {
            text-align: left;
            padding: 10px;
            vertical-align: top;
            border: 1px solid #ddd;
        }

        .info-table th {
            background-color: #f5f5f5;
            width: 30%;
        }

        .total-row {
            background-color: #fafafa;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 13px;
            color: #666;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 5px;
            font-weight: bold;
            color: white;
        }

        /* Contoh style status jika tidak pakai helper */
        .status-menunggu {
            background-color: #f0ad4e;
        }

        .status-disetujui {
            background-color: #5cb85c;
        }

        .status-ditolak {
            background-color: #d9534f;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <div class="header">
            <h2>INVOICE PEMBAYARAN</h2>
            <p>No. Invoice: <strong>{{ $transaksi->invoice_number }}</strong></p>
        </div>

        <table class="info-table">
            <tr>
                <th>Nama Kontrakan</th>
                <td>{{ $transaksi->sewa->kontrakan->nama }}</td>
            </tr>
            <tr>
                <th>Nama Penyewa</th>
                <td>{{ $transaksi->sewa->user->name }}</td>
            </tr>
            <tr>
                <th>Metode Pembayaran</th>
                <td>{{ ucfirst($transaksi->metode) }}</td>
            </tr>
            <tr>
                <th>Diskon</th>
                <td>Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Denda</th>
                <td>Rp {{ number_format($transaksi->denda, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <th>Total Bayar</th>
                <td>Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{!! statusBadge($transaksi->status) !!}</td>
            </tr>
        </table>

        <div class="footer">
            <p>Tanggal Transaksi: {{ $transaksi->created_at->format('d M Y H:i') }}</p>
            <p>Terima kasih telah menggunakan layanan kami.</p>
        </div>
    </div>
</body>

</html>
