<?php

namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class ParticipantController extends Controller
{
    public function store(Request $request)
    {
        // Debug to confirm event_id is present
        dd($request->all());

        $request->validate([
            'event_id' => 'required|exists:events,id',
        ]);

        $eventId = $request->input('event_id');
        $userId = auth()->user()->id; // fixed here

        $existing = Participant::where('user_id', $userId)
            ->where('event_id', $eventId)
            ->first();

        if ($existing) {
            return back()->with('error', 'Kamu sudah terdaftar di event ini.');
        }

        // Generate QR Code
        $qrData = route('scan.verify', [
            'user_id' => $userId,
            'event_id' => $eventId,
        ]);

        $qrCode = QrCode::create($qrData);
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        $filename = 'qr_' . uniqid() . '.png';
        $path = 'public/qrcodes/' . $filename;

        Storage::put($path, $result->getString());

        Log::info('QR code generated and saved: ' . $filename);

        // Save participant
        Participant::create([
            'user_id' => $userId,
            'event_id' => $eventId,
            'status_kehadiran' => 'belum',
            'qr_code_path' => 'storage/qrcodes/' . $filename,
        ]);

        return back()->with('success', 'Pendaftaran berhasil dan QR code dibuat.');
    }
}
