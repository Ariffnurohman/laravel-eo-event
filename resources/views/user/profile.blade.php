@extends('layouts.user')

@section('content')
@php
use Illuminate\Support\Str;
@endphp
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<div class="container mt-5 d-flex justify-content-center">
    <div class="card shadow-sm border rounded-4 p-4" style="max-width: 400px; width: 100%; background: #ffffff;">
        <div class="card-body text-center">

            {{-- Foto Profil --}}
            @if ($user->foto)
            <img src="{{ asset($user->foto) }}" class="rounded-circle shadow mb-3" alt="Foto Profil""
                style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #dee2e6;">
            @else
            <img src="{{ asset('images/default.jpg') }}" class="rounded-circle shadow mb-3"
                style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #dee2e6;">
            @endif

            {{-- Nama dan Email --}}
            <h5 class="fw-bold mb-0">{{ $user->name }}</h5>
            <small class="text-muted d-block mb-2">
                {{ $user->email }}
            </small>

            {{-- Social Icons --}}
            <div class="mb-3">
                <a href="#" class="text-secondary mx-2"><i class="bi bi-facebook fs-5"></i></a>
                <a href="#" class="text-secondary mx-2"><i class="bi bi-twitter fs-5"></i></a>
                <a href="#" class="text-secondary mx-2"><i class="bi bi-instagram fs-5"></i></a>
            </div>

            {{-- Tombol --}}
            <a href="{{ route('profile.edit') }}" class="btn btn-primary rounded-pill px-4 mb-4">
                <i class="bi bi-pencil-square me-1"></i> Edit Profil
            </a>

            <hr class="my-3">

            {{-- Statistik --}}
            <div class="row text-center">
                <div class="col">
                    <h5 class="fw-bold">{{ $totalEvent }}</h5>
                    <small class="text-muted">Event Diikuti</small>
                </div>
                <div class="col">
                    <h5 class="fw-bold">{{ $totalHadir }}</h5>
                    <small class="text-muted">Sudah Hadir</small>
                </div>
                <div class="col">
                    <h5 class="fw-bold">{{ $totalBerbayar }}</h5>
                    <small class="text-muted">Event Berbayar</small>
                </div>
            </div>


        </div>
    </div>
</div>

@endsection