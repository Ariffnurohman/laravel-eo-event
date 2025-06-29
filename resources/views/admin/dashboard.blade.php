@extends('layouts.app') @section('title', 'Dashboard Admin') @section('content')

<div class="container mt-4">
    <div class="card shadow rounded-4 border-0">
        <div class="card-header bg-primary text-white rounded-top-4">
            <h5 class="mb-0">Selamat Datang, {{ $user->name }}</h5>
        </div>
        <div class="card-body">
            <h4 class="mb-3">Dasbor Admin</h4>
            <p class="mb-4">Kamu dapat mengelola <strong>event</strong>, <strong>peserta</strong>, <strong>kehadiran</strong>, dan <strong>sertifikat</strong> di sini.</p>
            <div class="d-grid gap-2 d-md-block">
                <a href="{{ route('admin.events.index') }}" class="btn btn-primary me-2 mb-2">Kelola Acara</a>
                <a href="{{ route('admin.events.stats') }}" class="btn btn-outline-info me-2 mb-2">📊 Lihat Statistik</a>
                <a href="{{ route('admin.scan') }}" class="btn btn-outline-warning me-2 mb-2">📷 Scan Kehadiran</a>
                <a href="{{ route('admin.events.stats', ['event' => $event->id]) }}" class="btn btn-sm btn-outline-primary">Kelola</a>
                <a href="{{ route('admin.ads.create') }}" class="btn btn-outline-primary me-2 mb-2">📢 Buat Iklan</a>

            </div>

            <hr class="my-4">
            <h5>Form Scan QR Kehadiran Manual</h5>
            @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if (session('info'))
            <div class="alert alert-info">{{ session('info') }}</div>
            @endif

            <form action="{{ route('logout') }}" method="POST">
                @csrf
            </form>
        </div>
    </div>

</div>
@endsection