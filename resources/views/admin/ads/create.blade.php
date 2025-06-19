@extends('layouts.app') @section('title', 'Dashboard Admin')


@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Tambah Iklan / Promo</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.ads.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-3">
            <label for="title" class="form-label">Judul Iklan</label>
            <input type="text" name="title" id="title" class="form-control" required value="{{ old('title') }}">
        </div>

        <div class="mb-3">
            <label for="message" class="form-label">Pesan Iklan</label>
            <textarea name="message" id="message" rows="4" class="form-control" required>{{ old('message') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Gambar Iklan</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>

        <div class="mb-3">
            <label for="is_active" class="form-label">Status</label>
            <select name="is_active" id="is_active" class="form-control">
                <option value="1" selected>Aktif</option>
                <option value="0">Nonaktif</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.ads.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection