@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Tambah Event Baru</h4>

    <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Nama Event</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label>Lokasi</label>
            <input type="text" name="lokasi" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Jenis</label>
            <select name="jenis" class="form-control" required>
                <option value="gratis">Gratis</option>
                <option value="berbayar">Berbayar</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Waktu Mulai</label>
            <input type="datetime-local" name="waktu_mulai" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Waktu Selesai</label>
            <input type="datetime-local" name="waktu_selesai" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Kuota</label>
            <input type="number" name="kuota" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Keluarkan Sertifikat?</label>
            <select name="mengeluarkan_sertifikat" class="form-control">
                <option value="1">Ya</option>d
                <option value="0">Tidak</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="foto" class="form-label">Upload Foto Event</label>
            <input type="file" name="foto" class="form-control">
        </div>
        <button class="btn btn-success">Simpan</button>

    </form>
</div>
<div class="container mt-4">
    <a href="{{ route('dashboard') }}" class="btn btn-secondary mb-3">⬅ Kembali</a>
</div>
@endsection