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
        $botToken = config('services.telegram.bot_token');
        
        if (!$botToken) {
            Log::error('Telegram bot token not configured');
            return;
        }

        $chatIds = $this->getChatIds();

        foreach ($chatIds as $chatId) {
            if (empty($chatId)) continue;

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
    }

    /**
     * Get chat IDs to send notifications to.
     */
    protected function getChatIds()
    {
        if ($this->chatId) {
            return [$this->chatId];
        }

        if ($this->sendToAll) {
            return $this->getAllChatIds();
        }

        // Default to primary chat ID
        return [config('services.telegram.chat_id')];
    }

    /**
     * Get all configured chat IDs.
     */
    protected function getAllChatIds()
    {
        $chatIds = [];
        
        // Primary chat ID
        $primaryChatId = config('services.telegram.chat_id');
        if ($primaryChatId) {
            $chatIds[] = $primaryChatId;
        }

        // Additional chat IDs (up to 5)
        for ($i = 2; $i <= 5; $i++) {
            $chatId = config("services.telegram.chat_id_{$i}");
            if ($chatId) {
                $chatIds[] = $chatId;
            }
        }

        return $chatIds;
    }
} 