<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class CreateTestOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:create-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test order for tracking simulation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the first user (or create one if none exists)
        $user = User::first();
        if (!$user) {
            $this->error('No users found. Please create a user first.');
            return 1;
        }

        // Get the first product (or create one if none exists)
        $product = Product::first();
        if (!$product) {
            $this->error('No products found. Please create a product first.');
            return 1;
        }

        // Create test order
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'subtotal' => 50000, // ₦50,000
            'tax' => 5000, // ₦5,000
            'shipping' => 2000, // ₦2,000
            'total' => 57000, // ₦57,000
            'payment_method' => 'instant',
            'payment_status' => 'paid',
            'order_status' => 'shipped', // Set to shipped to show progress
        ]);

        // Create order item
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => 50000.00,
            'total' => 50000.00,
            'receiver_name' => 'John Doe',
            'receiver_address' => '123 Main Street, Lagos, Nigeria',
            'receiver_phone' => '08012345678',
            'receiver_note' => 'Please deliver between 9 AM and 5 PM',
        ]);

        $this->info("Test order created successfully!");
        $this->info("Order Number: {$order->order_number}");
        $this->info("Receiver Phone: 08012345678");
        $this->info("Total Amount: ₦" . number_format($order->total));
        $this->info("Status: {$order->order_status}");
        
        $this->info("\nYou can now test tracking with:");
        $this->info("- Order Number: {$order->order_number}");
        $this->info("- Phone Number: 08012345678");

        return 0;
    }
} 