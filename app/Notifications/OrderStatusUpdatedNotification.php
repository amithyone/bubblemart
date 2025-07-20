<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class OrderStatusUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;
    public $oldStatus;
    public $newStatus;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order, $oldStatus, $newStatus)
    {
        $this->order = $order;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $statusMessages = [
            'pending' => 'Your order is being processed',
            'confirmed' => 'Your order has been confirmed and is being prepared',
            'shipped' => 'Your order has been shipped and is on its way',
            'delivered' => 'Your order has been delivered successfully',
            'cancelled' => 'Your order has been cancelled'
        ];

        $statusIcons = [
            'pending' => '⏳',
            'confirmed' => '✅',
            'shipped' => '🚚',
            'delivered' => '🎉',
            'cancelled' => '❌'
        ];

        $message = (new MailMessage)
            ->subject($statusIcons[$this->newStatus] . ' Order Status Updated - Bublemart')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your order status has been updated.')
            ->line('Order Details:')
            ->line('📦 Order Number: #' . $this->order->order_number)
            ->line('📊 Status: ' . ucfirst($this->newStatus))
            ->line('📅 Updated: ' . now()->format('M d, Y \a\t g:i A'));

        if ($this->newStatus === 'shipped' && $this->order->tracking_number) {
            $message->line('📮 Tracking Number: ' . $this->order->tracking_number);
        }

        $message->line($statusMessages[$this->newStatus])
            ->action('View Order Details', route('orders.show', $this->order));

        if ($this->newStatus === 'delivered') {
            $message->line('We hope you love your gift! Thank you for choosing Bublemart.')
                ->line('Please consider leaving a review for your experience.');
        } elseif ($this->newStatus === 'shipped') {
            $message->line('Your gift is on its way! You can track the delivery using the tracking number above.');
        } else {
            $message->line('We\'ll keep you updated on any further changes to your order status.');
        }

        return $message->salutation('Best regards, The Bublemart Team');
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
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'message' => 'Order #' . $this->order->order_number . ' status updated to ' . ucfirst($this->newStatus),
            'type' => 'order_status_updated'
        ];
    }
}
