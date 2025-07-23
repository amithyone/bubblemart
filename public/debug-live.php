<?php
// Live Server Diagnostic Script
// Place this in your public directory and access via: https://www.bublemart.shop/debug-live.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔍 Bublemart Live Server Diagnostic</h1>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;background:#f5f5f5;} .success{color:green;} .error{color:red;} .warning{color:orange;} .info{color:blue;} pre{background:#fff;padding:10px;border:1px solid #ddd;overflow-x:auto;}</style>";

// 1. Basic PHP Info
echo "<h2>📋 PHP Information</h2>";
echo "<div class='info'>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Server Software: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "<br>";
echo "Document Root: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'Unknown') . "<br>";
echo "Script Path: " . __FILE__ . "<br>";
echo "</div>";

// 2. Check Laravel Files
echo "<h2>📁 Laravel Files Check</h2>";
$laravelFiles = [
    '../vendor/autoload.php' => 'Composer Autoloader',
    '../bootstrap/app.php' => 'Laravel Bootstrap',
    '../.env' => 'Environment File',
    '../storage/logs/laravel.log' => 'Laravel Log File',
    '../config/app.php' => 'App Config',
    '../routes/web.php' => 'Web Routes'
];

foreach ($laravelFiles as $file => $description) {
    if (file_exists($file)) {
        echo "<div class='success'>✅ $description: EXISTS</div>";
    } else {
        echo "<div class='error'>❌ $description: MISSING ($file)</div>";
    }
}

// 3. Check Directory Permissions
echo "<h2>🔐 Directory Permissions</h2>";
$directories = [
    '../storage' => 'Storage Directory',
    '../storage/logs' => 'Logs Directory',
    '../storage/framework' => 'Framework Directory',
    '../storage/framework/cache' => 'Cache Directory',
    '../storage/framework/sessions' => 'Sessions Directory',
    '../storage/framework/views' => 'Views Directory',
    '../bootstrap/cache' => 'Bootstrap Cache'
];

foreach ($directories as $dir => $description) {
    if (file_exists($dir)) {
        $writable = is_writable($dir);
        $readable = is_readable($dir);
        $status = $writable ? 'WRITABLE' : 'NOT WRITABLE';
        $color = $writable ? 'success' : 'error';
        echo "<div class='$color'>";
        echo ($writable ? '✅' : '❌') . " $description: $status";
        if (!$readable) echo " (NOT READABLE)";
        echo "</div>";
    } else {
        echo "<div class='error'>❌ $description: DOESN'T EXIST</div>";
    }
}

// 4. Check Environment Variables
echo "<h2>⚙️ Environment Check</h2>";
if (file_exists('../.env')) {
    echo "<div class='success'>✅ .env file exists</div>";
    $envContent = file_get_contents('../.env');
    $envLines = explode("\n", $envContent);
    
    $importantVars = ['APP_NAME', 'APP_ENV', 'APP_KEY', 'APP_DEBUG', 'APP_URL', 'DB_CONNECTION', 'DB_HOST', 'DB_DATABASE'];
    
    foreach ($envLines as $line) {
        $line = trim($line);
        if (empty($line) || strpos($line, '#') === 0) continue;
        
        foreach ($importantVars as $var) {
            if (strpos($line, $var . '=') === 0) {
                $value = substr($line, strlen($var) + 1);
                if ($var === 'APP_KEY' && !empty($value) && $value !== 'base64:') {
                    echo "<div class='success'>✅ $var: SET</div>";
                } elseif ($var === 'APP_KEY' && (empty($value) || $value === 'base64:')) {
                    echo "<div class='error'>❌ $var: NOT SET (needs php artisan key:generate)</div>";
                } elseif ($var === 'APP_DEBUG' && $value === 'true') {
                    echo "<div class='warning'>⚠️ $var: ENABLED (should be false in production)</div>";
                } else {
                    echo "<div class='info'>ℹ️ $var: $value</div>";
                }
                break;
            }
        }
    }
} else {
    echo "<div class='error'>❌ .env file missing - this is likely the main issue!</div>";
}

// 5. Try to Load Laravel
echo "<h2>🚀 Laravel Load Test</h2>";
try {
    if (file_exists('../vendor/autoload.php')) {
        require_once '../vendor/autoload.php';
        echo "<div class='success'>✅ Autoloader loaded successfully</div>";
        
        if (file_exists('../bootstrap/app.php')) {
            $app = require_once '../bootstrap/app.php';
            echo "<div class='success'>✅ Laravel app loaded successfully</div>";
            
            // Try to access the container
            try {
                $container = $app->make('Illuminate\Contracts\Container\Container');
                echo "<div class='success'>✅ Laravel container accessible</div>";
            } catch (Exception $e) {
                echo "<div class='error'>❌ Container error: " . $e->getMessage() . "</div>";
            }
        } else {
            echo "<div class='error'>❌ bootstrap/app.php not found</div>";
        }
    } else {
        echo "<div class='error'>❌ vendor/autoload.php not found - run 'composer install'</div>";
    }
} catch (Exception $e) {
    echo "<div class='error'>❌ Error loading Laravel: " . $e->getMessage() . "</div>";
}

// 6. Check Recent Laravel Logs
echo "<h2>📝 Recent Laravel Logs</h2>";
$logFile = '../storage/logs/laravel.log';
if (file_exists($logFile)) {
    $logs = file_get_contents($logFile);
    $recentLogs = array_slice(explode("\n", $logs), -30);
    echo "<pre>" . implode("\n", $recentLogs) . "</pre>";
} else {
    echo "<div class='error'>❌ Laravel log file not found</div>";
}

// 7. Check PHP Extensions
echo "<h2>🔧 PHP Extensions</h2>";
$requiredExtensions = ['bcmath', 'ctype', 'json', 'mbstring', 'openssl', 'pdo', 'tokenizer', 'xml', 'curl', 'gd'];
foreach ($requiredExtensions as $ext) {
    if (extension_loaded($ext)) {
        echo "<div class='success'>✅ $ext extension loaded</div>";
    } else {
        echo "<div class='error'>❌ $ext extension missing</div>";
    }
}

// 8. Database Connection Test
echo "<h2>🗄️ Database Connection Test</h2>";
if (file_exists('../.env')) {
    try {
        require_once '../vendor/autoload.php';
        $app = require_once '../bootstrap/app.php';
        
        // Set up database connection
        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
        
        try {
            DB::connection()->getPdo();
            echo "<div class='success'>✅ Database connection successful</div>";
        } catch (Exception $e) {
            echo "<div class='error'>❌ Database connection failed: " . $e->getMessage() . "</div>";
        }
    } catch (Exception $e) {
        echo "<div class='error'>❌ Could not test database: " . $e->getMessage() . "</div>";
    }
} else {
    echo "<div class='error'>❌ Cannot test database without .env file</div>";
}

echo "<hr>";
echo "<h2>🔧 Quick Fixes</h2>";
echo "<div class='info'>";
echo "<strong>If you see missing files or permissions issues:</strong><br>";
echo "1. Upload all files from your local project<br>";
echo "2. Run: <code>composer install --optimize-autoloader --no-dev</code><br>";
echo "3. Run: <code>php artisan key:generate</code><br>";
echo "4. Run: <code>chmod -R 755 storage/ bootstrap/cache/</code><br>";
echo "5. Run: <code>php artisan config:clear && php artisan cache:clear</code><br>";
echo "</div>";

echo "<p><strong>⚠️ Security Note:</strong> Remove this file after debugging!</p>";
?> 