<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('user.profile-edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = 'profile_' . $user->id . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/profiles', $filename);
            $user->profile_photo = 'profiles/' . $filename;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }


    public function editPassword()
    {
        return view('user.profile-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('profile')->with('success', 'Password berhasil diperbarui.');
    }
}
