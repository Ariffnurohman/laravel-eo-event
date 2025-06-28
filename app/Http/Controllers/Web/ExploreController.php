<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\Ad;



class ExploreController extends Controller
{
    public function index(Request $request)
    {
        $popularEvents = Event::where('is_active', true)
            ->orderBy('kuota', 'desc')
            ->take(5)
            ->get();

        $query = Event::query();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $events = $query->latest()->paginate(6);

        $ads = Ad::where('is_active', true)->latest()->get();

        return view('user.explore', compact('events', 'ads', 'popularEvents'));
    }
}
