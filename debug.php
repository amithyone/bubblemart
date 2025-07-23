<?php
// Debug script for live server - place this in your public directory
// Access via: https://www.bublemart.shop/debug.php

echo "<h1>Bublemart Debug Information</h1>";

// Check PHP version
echo "<h2>PHP Information</h2>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' . "<br>";

// Check if Laravel files exist
echo "<h2>Laravel Files Check</h2>";
$laravelFiles = [
    '../vendor/autoload.php',
    '../bootstrap/app.php',
    '../.env',
    '../storage/logs/laravel.log'
];

foreach ($laravelFiles as $file) {
    echo "$file: " . (file_exists($file) ? "✅ EXISTS" : "❌ MISSING") . "<br>";
}

// Check directory permissions
echo "<h2>Directory Permissions</h2>";
$directories = [
    '../storage',
    '../storage/logs',
    '../storage/framework',
    '../storage/framework/cache',
    '../storage/framework/sessions',
    '../storage/framework/views',
    '../bootstrap/cache'
];

foreach ($directories as $dir) {
    if (file_exists($dir)) {
        echo "$dir: " . (is_writable($dir) ? "✅ WRITABLE" : "❌ NOT WRITABLE") . "<br>";
    } else {
        echo "$dir: ❌ DOESN'T EXIST<br>";
    }
}

// Check for recent errors
echo "<h2>Recent Laravel Logs</h2>";
$logFile = '../storage/logs/laravel.log';
if (file_exists($logFile)) {
    $logs = file_get_contents($logFile);
    $recentLogs = array_slice(explode("\n", $logs), -20);
    echo "<pre>" . implode("\n", $recentLogs) . "</pre>";
} else {
    echo "❌ Laravel log file not found<br>";
}

// Check environment variables
echo "<h2>Environment Check</h2>";
if (file_exists('../.env')) {
    echo "✅ .env file exists<br>";
    $envContent = file_get_contents('../.env');
    $envLines = explode("\n", $envContent);
    foreach ($envLines as $line) {
        if (strpos($line, 'APP_DEBUG') !== false) {
            echo "APP_DEBUG: $line<br>";
        }
        if (strpos($line, 'APP_ENV') !== false) {
            echo "APP_ENV: $line<br>";
        }
    }
} else {
    echo "❌ .env file missing<br>";
}

// Check if we can load Laravel
echo "<h2>Laravel Load Test</h2>";
try {
    if (file_exists('../vendor/autoload.php')) {
        require_once '../vendor/autoload.php';
        echo "✅ Autoloader loaded successfully<br>";
        
        if (file_exists('../bootstrap/app.php')) {
            $app = require_once '../bootstrap/app.php';
            echo "✅ Laravel app loaded successfully<br>";
        } else {
            echo "❌ bootstrap/app.php not found<br>";
        }
    } else {
        echo "❌ vendor/autoload.php not found<br>";
    }
} catch (Exception $e) {
    echo "❌ Error loading Laravel: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<p><strong>Note:</strong> Remove this file after debugging for security reasons.</p>";
?> 