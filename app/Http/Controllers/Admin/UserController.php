<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $query = User::with(['wallet', 'orders', 'addresses']);

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by admin status
        if ($request->has('role')) {
            if ($request->role === 'admin') {
                $query->where('is_admin', true);
            } elseif ($request->role === 'user') {
                $query->where('is_admin', false);
            }
        }

        // Filter by status
        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->status === 'inactive') {
                $query->whereNull('email_verified_at');
            }
        }

        $users = $query->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'is_admin' => 'boolean',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $request->has('is_admin'),
        ]);

        // Create wallet for new user
        $user->wallet()->create([
            'balance' => 0.00,
            'currency' => 'USD',
            'status' => 'active'
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully!');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user->load(['wallet', 'orders', 'customizations']);
        
        $recentOrders = $user->orders()->latest()->limit(10)->get();
        $recentTransactions = $user->wallet ? $user->wallet->transactions()->latest()->limit(10)->get() : collect();
        
        $stats = [
            'total_orders' => $user->orders()->count(),
            'total_spent' => $user->orders()->sum('total'),
            'wallet_balance' => $user->wallet ? $user->wallet->balance : 0,
            'total_customizations' => $user->customizations()->count(),
        ];

        return view('admin.users.show', compact('user', 'recentOrders', 'recentTransactions', 'stats'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'is_admin' => 'boolean',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'is_admin' => $request->has('is_admin'),
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully!');
    }

    /**
     * Show user's wallet transactions.
     */
    public function walletTransactions(User $user)
    {
        $transactions = $user->wallet->transactions()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.users.wallet-transactions', compact('user', 'transactions'));
    }

    /**
     * Show user's orders.
     */
    public function orders(User $user)
    {
        $orders = $user->orders()
            ->with(['items.product', 'items.customization'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.users.orders', compact('user', 'orders'));
    }

    /**
     * Add funds to user's wallet.
     */
    public function addWalletFunds(Request $request, User $user)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
        ]);

        if (!$user->wallet) {
            $user->wallet()->create([
                'balance' => 0.00,
                'currency' => 'USD',
                'status' => 'active'
            ]);
        }

        $user->wallet->credit(
            $request->amount,
            $request->description,
            'admin_adjustment',
            null,
            ['admin_id' => auth()->id()]
        );

        return back()->with('success', "Added \${$request->amount} to user's wallet!");
    }

    /**
     * Deduct funds from user's wallet.
     */
    public function deductWalletFunds(Request $request, User $user)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
        ]);

        if (!$user->wallet || !$user->wallet->hasSufficientFunds($request->amount)) {
            return back()->with('error', 'Insufficient funds in wallet!');
        }

        $user->wallet->debit(
            $request->amount,
            $request->description,
            'admin_adjustment',
            null,
            ['admin_id' => auth()->id()]
        );

        return back()->with('success', "Deducted \${$request->amount} from user's wallet!");
    }
}
