@component('mail::message')
    # Halo, {{ $sewa->user->name }}

    Ini adalah pengingat bahwa masa sewa kontrakan Anda **({{ $sewa->kontrakan->nama }})** akan berakhir pada
    **{{ \Carbon\Carbon::parse($sewa->tanggal_akhir)->format('d M Y') }}**.

    Silakan lakukan perpanjangan atau hubungi admin jika perlu bantuan.

    @component('mail::button', ['url' => route('user.sewa.index')])
        Lihat Sewa Saya
    @endcomponent

    Terima kasih,<br>
    {{ config('app.name') }}
@endcomponent
