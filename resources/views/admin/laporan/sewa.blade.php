<h4>Laporan Data Sewa</h4>
<table border="1" cellspacing="0" cellpadding="4" width="100%">
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
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->kontrakan->nama }}</td>
                <td>{{ $item->tanggal_mulai->format('d-m-Y') }}</td>
                <td>{{ $item->tanggal_akhir->format('d-m-Y') }}</td>
                <td>{!! statusBadge($item->status) !!}</td>
                <td>Rp {{ number_format($item->diskon) }}</td>
                <td>{{ $item->admin->name ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
