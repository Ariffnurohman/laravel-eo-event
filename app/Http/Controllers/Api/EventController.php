<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        // Ambil semua event aktif dan urutkan berdasarkan tanggal event terdekat
        $events = Event::where('is_active', true)
                    ->orderBy('event_date', 'asc')
                    ->get(['id', 'name', 'description', 'event_date', 'location', 'poster']);

        // Format response agar lebih rapi
        $formatted = $events->map(function ($event) {
            return [
                'id' => $event->id,
                'name' => $event->name,
                'description' => $event->description,
                'event_date' => $event->event_date,
                'location' => $event->location,
                'poster_url' => $event->poster ? url('storage/' . $event->poster) : null,
            ];
        });

        return response()->json($formatted);
    }
}
