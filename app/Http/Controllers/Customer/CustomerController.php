<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_display', true)->get();

        return view('customer.index', compact('categories'));
    }

    public function profile()
    {
        $user = Auth::user();

        $addresses = Address::where('user_id', $user->id)->get();

        // Ambil order terbaru dari user
        $orders = $user->orders()
            ->latest()
            ->take(5) // ambil 5 terakhir, bisa disesuaikan
            ->get();

        return view('customer.profile.index', compact('user', 'addresses', 'orders'));
    }
}
