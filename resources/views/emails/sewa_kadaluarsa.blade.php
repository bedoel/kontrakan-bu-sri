<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Pemberitahuan Sewa Kadaluarsa</title>
</head>

<body>
    <p>Halo {{ $sewa->user->name }},</p>

    <p>Masa sewa kontrakan <strong>{{ $sewa->kontrakan->nama }}</strong> Anda telah <strong>melewati batas waktu 7 hari
            setelah jatuh tempo</strong>.</p>

    <p>Mohon segera menghubungi admin untuk melakukan perpanjangan secara langsung dan menyelesaikan denda sebesar
        <strong>Rp50.000</strong>.</p>

    <p>Terima kasih telah menggunakan layanan kami.</p>
</body>

</html>
