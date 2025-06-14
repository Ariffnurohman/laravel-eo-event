<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role !== 'admin') {
            abort(403, 'Hanya admin yang dapat mengakses dashboard ini.');
        }

        return view('admin.dashboard', compact('user'));
    }
}
