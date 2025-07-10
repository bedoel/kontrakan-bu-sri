@extends('user.layouts.app')

@section('content')
    <div class="container">
        {{-- Hero Slider --}}
        <div id="heroCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($slides as $index => $slide)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <img src="{{ $slide }}" class="d-block w-100" alt="Hero {{ $index }}">
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>

        {{-- Kontrakan Slider --}}
        <h3 class="mb-4">Kontrakan Tersedia</h3>
        <div class="row flex-nowrap overflow-auto">
            @foreach ($kontrakans as $kontrakan)
                <div class="col-10 col-md-4 col-lg-3 mb-3">
                    <div class="card h-100">
                        @if ($kontrakan->foto_kontrakans->first())
                            <img src="{{ asset('storage/' . $kontrakan->foto_kontrakans->first()->path) }}"
                                class="card-img-top" alt="Foto">
                        @else
                            <img src="https://picsum.photos/300/200?random={{ $loop->index }}" class="card-img-top"
                                alt="Random">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $kontrakan->nama }}</h5>
                            <p class="card-text">Rp {{ number_format($kontrakan->harga) }}</p>
                            <a href="{{ route('user.kontrakan.show', $kontrakan->id) }}"
                                class="btn btn-primary btn-sm">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
