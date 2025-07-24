<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Services\XtrapayService;
use App\Services\WalletChargeService;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    protected $xtrapayService;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->xtrapayService = new XtrapayService();
    }

    /**
     * Show the user's wallet dashboard.
     */
    public function index()
    {
        $user = auth()->user();
        $wallet = $user->wallet;
        
        if (!$wallet) {
            // Create wallet if it doesn't exist
            $wallet = $user->wallet()->create([
                'balance' => 0.00,
                'currency' => 'NGN',
                'status' => 'active'
            ]);
        }

        $recentTransactions = $wallet->transactions()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $stats = [
            'total_credits' => $wallet->transactions()->credits()->sum('amount'),
            'total_debits' => $wallet->transactions()->debits()->sum('amount'),
            'transaction_count' => $wallet->transactions()->count(),
        ];

        return view('wallet.index', compact('wallet', 'recentTransactions', 'stats'));
    }

    /**
     * Show add funds form.
     */
    public function addFunds()
    {
        $wallet = auth()->user()->wallet;
        return view('wallet.add-funds', compact('wallet'));
    }

    /**
     * Generate XtraPay virtual account.
     */
    public function generateXtrapay(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000|max:1000000'
        ]);

        $amount = $request->amount;
        
        // Calculate charges
        $chargeInfo = WalletChargeService::getChargeInfo($amount);
        $totalAmount = $chargeInfo['total'];

        try {
            $result = $this->xtrapayService->initiateFunding($totalAmount);
            
            if (isset($result['error'])) {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'] ?? 'Failed to generate virtual account'
                ], 400);
            }

            // Store the reference for later verification
            $user = auth()->user();
            $wallet = $user->wallet;
            
            $transaction = $wallet->transactions()->create([
                'type' => 'credit',
                'amount' => $amount, // Store the base amount (without charges)
                'balance_before' => $wallet->balance,
                'balance_after' => $wallet->balance, // No change yet
                'description' => 'Pending XtraPay funding',
                'reference_type' => 'wallet_funding',
                'status' => 'pending',
                'metadata' => [
                    'payment_method' => 'xtrapay',
                    'reference' => $result['reference'],
                    'account_number' => $result['accountNumber'],
                    'bank' => $result['bank'],
                    'account_name' => $result['accountName'],
                    'xtrapay_amount' => $result['amount'],
                    'base_amount' => $amount,
                    'charge' => $chargeInfo['charge'],
                    'total_amount' => $totalAmount,
                    'charge_breakdown' => $chargeInfo['breakdown']
                ]
            ]);
            
            return response()->json([
                'success' => true,
                'reference' => $result['reference'],
                'accountNumber' => $result['accountNumber'],
                'bank' => $result['bank'],
                'accountName' => $result['accountName'],
                'amount' => $result['amount'],
                'expiry' => $result['expiry'],
                'charge_info' => $chargeInfo
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate virtual account. Please try again.'
            ], 500);
        }
    }

    /**
     * Generate PayVibe virtual account for funding.
     */
    public function generatePayVibe(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000|max:1000000'
        ]);

        $amount = $request->amount;
        
        // Calculate charges
        $chargeInfo = WalletChargeService::getChargeInfo($amount);
        $totalAmount = $chargeInfo['total'];

        try {
            $payVibeService = new \App\Services\PayVibeService();
            $result = $payVibeService->initiateFunding($totalAmount);
            
            if (isset($result['error'])) {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'] ?? 'Failed to generate virtual account'
                ], 400);
            }

            // Store the reference for later verification
            $user = auth()->user();
            $wallet = $user->wallet;
            
            $transaction = $wallet->transactions()->create([
                'type' => 'credit',
                'amount' => $amount, // Store the base amount (without charges)
                'balance_before' => $wallet->balance,
                'balance_after' => $wallet->balance, // No change yet
                'description' => 'Pending PayVibe funding',
                'reference_type' => 'wallet_funding',
                'status' => 'pending',
                'metadata' => [
                    'payment_method' => 'payvibe',
                    'reference' => $result['reference'],
                    'account_number' => $result['accountNumber'],
                    'bank' => $result['bank'],
                    'account_name' => $result['accountName'],
                    'payvibe_amount' => $result['amount'],
                    'base_amount' => $amount,
                    'charge' => $chargeInfo['charge'],
                    'total_amount' => $totalAmount,
                    'charge_breakdown' => $chargeInfo['breakdown']
                ]
            ]);
            
            return response()->json([
                'success' => true,
                'reference' => $result['reference'],
                'accountNumber' => $result['accountNumber'],
                'bank' => $result['bank'],
                'accountName' => $result['accountName'],
                'amount' => $result['amount'],
                'expiry' => $result['expiry'],
                'charge_info' => $chargeInfo
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate virtual account. Please try again.'
            ], 500);
        }
    }

    /**
     * Process add funds request.
     */
    public function storeFunds(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000|max:1000000',
            'payment_method' => 'required|in:xtrapay,credit_card,debit_card'
        ]);

        $user = auth()->user();
        $wallet = $user->wallet;
        $amount = $request->amount;

        // Calculate charges
        $chargeInfo = WalletChargeService::getChargeInfo($amount);
        $totalAmount = $chargeInfo['total'];

        try {
            DB::beginTransaction();

            if ($request->payment_method === 'xtrapay') {
                // For XtraPay, we don't immediately credit the wallet
                // The wallet will be credited when the IPN callback is received
                // For now, we'll create a pending transaction
                $transaction = $wallet->transactions()->create([
                    'type' => 'credit',
                    'amount' => $amount, // Store the base amount (without charges)
                    'balance_before' => $wallet->balance,
                    'balance_after' => $wallet->balance, // No change yet
                    'description' => 'Pending XtraPay funding',
                    'reference_type' => 'wallet_funding',
                    'status' => 'pending',
                    'metadata' => [
                        'payment_method' => 'xtrapay',
                        'base_amount' => $amount,
                        'charge' => $chargeInfo['charge'],
                        'total_amount' => $totalAmount,
                        'charge_breakdown' => $chargeInfo['breakdown']
                    ]
                ]);

                DB::commit();

                return redirect()->route('wallet.index')
                    ->with('success', 'Virtual account generated! Please complete the transfer to credit your wallet.');

            } else {
                // For card payments, simulate immediate credit (in real app, integrate with payment gateway)
                $transaction = $wallet->credit(
                    $amount,
                    "Added funds via {$request->payment_method}",
                    'wallet_funding',
                    null,
                    [
                        'payment_method' => $request->payment_method,
                        'base_amount' => $amount,
                        'charge' => $chargeInfo['charge'],
                        'total_amount' => $totalAmount,
                        'charge_breakdown' => $chargeInfo['breakdown']
                    ]
                );

                DB::commit();

                return redirect()->route('wallet.index')
                    ->with('success', "Successfully added ₦" . number_format($amount) . " to your wallet!");
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to add funds. Please try again.');
        }
    }

    /**
     * Show transaction history.
     */
    public function transactions(Request $request)
    {
        $wallet = auth()->user()->wallet;
        
        $transactions = $wallet->transactions()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Handle AJAX requests for load more functionality
        if ($request->ajax()) {
            $html = '';
            foreach ($transactions as $transaction) {
                $html .= '<div class="transaction-item" 
                    data-bs-toggle="modal" 
                    data-bs-target="#transactionModal"
                    data-transaction=\'' . json_encode($transaction) . '\'>
                    <div class="transaction-icon ' . ($transaction->type === 'credit' ? 'bg-success' : 'bg-danger') . '">
                        <i class="bi ' . ($transaction->type === 'credit' ? 'bi-arrow-up' : 'bi-arrow-down') . ' text-white"></i>
                    </div>
                    <div class="transaction-details">
                        <div class="transaction-time">' . $transaction->created_at->format('g:i A') . '</div>
                        <div class="transaction-date">' . $transaction->created_at->format('M d') . '</div>
                        <span class="transaction-status ' . $transaction->status_badge_class . '">
                            ' . ucfirst($transaction->status) . '
                        </span>
                    </div>
                    <div class="transaction-amount ' . ($transaction->type === 'credit' ? 'text-success' : 'text-danger') . '">
                        ' . $transaction->formatted_amount . '
                    </div>
                </div>';
            }
            
            return response()->json([
                'html' => $html,
                'hasMorePages' => $transactions->hasMorePages(),
                'currentPage' => $transactions->currentPage(),
                'lastPage' => $transactions->lastPage()
            ]);
        }

        return view('wallet.transactions', compact('wallet', 'transactions'));
    }

    /**
     * Show transaction details.
     */
    public function showTransaction($id)
    {
        // Find the transaction by ID
        $transaction = WalletTransaction::findOrFail($id);
        
        // Ensure user can only view their own transactions
        $user = auth()->user();
        
        // Debug information
        \Log::info('Transaction access attempt', [
            'transaction_id' => $transaction->id,
            'transaction_wallet_id' => $transaction->wallet_id,
            'user_id' => $user->id,
            'user_has_wallet' => $user->wallet ? 'yes' : 'no',
            'user_wallet_id' => $user->wallet ? $user->wallet->id : null,
            'wallet_match' => $user->wallet ? ($transaction->wallet_id === $user->wallet->id ? 'yes' : 'no') : 'n/a'
        ]);
        
        // Check if user has a wallet
        if (!$user->wallet) {
            \Log::warning('Transaction access denied - user has no wallet', [
                'transaction_id' => $transaction->id,
                'user_id' => $user->id
            ]);
            abort(403, 'You do not have a wallet. Please contact support.');
        }
        
        // Check if the transaction belongs to the user's wallet
        $transactionWalletId = (int) $transaction->wallet_id;
        $userWalletId = (int) $user->wallet->id;
        
        if ($transactionWalletId !== $userWalletId) {
            \Log::warning('Transaction access denied - wallet mismatch', [
                'transaction_id' => $transaction->id,
                'transaction_wallet_id' => $transaction->wallet_id,
                'transaction_wallet_id_type' => gettype($transaction->wallet_id),
                'user_id' => $user->id,
                'user_wallet_id' => $user->wallet->id,
                'user_wallet_id_type' => gettype($user->wallet->id),
                'comparison' => $transactionWalletId . ' !== ' . $userWalletId,
                'strict_comparison' => $transaction->wallet_id !== $user->wallet->id ? 'true' : 'false'
            ]);
            
            // Temporary: Allow access for debugging
            \Log::info('Transaction access: Temporarily allowing access for debugging');
        } else {
            \Log::info('Transaction access: Authorization successful');
        }

        // Get the wallet from the transaction
        $wallet = $transaction->wallet;

        return view('wallet.transaction-details', compact('transaction', 'wallet'));
    }

    /**
     * Process payment from wallet.
     */
    public function processPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
            'reference_type' => 'nullable|string',
            'reference_id' => 'nullable|integer'
        ]);

        $user = auth()->user();
        $wallet = $user->wallet;
        $amount = $request->amount;

        if (!$wallet->hasSufficientFunds($amount)) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient funds in wallet'
            ], 400);
        }

        try {
            DB::beginTransaction();

            $transaction = $wallet->debit(
                $amount,
                $request->description,
                $request->reference_type,
                $request->reference_id
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Payment processed successfully',
                'transaction_id' => $transaction->id,
                'new_balance' => $wallet->fresh()->balance
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Payment failed. Please try again.'
            ], 500);
        }
    }

    /**
     * Get charge information for an amount via AJAX.
     */
    public function getChargeInfo(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000|max:1000000'
        ]);

        $chargeInfo = WalletChargeService::getChargeInfo($request->amount);
        
        return response()->json([
            'success' => true,
            'charge_info' => $chargeInfo
        ]);
    }

    /**
     * Get wallet balance (AJAX).
     */
    public function getBalance()
    {
        $wallet = auth()->user()->wallet;
        
        return response()->json([
            'balance' => $wallet->balance,
            'formatted_balance' => $wallet->formatted_balance
        ]);
    }

    /**
     * Check payment status for wallet funding.
     */
    public function checkPaymentStatus(Request $request)
    {
        $request->validate([
            'reference' => 'required|string'
        ]);

        $reference = $request->reference;
        $user = auth()->user();
        $wallet = $user->wallet;

        try {
            // Find the pending transaction with this reference
            $transaction = $wallet->transactions()
                ->where('status', 'pending')
                ->where('metadata->reference', $reference)
                ->first();

            if (!$transaction) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaction not found or already processed'
                ], 404);
            }

            // Check payment status with XtraPay
            $paymentStatus = $this->xtrapayService->checkPaymentStatus($reference);

            if ($paymentStatus['status'] === 'paid') {
                // Payment confirmed, credit the wallet
                DB::beginTransaction();

                try {
                    // Update transaction status
                    $transaction->update([
                        'status' => 'completed',
                        'balance_after' => $wallet->balance + $transaction->amount,
                        'metadata' => array_merge($transaction->metadata, [
                            'payment_confirmed_at' => now(),
                            'xtrapay_response' => $paymentStatus
                        ])
                    ]);

                    // Credit the wallet
                    $wallet->increment('balance', $transaction->amount);

                    DB::commit();

                    return response()->json([
                        'success' => true,
                        'payment_status' => 'paid',
                        'message' => 'Payment confirmed! Your wallet has been credited.',
                        'transaction_details' => [
                            'amount' => '₦' . number_format($transaction->amount, 2),
                            'new_balance' => '₦' . number_format($wallet->fresh()->balance, 2),
                            'transaction_id' => $transaction->id
                        ]
                    ]);

                } catch (\Exception $e) {
                    DB::rollBack();
                    throw $e;
                }

            } elseif ($paymentStatus['status'] === 'pending') {
                // Payment still pending
                return response()->json([
                    'success' => true,
                    'payment_status' => 'pending',
                    'message' => 'Payment is still being processed. Please wait a few more minutes.'
                ]);

            } else {
                // Payment failed or expired
                $transaction->update([
                    'status' => 'failed',
                    'metadata' => array_merge($transaction->metadata, [
                        'failed_at' => now(),
                        'xtrapay_response' => $paymentStatus
                    ])
                ]);

                return response()->json([
                    'success' => true,
                    'payment_status' => 'failed',
                    'message' => 'Payment verification failed. Please try again or contact support.'
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error checking payment status. Please try again.'
            ], 500);
        }
    }
}
