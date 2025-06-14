<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Participant;

class PaymentController extends Controller
{
    public function upload(Request $request, $eventId)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $participant = Participant::where('user_id', auth()->id())
            ->where('event_id', $eventId)
            ->firstOrFail();

        $path = $request->file('bukti_pembayaran')->store('public/bukti_pembayaran');
        $participant->bukti_pembayaran = str_replace('public/', 'storage/', $path);
        $participant->save();

        return redirect()->back()->with('success', '✅ Bukti pembayaran berhasil diunggah. Silakan tunggu verifikasi admin.');
    }
}