<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('customer.profile.edit-profile');
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20|unique:users,phone_number,' . $user->id,
            'image' => 'nullable|image|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Handle foto
        if ($request->hasFile('image')) {
            if ($user->image && file_exists(public_path(parse_url($user->image, PHP_URL_PATH)))) {
                @unlink(public_path(parse_url($user->image, PHP_URL_PATH)));
            }

            $imagePath = $request->file('image')->store('users/images', 'public');
            $validated['image'] = asset('storage/' . $imagePath);
        }

        // Handle password
        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('customer.profile.index')->with('success', 'Profil berhasil diperbarui!');
    }

    public function deleteImage()
    {
        $user = Auth::user();

        if ($user->image && file_exists(public_path(parse_url($user->image, PHP_URL_PATH)))) {
            @unlink(public_path(parse_url($user->image, PHP_URL_PATH)));
        }

        $user->update(['image' => null]);

        return back()->with('success', 'Foto profil berhasil dihapus.');
    }
}
