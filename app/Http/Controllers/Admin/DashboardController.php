<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use App\Models\Store;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Show the admin dashboard.
     */
    public function index(Request $request)
    {
        // Get basic statistics
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total');

        // Get recent activities
        $recentUsers = User::latest()->limit(5)->get();
        $recentOrders = Order::with('user')->latest()->limit(5)->get();

        // Desktop view with full statistics
        $stats = [
            'total_users' => $totalUsers,
            'total_products' => $totalProducts,
            'total_orders' => $totalOrders,
            'total_categories' => Category::count(),
            'total_stores' => Store::count(),
            'total_revenue' => $totalRevenue,
            'total_wallet_balance' => Wallet::sum('balance'),
            'total_transactions' => WalletTransaction::count(),
        ];

        $recentProducts = Product::with('category', 'store')->latest()->limit(5)->get();

        // Get monthly revenue data for chart
        $monthlyRevenue = Order::selectRaw('MONTH(created_at) as month, SUM(total) as revenue')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Get top selling products
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        // Get wallet transaction summary
        $walletStats = [
            'total_credits' => WalletTransaction::where('type', 'credit')->sum('amount'),
            'total_debits' => WalletTransaction::where('type', 'debit')->sum('amount'),
            'total_transactions' => WalletTransaction::count(),
        ];

        return view('admin.dashboard.index', compact(
            'stats',
            'recentUsers',
            'recentOrders',
            'recentProducts',
            'monthlyRevenue',
            'topProducts',
            'walletStats'
        ));
    }
}
