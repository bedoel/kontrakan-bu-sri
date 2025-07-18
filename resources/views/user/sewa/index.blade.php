@extends('user.layouts.app')

@section('title', 'Daftar Sewa')

@section('content')
    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade"
        style="background-image: url('{{ asset('front/assets/img/hero-bg2.jpeg') }}');">
        <div class="container position-relative">
            <h1>Daftar Sewa</h1>
            <p>Informasi semua kontrakan yang telah Anda sewa.</p>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('user.home') }}">Home</a></li>
                    <li class="current">Daftar Sewa</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Sewa Aktif -->
    <section class="starter-section section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Sewa Aktif</h2>
            <p>Kontrakan yang sedang disewa atau sedang dalam proses sewa.</p>
        </div>

        <div class="container" data-aos="fade-up">
            @forelse ($sewaAktif as $sewa)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $sewa->kontrakan->nama }}</h5>
                        <p class="card-text">
                            <strong>Periode:</strong>
                            {{ \Carbon\Carbon::parse($sewa->tanggal_mulai)->format('d M Y') }} -
                            {{ \Carbon\Carbon::parse($sewa->tanggal_akhir)->format('d M Y') }}<br>
                            <strong>Status:</strong> {!! statusBadge($sewa->status) !!}
                        </p>

                        {{-- Info Pindahan --}}
                        @php
                            $pindahDisetujui = $permintaanDisetujui[$sewa->id] ?? null;
                        @endphp

                        @if ($pindahDisetujui && $pindahDisetujui->kontrakanLama)
                            <div class="alert alert-info small mb-3">
                                <strong>Pindahan dari:</strong> {{ $pindahDisetujui->kontrakanLama->nama }}
                                @if ($pindahDisetujui->created_at)
                                    (disetujui pada {{ $pindahDisetujui->created_at->translatedFormat('d M Y') }})
                                @endif
                            </div>
                        @endif

                        {{-- Tombol detail --}}
                        <a href="{{ route('user.sewa.show', $sewa->id) }}" class="btn btn-sm btn-outline-primary">Detail</a>

                        {{-- Pengajuan Pindah --}}
                        @php
                            $pindah = \App\Models\PermintaanPindahKontrakan::with('kontrakanBaru')
                                ->where('sewa_id', $sewa->id)
                                ->whereIn('status', ['menunggu', 'disetujui'])
                                ->latest()
                                ->first();
                        @endphp

                        @if ($sewa->status === 'aktif')
                            @if (!$punyaPermintaanMenunggu)
                                <a href="{{ route('user.pindah.create') }}" class="btn btn-sm btn-outline-warning">Ajukan
                                    Pindah</a>
                            @else
                                <div class="alert alert-warning">Anda sudah mengajukan permintaan pindah. Mohon tunggu
                                    konfirmasi admin.</div>
                            @endif
                            @if ($pindah)
                                <div class="alert alert-warning mt-2 small">
                                    <strong>Pengajuan Pindah:</strong><br>
                                    Ke: <strong>{{ $pindah->kontrakanBaru->nama ?? '-' }}</strong><br>
                                    Status: <strong>{!! statusBadge($pindah->status) !!}
                                    </strong>
                                </div>
                            @endif
                        @endif

                        {{-- Perpanjang --}}
                        @php
                            $now = \Carbon\Carbon::now();
                            $tanggalAkhir = \Carbon\Carbon::parse($sewa->tanggal_akhir);
                            $hMin7 = $tanggalAkhir->copy()->subDays(7);
                            $hPlus7 = $tanggalAkhir->copy()->addDays(7);
                            $hariTersisa = $now->diffInDays($tanggalAkhir, false);
                        @endphp


                        @if ($sewa->status == 'aktif' && $now->between($hMin7, $hPlus7))
                            <button type="button" class="btn btn-sm btn-outline-success mt-2" data-bs-toggle="modal"
                                data-bs-target="#perpanjangModal{{ $sewa->id }}">Perpanjang</button>

                            <!-- Modal -->
                            <div class="modal fade" id="perpanjangModal{{ $sewa->id }}" tabindex="-1"
                                aria-labelledby="perpanjangModalLabel{{ $sewa->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('user.sewa.perpanjang', $sewa->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="perpanjangModalLabel{{ $sewa->id }}">
                                                    Perpanjang Sewa</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Nama Kontrakan:</strong> {{ $sewa->kontrakan->nama }}</p>
                                                <div class="mb-3">
                                                    <label for="jumlah_bulan" class="form-label">Jumlah Bulan</label>
                                                    <select name="jumlah_bulan" id="jumlah_bulan_{{ $sewa->id }}"
                                                        class="form-select" required
                                                        onchange="updateTotalBayar{{ $sewa->id }}()">
                                                        @for ($i = 1; $i <= 12; $i++)
                                                            <option value="{{ $i }}"
                                                                {{ $i == 1 ? 'selected' : '' }}>{{ $i }} bulan
                                                            </option>
                                                        @endfor
                                                    </select>

                                                </div>
                                                <small class="text-muted">
                                                    <ul class="mb-2 small">
                                                        <li>Diskon: 25rb/bulan (3–5 bulan), 50rb/bulan (6–12 bulan)</li>
                                                        <li>Denda: 25rb jika lewat jatuh tempo</li>
                                                    </ul>
                                                </small>
                                                <div class="border rounded p-2">
                                                    <p class="mb-1"><strong>Harga / Bulan:</strong> Rp
                                                        {{ number_format($sewa->kontrakan->harga) }}</p>
                                                    <p class="mb-1"><strong>Diskon:</strong> <span
                                                            id="diskon_{{ $sewa->id }}">Rp 0</span></p>
                                                    <p class="mb-1"><strong>Denda:</strong> <span
                                                            id="denda_{{ $sewa->id }}">Rp
                                                            {{ $hariTersisa < 0 ? number_format(25000) : '0' }}</span></p>
                                                    <p class="mb-0"><strong>Total Bayar:</strong> <span
                                                            id="total_bayar_{{ $sewa->id }}">Rp
                                                            {{ number_format($sewa->kontrakan->harga) }}</span></p>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Ajukan Perpanjangan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <script>
                                function updateTotalBayar{{ $sewa->id }}() {
                                    const harga = {{ $sewa->kontrakan->harga }};
                                    const bulan = parseInt(document.getElementById('jumlah_bulan_{{ $sewa->id }}').value);
                                    let diskon = 0;
                                    let denda = {{ $hariTersisa < 0 ? 25000 : 0 }};

                                    if (bulan >= 3 && bulan <= 5) {
                                        diskon = 25000 * bulan;
                                    } else if (bulan >= 6) {
                                        diskon = 50000 * bulan;
                                    }

                                    const total = (harga * bulan) - diskon + denda;

                                    document.getElementById('diskon_{{ $sewa->id }}').innerText = 'Rp ' + new Intl.NumberFormat('id-ID')
                                        .format(diskon);
                                    document.getElementById('denda_{{ $sewa->id }}').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(
                                        denda);
                                    document.getElementById('total_bayar_{{ $sewa->id }}').innerText = 'Rp ' + new Intl.NumberFormat('id-ID')
                                        .format(total);
                                }

                                document.addEventListener('DOMContentLoaded', function() {
                                    updateTotalBayar{{ $sewa->id }}();
                                });
                            </script>
                        @endif
                    </div>
                </div>
            @empty
                <div class="alert alert-info">Anda belum memiliki sewa aktif.</div>
            @endforelse
        </div>
    </section>

    <!-- Riwayat -->
    <section class="starter-section section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Riwayat Sewa</h2>
            <p>Sewa kontrakan yang sudah selesai atau batal.</p>
        </div>

        <div class="container" data-aos="fade-up">
            @forelse ($riwayatSewa as $sewa)
                <div class="card mb-3 border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $sewa->kontrakan->nama }}</h5>
                        <p class="card-text">
                            <strong>Periode:</strong>
                            {{ \Carbon\Carbon::parse($sewa->tanggal_mulai)->format('d M Y') }} -
                            {{ \Carbon\Carbon::parse($sewa->tanggal_akhir)->format('d M Y') }}<br>
                            <strong>Status:</strong> {!! statusBadge($sewa->status) !!}

                        </p>
                        <a href="{{ route('user.sewa.show', $sewa->id) }}" class="btn btn-sm btn-outline-secondary">Lihat
                            Detail</a>
                    </div>
                </div>
            @empty
                <div class="alert alert-secondary">Belum ada riwayat sewa.</div>
            @endforelse
        </div>
    </section>
@endsection
