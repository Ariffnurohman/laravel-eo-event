<!DOCTYPE html><html lang="id"><head>
    <meta charset="UTF-8">
    <title>Dashboard Peserta - EO Event</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #FFFF;
        }.navbar {
        background-color: #00848C !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .btn-primary {
        background-color: #00848C;
        border: none;
    }

    .btn-primary:hover {
        background-color: #00848C;
    }

    .card-header {
        background-color: #C1D3A3 !important;
        color: #333;
    }

    .nav-link.active {
        font-weight: bold;
        color: #ffff !important;
    }

    .navbar-brand {
        color: #FFFF !important;
    }
</style>

</head><body>{{-- Navbar Peserta --}}
<nav class="navbar navbar-expand-lg navbar-light text-dark sticky-top">
    <div class="container">
    <img src="{{ asset('images/logo-eo.png') }}" alt="Logo" class="me-3 img-fluid" style="height: 80px; max-height: 50px;">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarPeserta">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-center" id="navbarPeserta">
            @auth
            <ul class="navbar-nav mx-4">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item mx-4">
                    <a class="nav-link {{ request()->routeIs('user.explore') ? 'active' : '' }}" href="{{ route('user.explore') }}">Explore Event</a>
                </li>
                <li class="nav-item mx-4">
                    <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ route('profile') }}">Profil</a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto position-absolute end-0 me-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile.password') }}">Ganti Password</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
            @endauth
        </div>
    </div>
</nav>

{{-- Konten halaman --}}
<main class="py-4">
    <div class="container">
        @yield('content')
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body></html>