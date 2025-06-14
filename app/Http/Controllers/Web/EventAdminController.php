<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventAdminController extends Controller
{
    public function index()
    {
        $this->authorizeAdmin();
        $events = Event::latest()->get();
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'lokasi' => 'required|string',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date',
            'jenis' => 'required|string',
            'kuota' => 'required|integer',
            'foto' => 'nullable|image|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('public/events');
            $fotoPath = str_replace('public/', 'storage/', $fotoPath);
        }

        Event::create([
            'nama' => $request->nama,
            'lokasi' => $request->lokasi,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'jenis' => $request->jenis,
            'kuota' => $request->kuota,
            'foto' => $fotoPath,

        ]);

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil ditambahkan.');
    }

    public function destroy(Event $event)
    {
        // Hapus foto jika ada
        if ($event->foto) {
            $path = str_replace('storage/', 'public/', $event->foto);
            \Storage::delete($path);
        }

        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dihapus.');
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'nama' => 'required|string',
            'lokasi' => 'required|string',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date',
            'jenis' => 'required|string',
            'kuota' => 'required|integer',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['nama', 'lokasi', 'waktu_mulai', 'waktu_selesai', 'jenis', 'kuota']);

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('public/events');
            $data['foto'] = str_replace('public/', 'storage/', $fotoPath);
        }

        $event->update($data);

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil diperbarui.');
    }

    public function stats(Event $event)
    {
        $events = Event::withCount([
            'peserta as total_peserta',
            'peserta as hadir' => fn($q) => $q->where('status_kehadiran', 'hadir'),
            'peserta as tidak_hadir' => fn($q) => $q->where('status_kehadiran', 'tidak'),
        ])->get();

        return view('admin.stats', compact('events'));
    }

    private function authorizeAdmin()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
    }
}
