<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function index()
    {
        return view('admin.scan');
    }

    public function submit(Request $request)
    {
        $participant = Participant::where('user_id', $request->user_id)
            ->where('event_id', $request->event_id)
            ->first();

        if ($participant) {
            $participant->status_kehadiran = 'hadir';
            $participant->save();

            return redirect()->route('admin.scan.page')->with('success', 'Kehadiran peserta telah dicatat.');

        }

        return redirect()->route('admin.scan')->with('error', 'Data peserta tidak ditemukan.');
    }

    public function scanFromQR(Request $request)
    {
        $participant = Participant::where('user_id', $request->user_id)
            ->where('event_id', $request->event_id)
            ->first();
    
        if ($participant) {
            $participant->status_kehadiran = 'hadir';
            $participant->save();
    
            return redirect()->route('admin.scan.page')->with('success', '✅ Kehadiran peserta dicatat: ' . $participant->user_id);
        }
    
        return redirect()->route('admin.scan.page')->with('error', '❌ Data peserta tidak ditemukan.');
    }
}
