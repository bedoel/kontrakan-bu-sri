@extends('user.layouts.app')

@section('title', 'Edit Profil')

@section('content')
    <div class="page-title dark-background" data-aos="fade"
        style="background-image: url('{{ asset('front/assets/img/hero-2.jpg') }}');">
        <div class="container position-relative">
            <h1>Edit Profil</h1>
            <p>Ubah data akun dan informasi pribadi Anda.</p>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('user.home') }}">Home</a></li>
                    <li class="current">Edit Profil</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Edit Profile Section -->
    <section class="starter-section section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Edit Profil Anda</h2>
            <p>Perbarui data Anda jika terjadi perubahan.</p>
        </div>

        <div class="container" data-aos="fade-up">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data"
                class="card shadow-sm p-4">
                @csrf @method('PUT')

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nomor HP</label>
                    <input type="text" name="nomor_hp" class="form-control"
                        value="{{ old('nomor_hp', $user->nomor_hp) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Password Baru
                        <small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small></label>
                    <input type="password" name="password" class="form-control" placeholder="********">
                </div>

                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="********">
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto Profil</label><br>
                    @if ($user->poto_profil)
                        <img src="{{ asset('storage/' . $user->poto_profil) }}" width="80" class="img-thumbnail mb-2">
                    @endif
                    <input type="file" name="poto_profil" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </section>
@endsection
