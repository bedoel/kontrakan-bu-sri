<h4>Laporan Pengaduan</h4>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama User</th>
            <th>Pesan</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pengaduans as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $p->user->name }}</td>
                <td>{{ $p->pesan }}</td>
                <td>{!! statusBadge($p->status) !!}</td>
            </tr>
        @endforeach
    </tbody>
</table>
