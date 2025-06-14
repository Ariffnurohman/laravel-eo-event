<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Event Organizer</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800 font-sans">

    <!-- Navbar -->
    <nav class="flex justify-between items-center p-6 bg-white shadow">
        <h1 class="text-2xl font-bold text-blue-600">🎉 Event Organizer</h1>
        <div>
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline mr-4">Login</a>
            <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Register</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="flex flex-col-reverse md:flex-row items-center px-10 py-20 bg-gradient-to-r from-blue-500 to-indigo-600 text-white">
        <div class="md:w-1/2 text-center md:text-left">
            <h2 class="text-4xl font-bold mb-4">Kelola & Ikuti Event dari Genggamanmu</h2>
            <p class="text-lg mb-6">Aplikasi terbaik untuk pendaftaran event, presensi digital, dan sertifikat otomatis.</p>
            <a href="{{ route('login') }}" class="bg-white text-blue-600 px-6 py-3 rounded font-semibold hover:bg-gray-100">Mulai Sekarang</a>
        </div>
        <div class="md:w-1/2 mb-10 md:mb-0">
            <img src="{{ asset('images/team.svg') }}" alt="Ilustrasi Event" class="w-full max-w-md mx-auto">
        </div>
    </section>

    <!-- Download App Section -->
    <section class="py-16 text-center bg-white">
        <h3 class="text-2xl font-bold mb-4">📱 Unduh Aplikasi Mobile Kami</h3>
        <p class="text-gray-600 mb-6">Tersedia di platform Android dan iOS</p>
        <div class="flex justify-center gap-4">
            <a href="https://play.google.com/store/apps/details?id=com.nama.aplikasi" target="_blank">
                <img src="{{ asset('images/googleplay.png') }}" alt="Download di Google Play" class="h-14">
            </a>
        </div>
    </section>

    <!-- Event Terbaru -->
    @if(isset($events))
    <section class="p-10 bg-gray-100">
        <h3 class="text-2xl font-semibold mb-6 text-center">📅 Event Terbaru</h3>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($events as $event)
            <div class="bg-white shadow rounded-lg p-4">
                <h4 class="font-bold text-lg">{{ $event->name }}</h4>
                <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($event->date)->translatedFormat('d F Y') }}</p>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Newsletter Section -->
    <section class="py-16 bg-white text-center">
        <h3 class="text-2xl font-bold mb-4">📩 Dapatkan info event terbaru</h3>
        <p class="text-gray-600 mb-6">Masukkan email Anda untuk berlangganan newsletter kami</p>
        <form action="#" method="POST" class="flex justify-center gap-4 max-w-xl mx-auto">
            <input type="email" placeholder="Masukkan email Anda" class="w-full px-4 py-3 rounded border border-gray-300 focus:outline-blue-500">
            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700">Langganan</button>
        </form>
    </section>

    <!-- Footer -->
    <footer class="text-center p-6 bg-gray-100 mt-10 text-gray-600 text-sm">
        &copy; {{ date('Y') }} Event Organizer. All rights reserved.
    </footer>

</body>

</html>