<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return Inertia::render('Profile/Index', [
            'user' => $user
        ]);
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'address' => 'required',
            'phone_number' => 'required'
        ]);

        $request->user()->update($validated);

        return back()->with('message', 'profil berhasil diperbarui.');
    }
}
