<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParticipantAdminController extends Controller
{
    // Menampilkan daftar peserta event
    public function index(Request $request)
    {
        $query = \App\Models\Participant::with('event', 'user');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        if ($request->filled('event_id')) {
            $query->where('event_id', $request->input('event_id'));
        }

        $participants = $query->paginate(10);
        $events = \App\Models\Event::all();

        return view('admin.participants.index', compact('participants', 'events'));
    }

    // Fungsi scan QR manual via input
    public function scanQr(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'participant_id' => 'required|exists:participants,id',
        ]);

        $participant = Participant::findOrFail($request->participant_id);
        $participant->status_kehadiran = 'hadir';
        $participant->save();

        return back()->with('success', 'Kehadiran peserta berhasil ditandai.');
    }

    public function edit($id)
    {
        $participant = \App\Models\Participant::with('event', 'user')->findOrFail($id);
        return view('admin.participants.edit', compact('participant'));
    }

    public function update(Request $request, $id)
    {
        $participant = \App\Models\Participant::findOrFail($id);
        $participant->status_kehadiran = $request->status_kehadiran;
        $participant->save();

        return redirect()->route('admin.participants.index')->with('success', 'Status kehadiran diperbarui.');
    }


    public function destroy($participantId)
    {
        $participant = Participant::findOrFail($participantId);
        $eventId = $participant->event_id;
        $participant->delete();

        return redirect()->route('admin.participants.index', ['event' => $eventId])
            ->with('success', 'Peserta berhasil dihapus.');
    }

    public function scanFromQr(Request $request)
    {
        $userId = $request->input('user_id');
        $eventId = $request->input('event_id');

        $participant = Participant::where('user_id', $userId)
            ->where('event_id', $eventId)
            ->first();

        if (!$participant) {
            return back()->with('error', 'Peserta tidak ditemukan.');
        }

        if ($participant->status_kehadiran === 'hadir') {
            return back()->with('info', 'Peserta sudah absen sebelumnya.');
        }

        $participant->update(['status_kehadiran' => 'hadir']);

        return back()->with('success', 'Kehadiran peserta berhasil dicatat.');
    }
    public function scanPage()
    {
        return view('admin.scan'); // File ini harus ada di: resources/views/admin/scan.blade.php
    }

    public function verifyPayment(Request $request, $id)
    {
        $participant = Participant::findOrFail($id);
        $participant->status_pembayaran = $request->status_pembayaran;
        $participant->save();

        return back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }
}
