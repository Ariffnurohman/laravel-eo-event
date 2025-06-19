@extends('layouts.user')

@section('content')
<div class="container mt-4">
    {{-- Filter Form --}}
    <form method="GET" class="row row-cols-lg-auto g-2 align-items-center mb-3">
        <div class="col">
            <select name="kategori" class="form-select">
                <option value="">Semua Kategori</option>
                <option value="Seminar" {{ request('kategori') == 'Seminar' ? 'selected' : '' }}>Gratis</option>
                <option value="Workshop" {{ request('kategori') == 'Workshop' ? 'selected' : '' }}>Berbayar</option>
                <!-- Tambah kategori lainnya -->
            </select>
        </div>
        <div class="col">
            <input type="text" name="search" class="form-control" placeholder="Cari event..." value="{{ request('search') }}">
        </div>
        <div class="col">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    {{-- Judul --}}
    <h4 class="fw-bold mb-4">🔍 Jelajahi Event Menarik</h4>

    {{-- Promo Banner --}}
    <div class="row g-3 mb-4">
        @foreach($ads as $ad)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                @if ($ad->image_path && file_exists(public_path('storage/' . $ad->image_path)))
                <img src="{{ asset('storage/' . $ad->image_path) }}" class="card-img-top rounded-top-4" style="height: 180px; object-fit: cover;" alt="Promo">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $ad->title }}</h5>
                    <p class="card-text text-muted small">{{ $ad->message }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Event Populer --}}
    <h5 class="fw-semibold mb-3">🔥 Event Populer</h5>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4">
        @foreach($popularEvents as $event)
        <div class="col">
            <div class="card shadow-sm h-100 rounded-4 border-0">
                @if($event->foto)
                <img src="{{ asset($event->foto) }}" class="card-img-top rounded-top-4" style="height: 160px; object-fit: cover;" alt="Event Image">
                @endif
                <div class="card-body">
                    <h6 class="fw-bold">{{ $event->nama }}</h6>
                    <p class="small text-muted mb-1">📍 {{ $event->lokasi }}</p>
                    <p class="small text-muted">🗓 {{ \Carbon\Carbon::parse($event->waktu_mulai)->translatedFormat('d M Y, H:i') }}</p>
                    <a href="{{ route('user.events.show', $event->id) }}" class="btn btn-sm btn-outline-primary rounded-pill mt-2">Lihat Detail</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection