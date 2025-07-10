@extends('user.layouts.app')

@section('content')
    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade"
        style="background-image: url('{{ asset('front/assets/img/hero-2.jpg') }}');">
        <div class="container position-relative">
            <h1>Edit Testimoni</h1>
            <p>Perbarui pesan dan rating pengalaman Anda menyewa kontrakan</p>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('user.home') }}">Home</a></li>
                    <li><a href="{{ route('user.testimoni.index') }}">Testimoni</a></li>
                    <li class="current">Edit</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Form Section -->
    <section class="starter-section section">
        <div class="container" data-aos="fade-up">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h4 class="mb-4">Form Edit Testimoni</h4>

                            <form action="{{ route('user.testimoni.update', $testimoni->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="pesan" class="form-label">Pesan</label>
                                    <textarea name="pesan" class="form-control" rows="4" required>{{ old('pesan', $testimoni->pesan) }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="rating" class="form-label">Rating</label>
                                    <select name="rating" class="form-select" required>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}"
                                                {{ $testimoni->rating == $i ? 'selected' : '' }}>
                                                {{ $i }} Bintang</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="gambar" class="form-label">Gambar (Opsional)</label>
                                    <input type="file" name="gambar" class="form-control">
                                    @if ($testimoni->gambar)
                                        <img src="{{ asset('storage/' . $testimoni->gambar) }}" class="img-thumbnail mt-2"
                                            width="150">
                                    @endif
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('user.testimoni.index') }}" class="btn btn-secondary">Batal</a>
                                    <button type="submit" class="btn btn-success">Update Testimoni</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
