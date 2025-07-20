<?php

$customizeDir = __DIR__ . '/resources/views/customize/';
$files = [
    'index.blade.php',
    'select-product.blade.php', 
    'select-type.blade.php',
    'receiver-info.blade.php',
    'form.blade.php',
    'checkout.blade.php'
];

foreach ($files as $file) {
    $filePath = $customizeDir . $file;
    if (file_exists($filePath)) {
        $content = file_get_contents($filePath);
        
        // Fix all malformed style attributes
        $content = preg_replace('/style="([^"]*)" style="([^"]*)"/', 'style="$1"', $content);
        $content = preg_replace('/style="([^"]*)" mb-([0-9]+)"/', 'style="$1" class="mb-$2"', $content);
        $content = preg_replace('/style="([^"]*)" class="([^"]*)"/', 'style="$1" class="$2"', $content);
        $content = preg_replace('/style="([^"]*)" h5"/', 'style="$1"', $content);
        $content = preg_replace('/style="([^"]*)" text-center"/', 'style="$1" class="text-center"', $content);
        
        // Fix missing quotes
        $content = preg_replace('/style="([^"]*)"([^>]*>)/', 'style="$1"$2', $content);
        
        // Remove duplicate style attributes
        $content = preg_replace('/style="([^"]*)" style="([^"]*)"/', 'style="$1"', $content);
        
        file_put_contents($filePath, $content);
        echo "Cleaned: $file\n";
    }
}

echo "All customize files cleaned up!\n";
?> 