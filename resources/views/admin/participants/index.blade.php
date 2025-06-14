@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Manajemen Peserta</h3>

    <form method="GET" class="mb-3 d-flex gap-2">
        <input type="text" name="search" class="form-control" placeholder="Cari peserta..." value="{{ request('search') }}">
        <select name="event_id" class="form-select">
            <option value="">Semua Event</option>
            @foreach ($events as $event)
            <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>{{ $event->nama }}</option>
            @endforeach
        </select>
        <button class="btn btn-primary">🔍 Filter</button>
    </form>

    @if ($participants->isEmpty())
    <div class="alert alert-warning">Tidak ada peserta ditemukan.</div>
    @else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Event</th>
                <th>Status Kehadiran</th>
                <th>Aksi</th>
                <th>Bukti Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($participants as $p)
            <tr>
                <td>{{ $p->user->name }}</td>
                <td>{{ $p->user->email }}</td>
                <td>{{ $p->event->nama }}</td>
                <td>
                    <span class="badge bg-{{ $p->status_kehadiran == 'hadir' ? 'success' : ($p->status_kehadiran == 'tidak' ? 'danger' : 'secondary') }}">
                        {{ ucfirst($p->status_kehadiran) }}
                    </span>
                </td>
                <td class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('admin.participants.edit', $p->id) }}" class="btn btn-sm btn-warning">✏ Ubah</a>

                    @if ($p->status_kehadiran == 'hadir')
                    <a href="{{ route('admin.certificate.generate', $p->id) }}" class="btn btn-sm btn-success">📄 Sertifikat</a>
                    @endif
                </td>
                <td>
                    @if ($p->bukti_pembayaran)
                    <a href="{{ asset(str_replace('public/', 'storage/', $p->bukti_pembayaran)) }}" target="_blank">Lihat</a>
                </td>
                <td>

                    {{-- Tampilkan tombol ubah status jika statusnya belum diterima --}}
                    @if ($p->status_pembayaran != 'diterima')
                    <form action="{{ route('admin.participants.verifyPayment', $p->id) }}" method="POST" class="mt-2">
                        @csrf
                        @method('PUT')
                        <select name="status_pembayaran" class="form-select form-select-sm d-inline w-auto">
                            <option value="pending" {{ $p->status_pembayaran == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="diterima" {{ $p->status_pembayaran == 'diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="ditolak" {{ $p->status_pembayaran == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-success">✔ Simpan</button>
                    </form>
                    @endif
                    @else
                    Belum ada
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="container mt-4">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary mb-3">⬅ Kembali</a>
    </div>

    {{ $participants->links() }}
    @endif
</div>
@endsection