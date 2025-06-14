@extends('layouts.user')

@section('content')
<div class="container mt-4">
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4">
            <h5 class="mb-0">🔒 Ubah Password</h5>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('profile.password.update') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Password Lama</label>
                    <input type="password" name="current_password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="new_password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="new_password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success">💾 Simpan Password</button>
                <a href="{{ route('profile') }}" class="btn btn-secondary">⬅ Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection