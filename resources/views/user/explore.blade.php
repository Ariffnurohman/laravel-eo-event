@extends('layouts.user')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">📢 Iklan & Promo</h4>

    @forelse ($ads as $ad)
        <div class="card mb-3 shadow-sm border-0 rounded-4">
            <div class="card-body">
                <h5 class="card-title">{{ $ad->title }}</h5>
                <p class="card-text">{{ $ad->message }}</p>
                @if ($ad->image_path)
                    <img src="{{ Storage::url($ad->image_path) }}" class="img-fluid rounded mt-2">
                @endif
            </div>
        </div>
    @empty
        <div class="alert alert-info">Belum ada iklan yang tersedia.</div>
    @endforelse
</div>
@endsection