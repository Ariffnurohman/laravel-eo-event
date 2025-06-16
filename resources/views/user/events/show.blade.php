@extends('layouts.user')

@section('content')
<div class="container mt-5">
    <div class="card shadow rounded-4 border-0">
        <div class="card-header bg-primary text-white rounded-top-4">
            <h4 class="mb-0">📌 Detail Event</h4>
        </div>

        <div class="card-body">
            {{-- Pesan sukses jika ada --}}
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif


            @if ($event->foto)
            <img src="{{ asset($event->foto) }}"
                alt="Foto Event"
                class="img-fluid rounded mb-3"
                style="max-height: 300px; object-fit: cover; width: 100%;">
            @endif

            <h5 class="card-title">{{ $event->nama }}</h5>

            <p><strong>Lokasi:</strong> {{ $event->lokasi ?? '-' }}</p>
            <p><strong>Waktu:</strong>
                {{ \Carbon\Carbon::parse($event->waktu_mulai)->translatedFormat('d M Y H:i') }}
                -
                {{ \Carbon\Carbon::parse($event->waktu_selesai)->translatedFormat('d M Y H:i') }}
            </p>

            <p><strong>Deskripsi:</strong><br>
                {{ $event->deskripsi ?? 'Tidak ada deskripsi.' }}
            </p>

            <div class="d-flex flex-column gap-2 mt-4">
                {{-- Tombol daftar --}}
                @if(!$alreadyRegistered)
                <form method="POST" action="{{ route('user.events.register', $event->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-success w-100">
                        ✅ Daftar Event Ini
                    </button>
                </form>
                @else
                <button class="btn btn-secondary w-100" disabled>
                    ✔ Kamu sudah mendaftar
                </button>
                @endif

                {{-- Tombol kembali --}}
                <a href="{{ route('user.events.index') }}" class="btn btn-outline-dark w-100">
                    ⬅ Kembali ke Daftar Event
                </a>
            </div>
        </div>
    </div>
</div>
@endsection