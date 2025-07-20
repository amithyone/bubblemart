<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramNotificationService
{
    /**
     * Send a Telegram notification
     */
    public static function send(string $message, array $data = []): bool
    {
        // Check if Telegram is enabled
        if (!Setting::isTelegramEnabled()) {
            return false;
        }

        $botToken = Setting::getTelegramBotToken();
        $chatId = Setting::getTelegramChatId();

        if (empty($botToken) || empty($chatId)) {
            Log::warning('Telegram notification failed: Missing bot token or chat ID');
            return false;
        }

        try {
            // Format message with data
            $formattedMessage = self::formatMessage($message, $data);
            
            $url = "https://api.telegram.org/bot{$botToken}/sendMessage";
            $payload = [
                'chat_id' => $chatId,
                'text' => $formattedMessage,
                'parse_mode' => 'HTML'
            ];

            $response = Http::timeout(10)->post($url, $payload);

            if ($response->successful()) {
                $result = $response->json();
                if ($result['ok']) {
                    Log::info('Telegram notification sent successfully', [
                        'message' => $message,
                        'chat_id' => $chatId
                    ]);
                    return true;
                } else {
                    Log::error('Telegram API error', [
                        'error' => $result['description'] ?? 'Unknown error',
                        'chat_id' => $chatId
                    ]);
                    return false;
                }
            } else {
                Log::error('Telegram API request failed', [
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Telegram notification exception', [
                'message' => $e->getMessage(),
                'chat_id' => $chatId
            ]);
            return false;
        }
    }

    /**
     * Send notification for new order
     */
    public static function notifyNewOrder($order): bool
    {
        if (!Setting::isNotificationEnabled('new_orders')) {
            return false;
        }

        $message = "🛒 <b>New Order Received!</b>\n\n" .
                   "📦 Order ID: <code>{$order->id}</code>\n" .
                   "👤 Customer: {$order->customer_name}\n" .
                   "💰 Total: ₦" . number_format($order->total, 2) . "\n" .
                   "📅 Date: " . $order->created_at->format('M j, Y g:i A') . "\n" .
                   "📍 Status: {$order->status}\n\n" .
                   "🔗 <a href='" . route('admin.orders.show', $order) . "'>View Order</a>";

        return self::send($message, ['order' => $order]);
    }

    /**
     * Send notification for order status update
     */
    public static function notifyOrderUpdate($order, $oldStatus, $newStatus): bool
    {
        if (!Setting::isNotificationEnabled('order_updates')) {
            return false;
        }

        $statusEmoji = self::getStatusEmoji($newStatus);
        
        $message = "🔄 <b>Order Status Updated</b>\n\n" .
                   "📦 Order ID: <code>{$order->id}</code>\n" .
                   "👤 Customer: {$order->customer_name}\n" .
                   "📊 Status: {$oldStatus} → {$statusEmoji} {$newStatus}\n" .
                   "💰 Total: ₦" . number_format($order->total, 2) . "\n" .
                   "📅 Updated: " . now()->format('M j, Y g:i A') . "\n\n" .
                   "🔗 <a href='" . route('admin.orders.show', $order) . "'>View Order</a>";

        return self::send($message, ['order' => $order, 'old_status' => $oldStatus, 'new_status' => $newStatus]);
    }

    /**
     * Send notification for payment confirmation
     */
    public static function notifyPayment($order, $amount, $paymentMethod): bool
    {
        if (!Setting::isNotificationEnabled('payments')) {
            return false;
        }

        $message = "💳 <b>Payment Confirmed!</b>\n\n" .
                   "📦 Order ID: <code>{$order->id}</code>\n" .
                   "👤 Customer: {$order->customer_name}\n" .
                   "💰 Amount: ₦" . number_format($amount, 2) . "\n" .
                   "💳 Method: {$paymentMethod}\n" .
                   "📅 Date: " . now()->format('M j, Y g:i A') . "\n\n" .
                   "🔗 <a href='" . route('admin.orders.show', $order) . "'>View Order</a>";

        return self::send($message, ['order' => $order, 'amount' => $amount, 'method' => $paymentMethod]);
    }

    /**
     * Send notification for low stock alert
     */
    public static function notifyLowStock($product, $currentStock, $threshold = 10): bool
    {
        if (!Setting::isNotificationEnabled('low_stock')) {
            return false;
        }

        $message = "⚠️ <b>Low Stock Alert!</b>\n\n" .
                   "📦 Product: {$product->name}\n" .
                   "📊 Current Stock: {$currentStock}\n" .
                   "🚨 Threshold: {$threshold}\n" .
                   "📅 Alert Date: " . now()->format('M j, Y g:i A') . "\n\n" .
                   "🔗 <a href='" . route('admin.products.edit', $product) . "'>Update Stock</a>";

        return self::send($message, ['product' => $product, 'stock' => $currentStock, 'threshold' => $threshold]);
    }

    /**
     * Format message with data replacements
     */
    protected static function formatMessage(string $message, array $data): string
    {
        foreach ($data as $key => $value) {
            if (is_object($value)) {
                // Handle object properties
                if (method_exists($value, 'toArray')) {
                    $array = $value->toArray();
                    foreach ($array as $propKey => $propValue) {
                        $message = str_replace("{{$key}.{$propKey}}", $propValue, $message);
                    }
                }
            } else {
                $message = str_replace("{{$key}}", $value, $message);
            }
        }

        return $message;
    }

    /**
     * Get emoji for order status
     */
    protected static function getStatusEmoji(string $status): string
    {
        return match(strtolower($status)) {
            'pending' => '⏳',
            'processing' => '⚙️',
            'shipped' => '📦',
            'delivered' => '✅',
            'cancelled' => '❌',
            'refunded' => '💰',
            default => '📋'
        };
    }

    /**
     * Test Telegram connection
     */
    public static function testConnection(string $botToken, string $chatId): array
    {
        try {
            $message = "🧪 <b>Test Message</b>\n\n" .
                       "✅ Telegram integration is working correctly.\n" .
                       "📅 " . now()->format('Y-m-d H:i:s') . "\n" .
                       "🔗 " . config('app.url');

            $url = "https://api.telegram.org/bot{$botToken}/sendMessage";
            $payload = [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'HTML'
            ];

            $response = Http::timeout(10)->post($url, $payload);

            if ($response->successful()) {
                $result = $response->json();
                if ($result['ok']) {
                    return [
                        'success' => true,
                        'message' => 'Test message sent successfully!'
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => 'Telegram API error: ' . ($result['description'] ?? 'Unknown error')
                    ];
                }
            } else {
                return [
                    'success' => false,
                    'message' => 'Failed to connect to Telegram API'
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }
} 