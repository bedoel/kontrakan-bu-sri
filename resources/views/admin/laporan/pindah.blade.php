<h4>Laporan Permintaan Pindah Kontrakan</h4>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>No</th>
            <th>User</th>
            <th>Dari Kontrakan</th>
            <th>Ke Kontrakan</th>
            <th>Alasan</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pindahs as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $p->user->name }}</td>
                <td>{{ $p->kontrakanLama->nama }}</td>
                <td>{{ $p->kontrakanBaru->nama }}</td>
                <td>{{ $p->alasan }}</td>
                <td>{!! statusBadge($p->status) !!}</td>
            </tr>
        @endforeach
    </tbody>
</table>
