<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="d-flex">
        {{-- Sidebar --}}
        <div class="bg-dark text-white p-3" style="width: 250px; height: 100vh;">
            <h5 class="mb-4">📋 Admin EO</h5>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.events.index') }}" class="nav-link text-white">Kelola Event</a>
                </li>
                <li class="nav-item mb-2">
                    @if($event)
                    <a href="{{ route('admin.participants.index', ['event' => $event->id]) }}" class="nav-link text-white">Peserta</a>
                    @endif
                </li>
                <li class="nav-item mb-2">
                    @if($event)
                    <a href="{{ route('admin.events.stats', ['event' => $event->id]) }}" class="nav-link text-white">Statistik</a>
                    @endif

                </li>
                <li class="nav-item mt-4">
                    <a href="{{ route('admin.ads.create') }}" class="nav-link text-warning">Buat Iklan</a>
                </li>
            </ul>
        </div>

        {{-- Konten utama --}}
        <div class="flex-grow-1 p-4">
            @yield('content')
        </div>
    </div>
</body>

</html>