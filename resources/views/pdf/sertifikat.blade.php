<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; text-align: center; }
        h1 { margin-top: 80px; font-size: 32px; }
        p { font-size: 18px; }
        .nama { font-size: 26px; font-weight: bold; margin: 20px 0; }
    </style>
</head>
<body>
    <h1>Sertifikat Kehadiran</h1>
    <p>Diberikan kepada</p>
    <div class="nama">{{ $participant->user->name }}</div>
    <p>Atas partisipasinya dalam acara</p>
    <div class="nama">{{ $participant->event->nama }}</div>
    <p>Pada tanggal {{ \Carbon\Carbon::parse($participant->event->waktu_mulai)->translatedFormat('d F Y') }}</p>
</body>
</html>