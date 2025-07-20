<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\TelegramNotification;

class ShippingController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display shipping dashboard.
     */
    public function index()
    {
        $stats = [
            'pending_shipping' => Order::where('order_status', 'processing')->count(),
            'shipped_today' => Order::where('order_status', 'shipped')
                ->whereDate('updated_at', today())
                ->count(),
            'delivered_today' => Order::where('order_status', 'delivered')
                ->whereDate('delivered_at', today())
                ->count(),
            'total_shipping_cost' => Order::where('order_status', 'shipped')
                ->sum('shipping'),
        ];

        $pendingOrders = Order::with(['user', 'items.product'])
            ->where('order_status', 'processing')
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        $recentShipments = Order::with(['user', 'items.product'])
            ->where('order_status', 'shipped')
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.shipping.index', compact('stats', 'pendingOrders', 'recentShipments'));
    }

    /**
     * Show orders ready for shipping.
     */
    public function pending()
    {
        $orders = Order::with(['user', 'items.product', 'address'])
            ->where('order_status', 'processing')
            ->orderBy('created_at', 'asc')
            ->paginate(20);

        return view('admin.shipping.pending', compact('orders'));
    }

    /**
     * Show shipped orders.
     */
    public function shipped()
    {
        $orders = Order::with(['user', 'items.product'])
            ->where('order_status', 'shipped')
            ->orderBy('updated_at', 'desc')
            ->paginate(20);

        return view('admin.shipping.shipped', compact('orders'));
    }

    /**
     * Show delivered orders.
     */
    public function delivered()
    {
        $orders = Order::with(['user', 'items.product'])
            ->where('order_status', 'delivered')
            ->orderBy('delivered_at', 'desc')
            ->paginate(20);

        return view('admin.shipping.delivered', compact('orders'));
    }

    /**
     * Mark order as shipped.
     */
    public function markShipped(Request $request, Order $order)
    {
        $request->validate([
            'tracking_number' => 'required|string|max:255',
            'carrier' => 'required|string|max:100',
            'tracking_url' => 'nullable|url',
            'shipping_notes' => 'nullable|string',
        ]);

        $oldStatus = $order->order_status;
        
        $order->update([
            'order_status' => 'shipped',
            'tracking_number' => $request->tracking_number,
            'carrier' => $request->carrier,
            'tracking_url' => $request->tracking_url,
            'shipping_notes' => $request->shipping_notes ? 
                $order->shipping_notes . "\n" . $request->shipping_notes : 
                $order->shipping_notes,
        ]);

        // Send Telegram notification
        $this->sendShippingNotification($order, 'shipped');

        return back()->with('success', 'Order marked as shipped successfully!');
    }

    /**
     * Mark order as delivered.
     */
    public function markDelivered(Order $order)
    {
        $oldStatus = $order->order_status;
        
        $order->update([
            'order_status' => 'delivered',
            'delivered_at' => now(),
        ]);

        // Send Telegram notification
        $this->sendShippingNotification($order, 'delivered');

        return back()->with('success', 'Order marked as delivered successfully!');
    }

    /**
     * Bulk update shipping status.
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:orders,id',
            'action' => 'required|in:mark_shipped,mark_delivered',
            'tracking_number' => 'required_if:action,mark_shipped|string|max:255',
            'carrier' => 'required_if:action,mark_shipped|string|max:100',
        ]);

        $orders = Order::whereIn('id', $request->order_ids)->get();
        $updatedCount = 0;

        foreach ($orders as $order) {
            if ($request->action === 'mark_shipped' && $order->order_status === 'processing') {
                $order->update([
                    'order_status' => 'shipped',
                    'tracking_number' => $request->tracking_number,
                    'carrier' => $request->carrier,
                ]);
                $this->sendShippingNotification($order, 'shipped');
                $updatedCount++;
            } elseif ($request->action === 'mark_delivered' && $order->order_status === 'shipped') {
                $order->update([
                    'order_status' => 'delivered',
                    'delivered_at' => now(),
                ]);
                $this->sendShippingNotification($order, 'delivered');
                $updatedCount++;
            }
        }

        return back()->with('success', "Successfully updated {$updatedCount} orders!");
    }

    /**
     * Shipping analytics.
     */
    public function analytics()
    {
        // Monthly shipping statistics
        $monthlyStats = Order::selectRaw('
            MONTH(created_at) as month,
            YEAR(created_at) as year,
            COUNT(*) as total_orders,
            SUM(CASE WHEN order_status = "shipped" THEN 1 ELSE 0 END) as shipped_orders,
            SUM(CASE WHEN order_status = "delivered" THEN 1 ELSE 0 END) as delivered_orders,
            SUM(shipping) as total_shipping_cost
        ')
        ->whereYear('created_at', date('Y'))
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get();

        // Top shipping carriers
        $carriers = Order::selectRaw('carrier, COUNT(*) as count')
            ->whereNotNull('carrier')
            ->groupBy('carrier')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();

        // Average delivery time
        $avgDeliveryTime = Order::whereNotNull('delivered_at')
            ->selectRaw('AVG(DATEDIFF(delivered_at, created_at)) as avg_days')
            ->first();

        return view('admin.shipping.analytics', compact('monthlyStats', 'carriers', 'avgDeliveryTime'));
    }

    /**
     * Send shipping notification to Telegram.
     */
    protected function sendShippingNotification($order, $status)
    {
        $statusEmojis = [
            'shipped' => '📦',
            'delivered' => '✅'
        ];

        $emoji = $statusEmojis[$status] ?? '📋';

        $message = "{$emoji} <b>ORDER {$status->upper()}</b>\n\n";
        $message .= "📋 <b>Order Details:</b>\n";
        $message .= "• Order #: <code>{$order->order_number}</code>\n";
        $message .= "• Customer: {$order->user->name}\n";
        $message .= "• Total: ₦" . number_format($order->total, 2) . "\n";
        
        if ($status === 'shipped' && $order->tracking_number) {
            $message .= "• Tracking: {$order->tracking_number}\n";
            $message .= "• Carrier: {$order->carrier}\n";
        }
        
        $message .= "\n⏰ <b>Updated:</b> " . now()->format('M j, Y g:i A') . "\n";
        $message .= "\n🔗 <b>Admin Link:</b> " . route('admin.orders.show', $order->id);

        $notification = new TelegramNotification($message, null, true);
        $notification->toTelegram(null);
    }
} 