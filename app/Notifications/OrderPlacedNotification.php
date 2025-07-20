<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class OrderPlacedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['telegram'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'customer_name' => $this->order->user->name,
            'total_amount' => $this->order->total,
        ];
    }

    /**
     * Send notification to Telegram.
     */
    public function toTelegram($notifiable)
    {
        $message = $this->formatOrderMessage();
        
        $notification = new TelegramNotification($message, null, true);
        $notification->toTelegram($notifiable);
    }

    /**
     * Format the order message for Telegram.
     */
    protected function formatOrderMessage()
    {
        $order = $this->order;
        $user = $order->user;
        
        $message = "🛍️ <b>NEW ORDER PLACED!</b>\n\n";
        $message .= "📋 <b>Order Details:</b>\n";
        $message .= "• Order #: <code>{$order->order_number}</code>\n";
        $message .= "• Customer: {$user->name}\n";
        $message .= "• Email: {$user->email}\n";
        $message .= "• Phone: " . ($user->phone ?? 'N/A') . "\n";
        $message .= "• Total: ₦" . number_format($order->total, 2) . "\n";
        $message .= "• Payment: " . ucfirst($order->payment_method) . "\n";
        $message .= "• Status: " . ucfirst($order->order_status) . "\n\n";
        
        $message .= "📦 <b>Items:</b>\n";
        foreach ($order->items as $item) {
            $message .= "• {$item->product->name} (x{$item->quantity}) - ₦" . number_format($item->price, 2) . "\n";
        }
        
        if ($order->address) {
            $message .= "\n📍 <b>Delivery Address:</b>\n";
            $message .= "• {$order->address->full_name}\n";
            $message .= "• {$order->address->address_line_1}\n";
            if ($order->address->address_line_2) {
                $message .= "• {$order->address->address_line_2}\n";
            }
            $message .= "• {$order->address->city}, {$order->address->state} {$order->address->postal_code}\n";
            $message .= "• Phone: {$order->address->phone}\n";
        }
        
        $message .= "\n⏰ <b>Order Time:</b> " . $order->created_at->format('M j, Y g:i A') . "\n";
        $message .= "\n🔗 <b>Admin Link:</b> " . route('admin.orders.show', $order->id);
        
        return $message;
    }
}
