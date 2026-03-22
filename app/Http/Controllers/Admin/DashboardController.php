<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total');
        $totalUsers = User::where('role', 'user')->count();
        $totalProductsSold = OrderItem::sum('quantity');

        $recentOrders = Order::with('user')->latest()->limit(5)->get();

        // Chart data: Sales by day for last 7 days
        $salesData = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as total')
            )
            ->where('payment_status', 'paid')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders', 'totalRevenue', 'totalUsers', 'totalProductsSold', 
            'recentOrders', 'salesData'
        ));
    }
}
