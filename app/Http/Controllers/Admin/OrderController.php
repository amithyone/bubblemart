<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\OrderStatusUpdatedNotification;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items.product', 'items.customization', 'items.variationOptions', 'address']);

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('order_status', $request->status);
        }

        // Filter by payment status
        if ($request->has('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by date range
        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by user
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);
        $users = User::all();

        return view('admin.orders.index', compact('orders', 'users'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load([
            'user', 
            'items.product.store', 
            'items.customization', 
            'items.variationOptions',
            'address'
        ]);
        
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified order.
     */
    public function edit(Order $order)
    {
        $order->load(['user', 'items.product', 'items.customization', 'items.variationOptions', 'address']);
        
        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update the specified order.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'tracking_number' => 'nullable|string|max:255',
            'delivery_note' => 'nullable|string',
        ]);

        $order->update($request->only([
            'order_status', 'tracking_number', 'delivery_note'
        ]));

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Order updated successfully!');
    }

    /**
     * Update order status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'notes' => 'nullable|string',
        ]);

        $oldStatus = $order->order_status;
        $order->update([
            'order_status' => $request->status,
            'shipping_notes' => $request->notes ? $order->shipping_notes . "\n" . $request->notes : $order->shipping_notes
        ]);

        // Send status update notification
        try {
            $order->user->notify(new OrderStatusUpdatedNotification($order, $oldStatus, $request->status));
            
            // Send Telegram notification to admin
            $this->sendTelegramStatusUpdate($order, $oldStatus, $request->status);
        } catch (\Exception $e) {
            // Log the error but don't fail the status update
            \Log::error('Failed to send status update notification: ' . $e->getMessage());
        }

        // Log status change
        activity()
            ->performedOn($order)
            ->log("Order status changed from {$oldStatus} to {$request->status}");

        return back()->with('success', 'Order status updated successfully!');
    }

    /**
     * Send Telegram notification for order status update.
     */
    protected function sendTelegramStatusUpdate($order, $oldStatus, $newStatus)
    {
        $message = $this->formatStatusUpdateMessage($order, $oldStatus, $newStatus);
        
        $notification = new \App\Notifications\TelegramNotification($message, null, true);
        $notification->toTelegram(null);
    }

    /**
     * Format status update message for Telegram.
     */
    protected function formatStatusUpdateMessage($order, $oldStatus, $newStatus)
    {
        $statusEmojis = [
            'pending' => '⏳',
            'processing' => '⚙️',
            'shipped' => '📦',
            'delivered' => '✅',
            'cancelled' => '❌'
        ];

        $oldEmoji = $statusEmojis[$oldStatus] ?? '❓';
        $newEmoji = $statusEmojis[$newStatus] ?? '❓';

        $message = "🔄 <b>ORDER STATUS UPDATED</b>\n\n";
        $message .= "📋 <b>Order Details:</b>\n";
        $message .= "• Order #: <code>{$order->order_number}</code>\n";
        $message .= "• Customer: {$order->user->name}\n";
        $message .= "• Total: ₦" . number_format($order->total, 2) . "\n";
        $message .= "• Status: {$oldEmoji} {$oldStatus} → {$newEmoji} {$newStatus}\n";
        
        if ($order->tracking_number) {
            $message .= "• Tracking: {$order->tracking_number}\n";
        }
        
        $message .= "\n⏰ <b>Updated:</b> " . now()->format('M j, Y g:i A') . "\n";
        $message .= "\n🔗 <b>Admin Link:</b> " . route('admin.orders.show', $order->id);
        
        return $message;
    }

    /**
     * Update tracking information.
     */
    public function updateTracking(Request $request, Order $order)
    {
        $request->validate([
            'tracking_number' => 'required|string|max:255',
            'tracking_url' => 'nullable|url',
            'carrier' => 'nullable|string|max:100',
        ]);

        $order->update($request->only(['tracking_number', 'tracking_url', 'carrier']));

        return back()->with('success', 'Tracking information updated successfully!');
    }

    /**
     * Cancel an order.
     */
    public function cancel(Order $order)
    {
        if ($order->order_status === 'delivered') {
            return back()->with('error', 'Cannot cancel a delivered order!');
        }

        $oldStatus = $order->order_status;
        $order->update(['order_status' => 'cancelled']);

        // Send cancellation notification
        try {
            $order->user->notify(new OrderStatusUpdatedNotification($order, $oldStatus, 'cancelled'));
        } catch (\Exception $e) {
            \Log::error('Failed to send cancellation notification: ' . $e->getMessage());
        }

        // Refund to wallet if payment was made
        if ($order->payment_method === 'wallet' && $order->user->wallet) {
            $order->user->wallet->credit(
                $order->total,
                "Refund for cancelled order #{$order->order_number}",
                'order_refund',
                $order->id
            );
        }

        return back()->with('success', 'Order cancelled successfully!');
    }

    /**
     * Mark order as delivered.
     */
    public function markDelivered(Order $order)
    {
        $oldStatus = $order->order_status;
        $order->update([
            'order_status' => 'delivered',
            'delivered_at' => now()
        ]);

        // Send delivery notification
        try {
            $order->user->notify(new OrderStatusUpdatedNotification($order, $oldStatus, 'delivered'));
        } catch (\Exception $e) {
            \Log::error('Failed to send delivery notification: ' . $e->getMessage());
        }

        return back()->with('success', 'Order marked as delivered!');
    }

    /**
     * Show order analytics.
     */
    public function analytics()
    {
        // Order statistics
        $stats = [
            'total_orders' => Order::count(),
            'total_revenue' => Order::sum('total'),
            'pending_orders' => Order::where('order_status', 'pending')->count(),
            'processing_orders' => Order::where('order_status', 'processing')->count(),
            'shipped_orders' => Order::where('order_status', 'shipped')->count(),
            'delivered_orders' => Order::where('order_status', 'delivered')->count(),
            'cancelled_orders' => Order::where('order_status', 'cancelled')->count(),
        ];

        // Monthly order data
        $monthlyOrders = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as count, SUM(total) as revenue')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Top customers
        $topCustomers = Order::select('user_id', DB::raw('COUNT(*) as order_count'), DB::raw('SUM(total) as total_spent'))
            ->whereNotNull('user_id')
            ->groupBy('user_id')
            ->with('user')
            ->orderByDesc('total_spent')
            ->limit(10)
            ->get();

        // Order status distribution
        $statusDistribution = Order::select('order_status', DB::raw('COUNT(*) as count'))
            ->groupBy('order_status')
            ->get();

        return view('admin.orders.analytics', compact('stats', 'monthlyOrders', 'topCustomers', 'statusDistribution'));
    }

    /**
     * Export orders to CSV.
     */
    public function export(Request $request)
    {
        $query = Order::with(['user', 'items.product']);

        // Apply filters
        if ($request->has('status')) {
            $query->where('order_status', $request->status);
        }
        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->get();

        $filename = 'orders_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'Order Number', 'Customer Name', 'Customer Email',
                'Status', 'Total Amount', 'Payment Method', 'Created At', 'Items'
            ]);

            foreach ($orders as $order) {
                $items = $order->items->map(function($item) {
                    return $item->product->name . ' (x' . $item->quantity . ')';
                })->implode(', ');

                fputcsv($file, [
                    $order->order_number,
                    $order->user->name,
                    $order->user->email,
                    $order->order_status,
                    $order->total,
                    $order->payment_method,
                    $order->created_at,
                    $items
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Bulk update order statuses.
     */
    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'action' => 'required|in:processing,shipped,delivered,cancelled',
            'orders' => 'required|array',
            'orders.*' => 'exists:orders,id',
        ]);

        $orders = Order::whereIn('id', $request->orders);
        $orders->update(['order_status' => $request->action]);

        return back()->with('success', count($request->orders) . ' orders updated successfully!');
    }
}
