<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin EO')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ffff;
        }

        .sidebar {
            background-color: #00848c;
        }

        .sidebar .nav-link {
            color: #fff;
        }

        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            background-color: #A3B18A;
            border-radius: 5px;
        }

        .main-header {
            background-color: #00848c !important;
            box-shadow: 0 2px 4px rgba(192, 189, 189, 0.1);
        }
    </style>
</head>

<body>

    {{-- ✅ Navbar atas --}}
    <nav class="navbar navbar-expand-lg main-header sticky-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">📋 Admin EO</a>
        </div>
    </nav>

    <div class="d-flex" style="min-height: 100vh">
        {{-- ✅ Sidebar --}}
        <aside class="sidebar p-4" style="width: 240px;">
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.events.index') }}" class="nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">🎯 Kelola Event</a>
                </li>
                <li class="nav-item mb-2">
                    @if($event)
                    <a href="{{ route('admin.participants.index', ['event' => $event->id]) }}" class="nav-link {{ request()->routeIs('admin.participants.*') ? 'active' : '' }}">👥 Peserta</a>
                    @endif
                </li>
                <li class="nav-item mb-2">
                    @if(isset($event))
                    <a href="{{ route('admin.events.stats', ['event' => $event->id]) }}"
                        class="nav-link {{ request()->routeIs('admin.events.stats') ? 'active' : '' }}">
                        📊 Statistik
                    </a>
                    @endif
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.scan.page') }}" class="nav-link {{ request()->routeIs('admin.scan.page') ? 'active' : '' }}">📲 Scan Kehadiran</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.ads.create') }}" class="nav-link {{ request()->routeIs('admin.ads.create') ? 'active' : '' }}">📢 Buat Iklan</a>
                </li>
            </ul>
        </aside>

        {{-- ✅ Konten Utama --}}
        <main class="flex-grow-1 p-4">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>