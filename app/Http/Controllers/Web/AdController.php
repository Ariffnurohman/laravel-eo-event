<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ad;
use App\Models\Event;


class AdController extends Controller
{
    public function index()
    {
        $ads = Ad::latest()->take(6)->get();
        $popularEvents = Event::orderBy('kuota', 'desc')->take(6)->get();

        return view('user.explore', compact('ads', 'popularEvents'));
    }

    public function create()
    {

        return view('admin.ads.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = $request->file('image')->store('ads', 'public');

        Ad::create([
            'title' => $request->title,
            'message' => $request->message,
            'image_path' => $imagePath, // jika ada upload file
        ]);

        return redirect()->route('admin.ads.index')->with('success', 'Iklan berhasil ditambahkan.');
    }
}
