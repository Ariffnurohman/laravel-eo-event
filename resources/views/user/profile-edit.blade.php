@extends('layouts.user')

@section('content')
<div class="container mt-4">
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-warning text-dark rounded-top-4">
            <h5 class="mb-0">✏ Edit Profil</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto Profil</label><br>
                    @if ($user->profile_photo)
                    <img src="{{ Storage::url($user->profile_photo) }}" width="80" class="rounded-circle mb-2">
                    @endif
                    <input type="file" name="profile_photo" class="form-control">
                </div>

                <button type="submit" class="btn btn-success">💾 Simpan</button>
                <a href="{{ route('profile') }}" class="btn btn-secondary">⬅ Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection