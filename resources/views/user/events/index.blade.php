@extends('layouts.user')

@section('content')
<div class="container mt-4">
    <div class="card shadow rounded-4 border-0">
        <div class="card-header bg-primary text-white rounded-top-4">
            <h5 class="mb-0">📅 Daftar Event</h5>
        </div>


        <div class="card-body">
            @if ($events->isEmpty())
            <div class="alert alert-info">Belum ada event yang tersedia saat ini.</div>
            @else
            <div class="row row-cols-1 row-cols-md-2 g-4">
                @foreach ($events as $event)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 rounded-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $event->nama }}</h5>
                            <p class="card-text">
                                {{ $event->deskripsi ?? 'Tidak ada deskripsi.' }} <br>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($event->waktu_mulai)->translatedFormat('d M Y H:i') }}
                                </small>
                            </p>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <a href="{{ route('user.events.show', $event->id) }}" class="btn btn-sm btn-outline-primary mb-2 w-100">
                                📖 Lihat Detail
                            </a>

                            @if (!in_array($event->id, $joinedEventIds))
                            <form action="{{ route('user.events.register', $event->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success w-100">
                                    ✅ Daftar Sekarang
                                </button>
                            </form>
                            @else
                            <button class="btn btn-sm btn-secondary w-100" disabled>✔ Sudah Terdaftar</button>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection