@extends('layouts.app') @section('title', 'Dashboard Admin')


@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Kelola Iklan & Promo</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.ads.create') }}" class="btn btn-primary mb-3">+ Tambah Iklan</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Pesan</th>
                <th>Gambar</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($ads as $ad)
                <tr>
                    <td>{{ $ad->title }}</td>
                    <td>{{ $ad->message }}</td>
                    <td>
                        @if ($ad->image_path)
                            <img src="{{ Storage::url($ad->image_path) }}" width="100" class="img-thumbnail">
                        @endif
                    </td>
                    <td>
                        @if($ad->is_active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="#" class="btn btn-sm btn-warning">Edit</a>
                        {{-- Tambahkan tombol aktif/nonaktif jika mau --}}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada iklan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection