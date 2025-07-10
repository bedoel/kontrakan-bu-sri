<h4>Laporan Transaksi</h4>
<table width="100%" border="1" cellspacing="0" cellpadding="5">
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
        @foreach ($transaksis as $i => $t)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $t->invoice_number }}</td>
                <td>{{ $t->sewa->user->name }}</td>
                <td>{{ $t->sewa->kontrakan->nama }}</td>
                <td>Rp {{ number_format($t->total_bayar) }}</td>
                <td>{{ ucfirst($t->metode) }}</td>
                <td>{!! statusBadge($t->status) !!}</td>
            </tr>
        @endforeach
    </tbody>
</table>
