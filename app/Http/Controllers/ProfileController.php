<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // This shows the profile edit page
    public function edit()
    {
        return view('profile.edit');
    }

    // THIS IS WHERE YOUR CODE GOES → THE UPDATE FUNCTION
    public function update(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'password' => 'nullable|confirmed|min:8',
        ]);

        $data = $request->only('name', 'email');

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if (auth()->user()->profile_photo) {
                Storage::disk('public')->delete(auth()->user()->profile_photo);
            }
            $data['profile_photo'] = $request->file('photo')->store('profiles', 'public');
        }

        // Handle password
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        auth()->user()->update($data);

        return back()->with('success', 'Profile updated successfully!');
    }
}