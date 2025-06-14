<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Participant;


class ParticipantDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $joinedEvents = $user->participants()->with('event', 'certificate')->get();
        $joinedEventIds = $joinedEvents->pluck('event_id');
        $availableEvents = Event::whereNotIn('id', $joinedEventIds)->get();

        return view('user.dashboard', compact('user', 'joinedEvents', 'availableEvents'));
    }

    public function uploadBukti(Request $request, Participant $participant)
    {
        if ($request->hasFile('bukti_pembayaran')) {
            $path = $request->file('bukti_pembayaran')->store('public/bukti');
            $participant->bukti_pembayaran = str_replace('public/', 'storage/', $path);
            $participant->status_pembayaran = 'tertunda';
            $participant->save();
        }

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diunggah.');
    }
}
