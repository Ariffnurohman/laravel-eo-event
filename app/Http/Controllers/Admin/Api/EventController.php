<?php
namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    // List semua event (untuk peserta dan admin)
    public function index()
    {
        $events = Event::where('is_active', true)->get();
        return response()->json($events);
    }

    // Detail event
    public function show($id)
    {
        $event = Event::findOrFail($id);
        return response()->json($event);
    }

    // Admin: buat event baru
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'nullable|string',
            'lokasi' => 'required|string',
            'jenis' => 'required|in:gratis,berbayar',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
            'kuota' => 'required|integer',
            'mengeluarkan_sertifikat' => 'required|boolean',
            'form_pendaftaran' => 'nullable|array',
        ]);

        $event = Event::create([
            ...$validated,
            'form_pendaftaran' => json_encode($validated['form_pendaftaran'] ?? []),
        ]);

        return response()->json($event, 201);
    }

    // Admin: update event
    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();

        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'string',
            'deskripsi' => 'nullable|string',
            'lokasi' => 'string',
            'jenis' => 'in:gratis,berbayar',
            'waktu_mulai' => 'date',
            'waktu_selesai' => 'date|after:waktu_mulai',
            'kuota' => 'integer',
            'mengeluarkan_sertifikat' => 'boolean',
            'form_pendaftaran' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        $event->update([
            ...$validated,
            'form_pendaftaran' => isset($validated['form_pendaftaran'])
                ? json_encode($validated['form_pendaftaran'])
                : $event->form_pendaftaran,
        ]);

        return response()->json($event);
    }

    // Admin: hapus atau nonaktifkan event
    public function destroy($id)
    {
        $this->authorizeAdmin();

        $event = Event::findOrFail($id);
        $event->update(['is_active' => false]);

        return response()->json(['message' => 'Event dinonaktifkan.']);
    }

    // Admin-only auth helper
    private function authorizeAdmin()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Hanya admin yang diizinkan.');
        }
    }
}