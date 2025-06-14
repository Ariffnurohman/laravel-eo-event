<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Label\Font\NotoSans;
use Illuminate\Support\Str;

use Endroid\QrCode\QrCode;



class EventUserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $joinedEvents = $user->participants()->with('event', 'certificate')->get();
        $joinedEventIds = $joinedEvents->pluck('event_id');
        $availableEvents = Event::whereNotIn('id', $joinedEventIds)->get();

        return view('user.dashboard', compact('user', 'joinedEvents', 'availableEvents'));
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        $user = Auth::user();

        $alreadyRegistered = $user->participants()->where('event_id', $event->id)->exists();

        return view('user.events.show', compact('event', 'alreadyRegistered'));
    }

    public function register(Request $request, Event $event)
    {
        $user = Auth::user();

        $exists = Participant::where('user_id', $user->id)
            ->where('event_id', $event->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Kamu sudah terdaftar di event ini.');
        }

        // QR Code URL
        $url = route('scan.verify', [
            'user_id' => $user->id,
            'event_id' => $event->id,
        ]);

        $qrCode = new QrCode($url);
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        $filename = 'qr_' . uniqid() . '.png';
        $storagePath = "qrcodes/{$filename}";

        // Simpan QR ke storage/app/public/qrcodes
        Storage::disk('public')->put($storagePath, $result->getString());

        Participant::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'status_kehadiran' => 'belum',
            'qr_code_path' => "storage/qrcodes/{$filename}",
        ]);

        return back()->with('success', 'Berhasil mendaftar dan QR Code dibuat.');
    }

    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $user = auth()->user();

        $participant = Participant::where('user_id', $user->id)->where('event_id', $id)->first();

        if (!$participant) {
            return back()->with('error', 'Data peserta tidak ditemukan.');
        }

        $file = $request->file('bukti_pembayaran');
        $path = $file->store('bukti_pembayaran', 'public');

        $participant->bukti_pembayaran = $path;
        $participant->save();

        return back()->with('success', 'Bukti pembayaran berhasil diunggah.');
    }
}
