<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('role', 'customer')
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->paginate(10);

        return view('admin.users.index', ['users' => $users, 'role' => 'customer']);
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:customer', // cuma boleh customer
            'phone_number' => 'nullable|string',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('users/images', 'public');
        }

        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);

        return redirect()->route('admin.customers.index')->with('success', 'Customer created!');
    }

    public function show(User $user)
    {
        if ($user->role !== 'customer') {
            abort(403);
        }

        $user->load([
            'addresses',
            'orders.items',
            'promoCodeUsages.promoCode'
        ]);

        $orderItems = $user->orders->flatMap->items;
        $topProducts = $orderItems
            ->groupBy('product_name')
            ->map(fn($items) => [
                'product_name' => $items->first()->product_name,
                'total_quantity' => $items->sum('quantity'),
            ])
            ->sortByDesc('total_quantity')
            ->take(5)
            ->values();

        return view('admin.users.show', compact('user', 'topProducts'));
    }

    public function edit(User $user)
    {
        if ($user->role !== 'customer') {
            abort(403);
        }

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->role !== 'customer') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'role' => 'required|in:customer', // tetep customer
            'phone_number' => 'nullable|string',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
            $validated['image'] = $request->file('image')->store('users/images', 'public');
        }

        if ($request->filled('password')) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.customers.index')->with('success', 'Customer updated!');
    }

    public function destroy(User $user)
    {
        if ($user->role !== 'customer') {
            abort(403);
        }

        if ($user->image && Storage::disk('public')->exists($user->image)) {
            Storage::disk('public')->delete($user->image);
        }

        $user->delete();

        return back()->with('success', 'Customer deleted!');
    }
}
