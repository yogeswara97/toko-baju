<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Payment;
use App\Models\PromoCode;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';

        $userCount = User::count();
        $adminCount = User::where('role', 'admin')->count();
        $activeUserCount = User::where('is_active', true)->count();

        $productCount = Product::count();
        $lowStockCount = Product::where('qty', '<', 10)->count(); // stok rendah

        $orderCount = Order::count();
        $orderStats = Order::selectRaw("status, COUNT(*) as count")
            ->groupBy('status')
            ->pluck('count', 'status');

        $revenue = Payment::where('transaction_status', 'settlement')
            ->sum('gross_amount');

        $promoCount = PromoCode::count();

        $monthlyRevenue = [];
        $months = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i)->format('Y-m');
            $months[] = Carbon::now()->subMonths($i)->format('M Y');

            $monthlyRevenue[] = Payment::where('transaction_status', 'settlement')
                ->whereYear('created_at', substr($month, 0, 4))
                ->whereMonth('created_at', substr($month, 5, 2))
                ->sum('gross_amount');
        }

        // New creative card data
        $avgRevenue = $revenue > 0 && $orderCount > 0 ? $revenue / $orderCount : 0;
        $recentUsers = User::latest()->take(5)->get(['name', 'email', 'created_at']);

        return view('admin.index', compact(
            'title', 'userCount', 'adminCount', 'activeUserCount',
            'productCount', 'lowStockCount', 'orderCount',
            'orderStats', 'revenue', 'promoCount',
            'monthlyRevenue', 'months', 'avgRevenue', 'recentUsers'
        ));
    }
}
