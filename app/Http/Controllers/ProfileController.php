<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // Show the edit profile form
    public function edit()
    {
        return view('profile.edit');
    }

    // Update only name and email
    public function update(Request $request)
    {
        $user = auth()->user();

        // Validate only name and email
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        // Update only name and email
        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        // Redirect back to products with success message
        return redirect()->route('products.index')
                         ->with('success', 'Profile updated successfully!');
    }
}