@extends('layouts.app')

@section('title', 'Kelola Event')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">📋 Manajemen Event</h4>

    <a href="{{ route('admin.events.create') }}" class="btn btn-primary mb-3">+ Tambah Event</a>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @forelse ($events as $event)
        <div class="col">
            <div class="card h-100 shadow-sm">
                @if($event->foto)
                <img src="{{ asset($event->foto) }}" class="card-img-top" alt="Banner Event" style="height: 160px; object-fit: cover;">
                @endif

                <div class="card-body">
                    <small class="text-muted d-block mb-2">📍 {{ $event->lokasi ?? 'Tidak ada lokasi' }}</small>
                    <h5 class="card-title">{{ $event->nama }}</h5>
                    <p class="text-muted mb-2">
                        🗓 {{ \Carbon\Carbon::parse($event->waktu_mulai)->translatedFormat('d M Y H:i') }}<br>
                        💼 Jenis: {{ ucfirst($event->jenis) }}<br>
                        👥 Kuota: {{ $event->kuota }}
                    </p>

                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('admin.events.stats', ['event' => $event->id]) }}" class="btn btn-sm btn-outline-primary">Kelola</a>
                        <a href="{{ route('admin.participants.index', ['event' => $event->id]) }}" class="btn btn-sm btn-outline-success">👥 Peserta</a>
                        <a href="{{ route('admin.events.create') }}" class="btn btn-sm btn-outline-warning">✏ Edit</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">Belum ada event terdaftar.</div>
        </div>
        @endforelse
    </div>
</div>
@endsection