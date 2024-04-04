<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show($userId)
    {
        $user = User::with('profile')->find($userId);

        // Handle the case where the user doesn't exist
        if (!$user) {
            abort(404);
        }

        return view('admin.profile.show', compact('user'));
    }

    public function updatePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|max:4096', // 4MB Max
        ]);

        $user = Auth::user();
        $path = $request->file('profile_picture')->store('profile_pictures', 'public');

        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        $user->profile_picture = $path;
        $user->save();

        return back()->with('success', 'Profile picture updated successfully.');
    }

    public function deletePicture()
    {
        $user = Auth::user();

        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture); // Delete the file from storage
            $user->profile_picture = null; // Remove the filename from the user's record
            $user->save(); // Save the user
        }

        return back()->with('success', 'Profile picture deleted successfully.');
    }

    public function updateDetails(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
        ]);
    
        $user = auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
    
        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
