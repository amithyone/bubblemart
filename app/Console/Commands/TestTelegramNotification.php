<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Notifications\TelegramNotification;

class TestTelegramNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:test {message?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Telegram notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $message = $this->argument('message') ?? '🧪 Test message from Bublemart Admin Panel!';

        $this->info('Testing Telegram notification...');
        $this->info("Message: {$message}");

        try {
            $notification = new TelegramNotification($message, null, true);
            $notification->toTelegram(null);
            
            $this->info('✅ Telegram notification sent successfully!');
            $this->info('Check your Telegram bot for the message.');
        } catch (\Exception $e) {
            $this->error('❌ Failed to send Telegram notification: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
} 