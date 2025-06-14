<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sertifikat Penghargaan</title>
    <style>
        body {
            font-family: 'Georgia', serif;
            background: white;
            margin: 0;
            padding: 0;
        }

        .certificate {
            width: 1120px;
            height: 793px;
            padding: 60px;
            border: 10px solid #155e63;
            background: url("{{ asset('storage/bg-certificate.png') }}") no-repeat center;
            background-size: cover;
            position: relative;
            box-sizing: border-box;
        }

        .certificate h1 {
            font-size: 48px;
            color: #0a2239;
            letter-spacing: 3px;
            margin-bottom: 10px;
        }

        .certificate h2 {
            font-size: 28px;
            margin: 10px 0;
            color: #0a2239;
        }

        .certificate .name {
            font-size: 42px;
            font-weight: bold;
            margin: 20px 0;
            color: #0a2239;
        }

        .certificate .role {
            font-weight: bold;
            font-size: 24px;
            color: #0a2239;
            margin-top: 20px;
        }

        .certificate .desc {
            font-size: 18px;
            margin: 20px auto;
            max-width: 80%;
            color: #555;
        }

        .signature {
            margin-top: 60px;
            font-family: 'Cursive', sans-serif;
            font-size: 24px;
        }

        .signature-block {
            text-align: center;
            margin-top: 40px;
        }

        .sign-title {
            font-family: Arial, sans-serif;
            font-weight: bold;
            font-size: 14px;
            text-transform: uppercase;
            margin-top: 4px;
            color: #0a2239;
        }

        .qr-code {
            position: absolute;
            bottom: 40px;
            right: 40px;
            width: 100px;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <h1>SERTIFIKAT</h1>
        <h2>PENGHARGAAN</h2>
        <p>Diberikan Kepada:</p>
        <div class="name">{{ $participant->user->name }}</div>
        <div class="role">SEBAGAI : PESERTA</div>
        <div class="desc">
            Terima kasih karena telah berpartisipasi dalam acara seminar <br>
            “{{ $participant->event->nama }}” pada tanggal
            {{ \Carbon\Carbon::parse($participant->event->waktu_mulai)->translatedFormat('d F Y') }}
        </div>

        <div class="signature-block">
            <div class="signature">Brigitte Schwartz</div>
            <div class="sign-title">Ketua Penyelenggara Acara</div>
        </div>
    </div>
</body>
</html>
