<?php

/**
 * Telegram Setup Script for Bublemart
 * 
 * This script helps you set up Telegram notifications for your Bublemart admin panel.
 * Run this script to add Telegram configuration to your .env file.
 */

echo "🔧 BUBLEMART - Telegram Notification Setup\n";
echo "==========================================\n\n";

// Check if .env file exists
if (!file_exists('.env')) {
    echo "❌ Error: .env file not found!\n";
    echo "Please make sure you're running this script from the project root directory.\n";
    exit(1);
}

echo "📱 This script will help you set up Telegram notifications for your admin panel.\n\n";

// Get bot token
echo "Step 1: Telegram Bot Token\n";
echo "---------------------------\n";
echo "1. Create a new bot with @BotFather on Telegram\n";
echo "2. Get your bot token (it looks like: 123456789:ABCdefGHIjklMNOpqrsTUVwxyz)\n";
echo "3. Enter your bot token below:\n\n";

$botToken = readline("Bot Token: ");

if (empty($botToken)) {
    echo "❌ Bot token is required!\n";
    exit(1);
}

// Get chat ID
echo "\nStep 2: Chat ID\n";
echo "---------------\n";
echo "1. Send a message to your bot\n";
echo "2. Visit: https://api.telegram.org/bot{$botToken}/getUpdates\n";
echo "3. Find your chat_id in the response\n";
echo "4. Enter your chat ID below:\n\n";

$chatId = readline("Chat ID: ");

if (empty($chatId)) {
    echo "❌ Chat ID is required!\n";
    exit(1);
}

// Read current .env file
$envContent = file_get_contents('.env');

// Check if Telegram config already exists
if (strpos($envContent, 'TELEGRAM_BOT_TOKEN') !== false) {
    echo "\n⚠️  Telegram configuration already exists in .env file.\n";
    $overwrite = strtolower(readline("Do you want to overwrite it? (y/n): "));
    
    if ($overwrite !== 'y' && $overwrite !== 'yes') {
        echo "Setup cancelled.\n";
        exit(0);
    }
    
    // Remove existing Telegram config
    $envContent = preg_replace('/# Telegram Configuration.*?# End Telegram Configuration\n/s', '', $envContent);
}

// Add Telegram configuration
$telegramConfig = "\n# Telegram Configuration\n";
$telegramConfig .= "# Add your Telegram bot token and chat IDs below\n";
$telegramConfig .= "# To get a chat ID: Send a message to your bot, then visit:\n";
$telegramConfig .= "# https://api.telegram.org/bot{$botToken}/getUpdates\n\n";
$telegramConfig .= "TELEGRAM_BOT_TOKEN={$botToken}\n";
$telegramConfig .= "TELEGRAM_CHAT_ID={$chatId}\n";
$telegramConfig .= "TELEGRAM_CHAT_ID_2=\n";
$telegramConfig .= "TELEGRAM_CHAT_ID_3=\n";
$telegramConfig .= "TELEGRAM_CHAT_ID_4=\n";
$telegramConfig .= "TELEGRAM_CHAT_ID_5=\n";
$telegramConfig .= "# End Telegram Configuration\n";

// Add to .env file
file_put_contents('.env', $envContent . $telegramConfig);

echo "\n✅ Telegram configuration added to .env file!\n\n";

echo "📋 Configuration Summary:\n";
echo "------------------------\n";
echo "Bot Token: {$botToken}\n";
echo "Primary Chat ID: {$chatId}\n";
echo "Additional Chat IDs: 4 slots available\n\n";

echo "🔧 Next Steps:\n";
echo "--------------\n";
echo "1. Clear config cache: php artisan config:clear\n";
echo "2. Test notifications: php artisan telegram:test\n";
echo "3. Create admin user: php artisan admin:create\n";
echo "4. Access admin panel: " . (isset($_SERVER['HTTP_HOST']) ? "http://{$_SERVER['HTTP_HOST']}/admin" : "http://localhost:8006/admin") . "\n\n";

echo "📱 Additional Chat IDs:\n";
echo "----------------------\n";
echo "You can add up to 4 additional chat IDs for multiple recipients:\n";
echo "- TELEGRAM_CHAT_ID_2= (second recipient)\n";
echo "- TELEGRAM_CHAT_ID_3= (third recipient)\n";
echo "- TELEGRAM_CHAT_ID_4= (fourth recipient)\n";
echo "- TELEGRAM_CHAT_ID_5= (fifth recipient)\n\n";

echo "🎉 Setup complete! Your admin panel will now send Telegram notifications for:\n";
echo "• New orders placed\n";
echo "• Order status updates\n";
echo "• Shipping updates\n\n";

echo "For help, visit: https://core.telegram.org/bots/api\n"; 