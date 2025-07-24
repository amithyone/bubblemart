<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramNotification extends Notification
{
    use Queueable;

    protected $message;
    protected $chatId;
    protected $sendToAll;

    /**
     * Create a new notification instance.
     */
    public function __construct($message, $chatId = null, $sendToAll = false)
    {
        $this->message = $message;
        $this->chatId = $chatId;
        $this->sendToAll = $sendToAll;
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
            'message' => $this->message,
            'chat_id' => $this->chatId,
            'send_to_all' => $this->sendToAll,
        ];
    }

    /**
     * Send notification to Telegram.
     */
    public function toTelegram($notifiable)
    {
        // Use settings from database instead of config
        $botToken = \App\Models\Setting::getTelegramBotToken();
        $chatId = \App\Models\Setting::getTelegramChatId();
        
        if (!$botToken || !$chatId) {
            Log::error('Telegram bot token or chat ID not configured in settings');
            return;
        }

        // Check if Telegram is enabled
        if (!\App\Models\Setting::isTelegramEnabled()) {
            Log::info('Telegram notifications are disabled');
            return;
        }

        try {
            $response = Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $this->message,
                'parse_mode' => 'HTML',
            ]);

            if ($response->successful()) {
                Log::info("Telegram notification sent successfully to chat ID: {$chatId}");
            } else {
                Log::error("Telegram notification failed for chat ID: {$chatId}", [
                    'response' => $response->json(),
                    'status' => $response->status()
                ]);
            }
        } catch (\Exception $e) {
            Log::error("Telegram notification exception for chat ID: {$chatId}", [
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Get chat IDs to send notifications to.
     */
    protected function getChatIds()
    {
        // Always use the chat ID from settings
        $chatId = \App\Models\Setting::getTelegramChatId();
        return $chatId ? [$chatId] : [];
    }
} 