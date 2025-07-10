@component('mail::message')
    # Notifikasi Admin

    {{ $messageText }}

    @if ($url)
        @component('mail::button', ['url' => $url])
            Lihat Detail
        @endcomponent
    @endif

    Terima kasih,<br>
    {{ config('app.name') }}
@endcomponent
