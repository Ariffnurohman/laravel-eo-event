<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdController extends Controller
{
    public function index()
    {
        $ads = Ad::where('is_active', true)->get();
        return view('user.explore', compact('ads'));
}


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'message' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('ads', 'public');
        }

        Ad::create([
            'title' => $validated['title'],
            'message' => $validated['message'],
            'image_path' => $imagePath,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.ads.create')->with('success', 'Iklan berhasil ditambahkan.');
    }



}