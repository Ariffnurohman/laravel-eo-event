@extends('layouts.user') @php use Illuminate\Support\Facades\Storage; @endphp

@section('content')
<style>
    .card:hover {
        transform: translateY(-3px);
        transition: 0.3s ease;
    }
</style>

<div class="container mt-4">
    <div class="alert alert-success">
        👋 Selamat datang, <strong>{{ Auth::user()->name }}</strong>!
    </div>
    <h5 class="mb-4">📌 Event yang Kamu Ikuti</h5>
    @if ($joinedEvents->isEmpty())
    <div class="alert alert-info">Kamu belum mendaftar event manapun.</div>
    @else
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach ($joinedEvents as $p)
        <div class="col">
            <div class="card shadow-sm h-100">
                @if($p->event->foto)
                <img src="{{ asset($p->event->foto) }}" class="card-img-top" style="height: 170px; object-fit: cover;" alt="Banner Event">
                @endif

                <div class="card-body">
                    <small class="text-muted d-block mb-1">
                        📍 {{ $p->event->lokasi ?? 'Lokasi belum ditentukan' }}
                    </small>

                    <h5 class="card-title mb-1">{{ $p->event->nama }}</h5>

                    <p class="mb-1 text-muted">
                        🗓 {{ \Carbon\Carbon::parse($p->event->waktu_mulai)->translatedFormat('d M Y') }} <br>
                        ⏰ {{ \Carbon\Carbon::parse($p->event->waktu_mulai)->translatedFormat('H:i') }}
                    </p>

                    <span class="badge bg-{{ $p->status_kehadiran == 'hadir' ? 'success' : ($p->status_kehadiran == 'tidak' ? 'danger' : 'secondary') }}">
                        Kehadiran: {{ ucfirst($p->status_kehadiran) }}
                    </span>

                    <div class="mt-3 d-grid gap-2">
                        @if ($p->qr_code_path)
                        <a href="{{ asset($p->qr_code_path) }}" class="btn btn-outline-dark btn-sm" target="_blank">📲 QR Code</a>
                        @endif


                        @if ($p->event->jenis === 'berbayar')
                        <form action="{{ route('peserta.upload.bukti', $p->event->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="bukti_pembayaran" class="form-control form-control-sm mb-2" required>
                            <button type="submit" class="btn btn-primary btn-sm">Upload Bukti Pembayaran</button>
                        </form>

                        @if ($p->bukti_pembayaran)
                        <span class="badge mt-2 bg-{{ $p->status_pembayaran === 'diterima' ? 'success' : ($p->status_pembayaran === 'ditolak' ? 'danger' : 'warning') }}">
                            Status: {{ ucfirst($p->status_pembayaran) }}
                        </span>
                        @endif
                        @endif
                        @if ($p->status_kehadiran === 'hadir' && $p->certificate)
                        <a href="{{ Storage::url($p->certificate->file_path) }}" class="btn btn-sm btn-outline-success mt-2" target="_blank">
                            📄 Unduh Sertifikat
                        </a>
                        @endif

                        <a href="{{ route('user.events.show', $p->event->id) }}" class="btn btn-sm btn-outline-secondary">Lihat Detail</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- Event Tersedia --}}
    <div class="container mt-4">
        <h5 class="mt-5 mb-4">📅 Event Tersedia</h5>
        @if ($availableEvents->isEmpty())
        <div class="alert alert-success">Tidak ada event baru untuk didaftarkan.</div>
        @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($availableEvents as $event)
            <div class="col">
                <div class="card shadow-sm h-100">
                    @if($event->foto)
                    <img src="{{ asset($event->foto) }}" class="card-img-top" style="height: 170px; object-fit: cover;" alt="Banner Event">
                    @endif

                    <div class="card-body">
                        <small class="text-muted d-block mb-1">
                            📍 {{ $event->lokasi ?? 'Lokasi belum ditentukan' }}
                        </small>

                        <h5 class="card-title mb-1">{{ $event->nama }}</h5>

                        <p class="mb-1 text-muted">
                            🗓 {{ \Carbon\Carbon::parse($event->waktu_mulai)->translatedFormat('d M Y') }} <br>
                            ⏰ {{ \Carbon\Carbon::parse($event->waktu_mulai)->translatedFormat('H:i') }}
                        </p>

                        <p class="mb-2">
                            💰 <strong>{{ $event->jenis === 'berbayar' ? 'Berbayar' : 'Gratis' }}</strong>
                        </p>

                        <div class="d-flex gap-2">
                            <form action="{{ route('user.events.show', $event->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-primary">Daftar Sekarang</button>
                            </form>
                            <a href="{{ route('user.events.show', $event->id) }}" class="btn btn-sm btn-outline-secondary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
    @endsection