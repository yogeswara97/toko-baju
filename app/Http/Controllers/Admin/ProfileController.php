<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $admin = Auth::user()->load(['orders', 'addresses']);

        return view('admin.profile.index', compact('admin'))->with('title', 'Profil Admin');
    }

    public function edit()
    {
        return view('admin.profile.edit', [
            'title' => 'Edit Profil Admin',
            'admin' => Auth::user(),
        ]);
    }

    public function update(Request $request)
    {
        $admin = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$admin->id}",
            'phone_number' => 'nullable|string|max:20',
            'password' => 'nullable|confirmed|min:6',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($admin->image && Storage::exists($admin->image)) {
                Storage::delete($admin->image);
            }

            $validated['image'] = $request->file('image')->store('uploads/profile');
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $admin->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function deleteImage()
    {
        $admin = Auth::user();

        if ($admin->image && Storage::exists($admin->image)) {
            Storage::delete($admin->image);
        }

        $admin->update(['image' => null]);

        return back()->with('success', 'Foto profil berhasil dihapus.');
    }
}
