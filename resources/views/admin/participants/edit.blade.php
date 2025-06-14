@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h4>Ubah Status Kehadiran</h4>

    <form action="{{ route('admin.participants.update', $participant->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" class="form-control" value="{{ $participant->user->name }}" disabled>
        </div>

        <div class="mb-3">
            <label>Status Kehadiran</label>
            <select name="status_kehadiran" class="form-select">
                <option value="belum" {{ $participant->status_kehadiran == 'belum' ? 'selected' : '' }}>Belum</option>
                <option value="hadir" {{ $participant->status_kehadiran == 'hadir' ? 'selected' : '' }}>Hadir</option>
                <option value="tidak" {{ $participant->status_kehadiran == 'tidak' ? 'selected' : '' }}>Tidak Hadir</option>
            </select>
        </div>

        <button class="btn btn-success">💾 Simpan</button>
        <a href="{{ route('admin.participants.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection