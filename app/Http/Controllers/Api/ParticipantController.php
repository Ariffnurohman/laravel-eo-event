<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class ParticipantController extends Controller
{
    // Peserta daftar ke event
    public function registerToEvent(Request $request, $eventId)
    {
        $user = Auth::user();

        $event = Event::findOrFail($eventId);
        if (!$event->is_active) {
            return response()->json(['message' => 'Event tidak aktif.'], 400);
        }

        $exists = Participant::where('user_id', $user->id)->where('event_id', $event->id)->exists();
        if ($exists) {
            return response()->json(['message' => 'Sudah terdaftar di event ini.'], 409);
        }

        $formData = $request->validate([
            'form_data' => 'nullable|array',
        ])['form_data'] ?? [];

        $participant = Participant::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'form_data' => $formData,
        ]);

        $this->generateQrCode($participant);

        return response()->json(['message' => 'Pendaftaran berhasil.']);
    }

    // Riwayat event yang diikuti user
    public function myEvents()
    {
        $user = Auth::user();

        $data = Participant::with('event')
            ->where('user_id', $user->id)
            ->get();

        return response()->json($data);
    }

    // Ambil QR Code tiket
    public function myQrCode($eventId)
    {
        $user = Auth::user();

        $participant = Participant::where('user_id', $user->id)
            ->where('event_id', $eventId)
            ->firstOrFail();

        return response()->json([
            'qr_code_url' => $participant->qr_code_path ? Storage::url($participant->qr_code_path) : null,
        ]);
    }

    // Admin tandai kehadiran (manual override)
    public function updateKehadiran(Request $request, $participantId)
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'status_kehadiran' => 'required|in:hadir,tidak',
        ]);

        $participant = Participant::findOrFail($participantId);
        $participant->status_kehadiran = $validated['status_kehadiran'];
        $participant->save();

        return response()->json(['message' => 'Status kehadiran diperbarui.']);
    }

    // Private: generate QR code saat daftar
    private function generateQrCode(Participant $participant)
    {
        $data = route('qr.verify', ['id' => $participant->id]); // implementasi verifikasi nanti
        $qr = QrCode::create($data);
        $writer = new PngWriter();
        $result = $writer->write($qr);

        $fileName = 'qrcodes/participant_' . $participant->id . '.png';
        Storage::disk('public')->put($fileName, $result->getString());

        $participant->qr_code_path = $fileName;
        $participant->save();
    }
}