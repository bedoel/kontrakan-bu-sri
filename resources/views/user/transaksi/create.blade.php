@extends('user.layouts.app')

@section('title', 'Pembayaran Sewa')

@section('content')
    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade"
        style="background-image: url('{{ asset('front/assets/img/hero-2.jpg') }}');">
        <div class="container position-relative">
            <h1>Pembayaran Sewa</h1>
            <p>Silakan lengkapi pembayaran untuk kontrakan yang telah Anda pilih.</p>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('user.home') }}">Home</a></li>
                    <li class="current">Pembayaran</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- End Page Title -->

    <section class="starter-section section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Form Pembayaran</h2>
            <p>Lengkapi bukti pembayaran Anda</p>
        </div>

        <div class="container" data-aos="fade-up">
            <form action="{{ route('user.transaksi.store', $sewa->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
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
                    <label class="form-label">Total Bayar</label>
                    <input type="text" class="form-control" value="Rp {{ number_format($total) }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="metode" class="form-label">Metode Pembayaran</label>
                    <select name="metode" id="metode" class="form-select" required>
                        <option value="">-- Pilih Metode --</option>
                        <option value="transfer">Transfer</option>
                        <option value="cash">Cash</option>
                    </select>
                </div>

                <div class="mb-3" id="buktiTransferField" style="display: none;">
                    <label for="bukti_transfer" class="form-label">Upload Bukti Transfer</label>
                    <input type="file" name="bukti_transfer" class="form-control" accept="image/*">
                    <small class="text-muted">Hanya isi jika metode transfer</small>
                </div>

                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan (Opsional)</label>
                    <textarea name="catatan" class="form-control" rows="3"></textarea>
                </div>

                <button class="btn btn-primary"><i class="bi bi-send-check"></i> Kirim Pembayaran</button>
                <a href="{{ route('user.sewa.show', $sewa->id) }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const metodeSelect = document.getElementById('metode');
            const buktiField = document.getElementById('buktiTransferField');

            metodeSelect.addEventListener('change', function() {
                if (this.value === 'transfer') {
                    buktiField.style.display = 'block';
                } else {
                    buktiField.style.display = 'none';
                }
            });
        });
    </script>
@endpush
