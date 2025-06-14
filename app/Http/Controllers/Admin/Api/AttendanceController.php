<?php
namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    // Admin memindai QR dan mencatat kehadiran
    public function scanQrCode(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Hanya admin yang dapat mencatat kehadiran.');
        }

        $validated = $request->validate([
            'participant_id' => 'required|exists:participants,id',
        ]);

        $participant = Participant::findOrFail($validated['participant_id']);

        if ($participant->status_kehadiran === 'hadir') {
            return response()->json(['message' => 'Peserta sudah tercatat hadir.'], 409);
        }

        $participant->status_kehadiran = 'hadir';
        $participant->save();

        return response()->json([
            'message' => 'Kehadiran peserta berhasil dicatat.',
            'participant' => $participant,
        ]);
    }
}