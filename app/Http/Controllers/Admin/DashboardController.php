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
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';

        // STATS
        $revenue = Payment::where('transaction_status', 'settlement')->sum('gross_amount');
        $newUsers = User::whereDate('created_at', '>=', now()->subDays(7))->count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $abandonedCarts = Order::where('status', 'cart')->count(); // asumsi 'cart' status
        $repeatCustomers = $this->calculateRepeatCustomerPercentage();
        $avgOrderValue = Order::count() > 0 ? round($revenue / Order::count(), 2) : 0;

        // REVENUE GROWTH - weekly (7 hari terakhir)
        $weeklyRevenue = Payment::where('transaction_status', 'settlement')
            ->whereDate('created_at', '>=', now()->subDays(6))
            ->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->created_at)->format('D');
            })->map(function ($group) {
                return $group->sum('gross_amount');
            });


        // TOP TRANSACTIONS (mock)
        $topTransactions = Order::with('user')->latest()->take(5)->get();

        // TOP PRODUCTS
        $topProducts = Product::withCount('items')
            ->orderBy('order_items_count', 'desc')
            ->take(2)
            ->get();

        return view('admin.index', compact(
            'title',
            'revenue',
            'newUsers',
            'pendingOrders',
            'abandonedCarts',
            'repeatCustomers',
            'avgOrderValue',
            'weeklyRevenue',
            'topTransactions',
            'topProducts'
        ));
    }

    private function calculateRepeatCustomerPercentage()
    {
        $totalCustomers = User::where('role', 'customer')->count();
        if ($totalCustomers === 0) return 0;

        $repeatCustomers = Order::select('user_id')
            ->groupBy('user_id')
            ->havingRaw('count(*) > 1')
            ->pluck('user_id')
            ->count();

        return round(($repeatCustomers / $totalCustomers) * 100);
    }
}
