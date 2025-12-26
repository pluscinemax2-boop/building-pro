<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $file = $request->file('avatar');
        $path = $file->store('avatars', 'public');

        // Optionally delete old avatar if not default
        if ($user->avatar_url && !str_contains($user->avatar_url, 'lh3.googleusercontent.com')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $user->avatar_url));
        }

        $user->avatar_url = '/storage/' . $path;
        $user->save();

        return redirect()->back()->with('success', 'Profile image updated!');
    }
}
