<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WalletTransaction;
use App\Models\Order;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of transactions.
     */
    public function index(Request $request)
    {
        $query = WalletTransaction::with(['wallet.user'])
            ->orderBy('created_at', 'desc');

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('reference_type', 'like', "%{$search}%")
                  ->orWhere('reference_id', 'like', "%{$search}%")
                  ->orWhereHas('wallet.user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by transaction type
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
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
            $query->whereHas('wallet', function($walletQuery) use ($request) {
                $walletQuery->where('user_id', $request->user_id);
            });
        }

        $transactions = $query->paginate(20);
        $users = User::has('wallet')->get();

        // Statistics
        $stats = [
            'total_transactions' => WalletTransaction::count(),
            'total_credits' => WalletTransaction::where('type', 'credit')->sum('amount'),
            'total_debits' => WalletTransaction::where('type', 'debit')->sum('amount'),
            'total_refunds' => WalletTransaction::where('type', 'refund')->sum('amount'),
            'pending_transactions' => WalletTransaction::where('status', 'pending')->count(),
            'failed_transactions' => WalletTransaction::where('status', 'failed')->count(),
        ];

        return view('admin.transactions.index', compact('transactions', 'users', 'stats'));
    }

    /**
     * Display the specified transaction.
     */
    public function show(WalletTransaction $transaction)
    {
        $transaction->load(['wallet.user']);
        
        // Get related order if this is an order-related transaction
        $relatedOrder = null;
        if ($transaction->reference_type === 'order' && $transaction->reference_id) {
            $relatedOrder = Order::with(['user', 'items.product'])->find($transaction->reference_id);
        }

        return view('admin.transactions.show', compact('transaction', 'relatedOrder'));
    }

    /**
     * Process refund for a canceled order.
     */
    public function processRefund(Request $request, Order $order)
    {
        // Validate order can be refunded
        if ($order->order_status !== 'cancelled') {
            return back()->with('error', 'Only cancelled orders can be refunded.');
        }

        if ($order->payment_method !== 'wallet') {
            return back()->with('error', 'Only wallet payments can be refunded through this system.');
        }

        // Check if refund already exists
        $existingRefund = WalletTransaction::where('reference_type', 'order')
            ->where('reference_id', $order->id)
            ->where('type', 'refund')
            ->first();

        if ($existingRefund) {
            return back()->with('error', 'Refund for this order has already been processed.');
        }

        try {
            DB::beginTransaction();

            // Process refund
            $refundTransaction = $order->user->wallet->credit(
                $order->total,
                "Refund for cancelled order #{$order->order_number}",
                'order_refund',
                $order->id,
                [
                    'order_number' => $order->order_number,
                    'refund_reason' => 'Order cancelled',
                    'processed_by' => auth()->id(),
                    'processed_at' => now()->toISOString()
                ]
            );

            // Update order with refund information
            $order->update([
                'refunded_at' => now(),
                'refund_amount' => $order->total,
                'refund_transaction_id' => $refundTransaction->id
            ]);

            DB::commit();

            // Log the refund
            Log::info('Order refund processed', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'refund_amount' => $order->total,
                'transaction_id' => $refundTransaction->id,
                'processed_by' => auth()->id()
            ]);

            return back()->with('success', "Refund of ₦" . number_format($order->total, 2) . " processed successfully!");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to process refund', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to process refund. Please try again.');
        }
    }

    /**
     * Bulk refund multiple cancelled orders.
     */
    public function bulkRefund(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:orders,id'
        ]);

        $orders = Order::whereIn('id', $request->order_ids)
            ->where('order_status', 'cancelled')
            ->where('payment_method', 'wallet')
            ->whereNull('refunded_at')
            ->get();

        if ($orders->isEmpty()) {
            return back()->with('error', 'No eligible orders found for refund.');
        }

        $successCount = 0;
        $totalRefunded = 0;

        foreach ($orders as $order) {
            try {
                DB::beginTransaction();

                // Check if refund already exists
                $existingRefund = WalletTransaction::where('reference_type', 'order')
                    ->where('reference_id', $order->id)
                    ->where('type', 'refund')
                    ->first();

                if ($existingRefund) {
                    continue; // Skip if already refunded
                }

                // Process refund
                $refundTransaction = $order->user->wallet->credit(
                    $order->total,
                    "Refund for cancelled order #{$order->order_number}",
                    'order_refund',
                    $order->id,
                    [
                        'order_number' => $order->order_number,
                        'refund_reason' => 'Order cancelled',
                        'processed_by' => auth()->id(),
                        'processed_at' => now()->toISOString()
                    ]
                );

                // Update order
                $order->update([
                    'refunded_at' => now(),
                    'refund_amount' => $order->total,
                    'refund_transaction_id' => $refundTransaction->id
                ]);

                DB::commit();

                $successCount++;
                $totalRefunded += $order->total;

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Failed to process bulk refund for order', [
                    'order_id' => $order->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        if ($successCount > 0) {
            return back()->with('success', "Successfully processed {$successCount} refunds totaling ₦" . number_format($totalRefunded, 2));
        } else {
            return back()->with('error', 'No refunds were processed. Please check the orders and try again.');
        }
    }

    /**
     * Show transaction analytics.
     */
    public function analytics()
    {
        // Transaction statistics
        $stats = [
            'total_transactions' => WalletTransaction::count(),
            'total_credits' => WalletTransaction::where('type', 'credit')->sum('amount'),
            'total_debits' => WalletTransaction::where('type', 'debit')->sum('amount'),
            'total_refunds' => WalletTransaction::where('type', 'refund')->sum('amount'),
            'pending_transactions' => WalletTransaction::where('status', 'pending')->count(),
            'failed_transactions' => WalletTransaction::where('status', 'failed')->count(),
        ];

        // Monthly transaction data
        $monthlyTransactions = WalletTransaction::selectRaw('
            MONTH(created_at) as month, 
            COUNT(*) as count, 
            SUM(CASE WHEN type = "credit" THEN amount ELSE 0 END) as credits,
            SUM(CASE WHEN type = "debit" THEN amount ELSE 0 END) as debits,
            SUM(CASE WHEN type = "refund" THEN amount ELSE 0 END) as refunds
        ')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Transaction type distribution
        $typeDistribution = WalletTransaction::select('type', DB::raw('COUNT(*) as count'), DB::raw('SUM(amount) as total_amount'))
            ->groupBy('type')
            ->get();

        // Top users by transaction volume
        $topUsers = WalletTransaction::select('wallet_id', DB::raw('COUNT(*) as transaction_count'), DB::raw('SUM(amount) as total_amount'))
            ->with('wallet.user')
            ->groupBy('wallet_id')
            ->orderByDesc('total_amount')
            ->limit(10)
            ->get();

        // Recent refunds
        $recentRefunds = WalletTransaction::where('type', 'refund')
            ->with(['wallet.user'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.transactions.analytics', compact(
            'stats', 
            'monthlyTransactions', 
            'typeDistribution', 
            'topUsers', 
            'recentRefunds'
        ));
    }

    /**
     * Export transactions to CSV.
     */
    public function export(Request $request)
    {
        $query = WalletTransaction::with(['wallet.user']);

        // Apply filters
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $transactions = $query->get();

        $filename = 'transactions_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function() use ($transactions) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'Transaction ID', 'User Name', 'User Email', 'Type', 'Amount', 
                'Balance Before', 'Balance After', 'Description', 'Reference Type', 
                'Reference ID', 'Status', 'Created At'
            ]);

            foreach ($transactions as $transaction) {
                fputcsv($file, [
                    $transaction->id,
                    $transaction->wallet->user->name ?? 'N/A',
                    $transaction->wallet->user->email ?? 'N/A',
                    $transaction->type,
                    $transaction->amount,
                    $transaction->balance_before,
                    $transaction->balance_after,
                    $transaction->description,
                    $transaction->reference_type,
                    $transaction->reference_id,
                    $transaction->status,
                    $transaction->created_at
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
} 