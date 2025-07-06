<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        $slides = [
            [
                'id' => 1,
                'title' => 'Summer Sale Collections',
                'description' => 'Sale! Up to 50% off!',
                'img' => 'https://images.pexels.com/photos/1926769/pexels-photo-1926769.jpeg?auto=compress&cs=tinysrgb&w=800',
                'url' => '/',
                'bg' => 'bg-gradient-to-r from-yellow-50 to-pink-50',
            ],
            [
                'id' => 2,
                'title' => 'Winter Sale Collections',
                'description' => 'Sale! Up to 50% off!',
                'img' => 'https://images.pexels.com/photos/1021693/pexels-photo-1021693.jpeg?auto=compress&cs=tinysrgb&w=800',
                'url' => '/',
                'bg' => 'bg-gradient-to-r from-pink-50 to-blue-50',
            ],
            [
                'id' => 3,
                'title' => 'Spring Sale Collections',
                'description' => 'Sale! Up to 50% off!',
                'img' => 'https://images.pexels.com/photos/1183266/pexels-photo-1183266.jpeg?auto=compress&cs=tinysrgb&w=800',
                'url' => '/',
                'bg' => 'bg-gradient-to-r from-blue-50 to-yellow-50',
            ],
        ];

        return view('customer.index', compact('slides'));
    }

    public function cart()
    {
        return view('customer.orders.cart');
    }

    public function checkout()
    {
        return view('customer.orders.checkout');
    }

    public function profile()
    {
        $user = Auth::user();

        $addresses = \App\Models\Address::where('user_id', $user->id)->get();

        return view('customer.profile.index', compact('user', 'addresses'));
    }

    public function orders($slug)
    {
        return view('customer.profile.orders', ['slug' => $slug]);
    }
}
