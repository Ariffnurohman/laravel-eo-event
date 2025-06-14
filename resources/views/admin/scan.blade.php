@extends('layouts.app')

@section('title', 'Scan QR Kehadiran Peserta')

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="container mt-4">
    <h4 class="mb-4">📷 Scan QR Kehadiran Peserta</h4>

    {{-- Area preview kamera --}}
    <div id="preview" class="rounded shadow mb-3" style="width:100%; max-width: 600px; height: 400px;"></div>

    {{-- Form tersembunyi untuk submit --}}
    <form method="POST" action="{{ route('admin.scan.from.qr') }}" id="scan-form">
        @csrf
        <input type="hidden" name="user_id" id="user_id">
        <input type="hidden" name="event_id" id="event_id">
    </form>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    const html5QrCode = new Html5Qrcode("preview");

    function onScanSuccess(decodedText) {
        const params = new URLSearchParams(decodedText.split('?')[1]);
        const userId = params.get('user_id');
        const eventId = params.get('event_id');

        if (userId && eventId) {
            document.getElementById('user_id').value = userId;
            document.getElementById('event_id').value = eventId;
            document.getElementById('scan-form').submit();
            html5QrCode.stop();
        }
    }

    Html5Qrcode.getCameras().then(devices => {
        if (devices && devices.length > 0) {
            html5QrCode.start(
                devices[0].id,
                {
                    fps: 10,
                    qrbox: 250
                },
                onScanSuccess
            ).catch(err => {
                console.error("Start Kamera Error:", err);
                alert("Gagal memulai kamera.");
            });
        } else {
            alert("Kamera tidak ditemukan.");
        }
    }).catch(err => {
        console.error("Kamera error:", err);
        alert("Tidak bisa mengakses kamera.");
    });
</script>
@endpush