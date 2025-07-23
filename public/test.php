<?php
// Simple PHP test file
// Access via: https://www.bublemart.shop/test.php

echo "<h1>✅ PHP is Working!</h1>";
echo "<p>If you can see this, PHP is functioning correctly on your server.</p>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Current Time: " . date('Y-m-d H:i:s') . "</p>";
echo "<p>Server Software: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "</p>";

// Test file operations
echo "<h2>File System Test</h2>";
$testFile = 'test_write.txt';
if (file_put_contents($testFile, 'Test content ' . date('Y-m-d H:i:s'))) {
    echo "<p style='color:green'>✅ File write test: PASSED</p>";
    unlink($testFile); // Clean up
} else {
    echo "<p style='color:red'>❌ File write test: FAILED</p>";
}

// Test directory listing
echo "<h2>Directory Contents</h2>";
$files = scandir('.');
echo "<ul>";
foreach ($files as $file) {
    if ($file !== '.' && $file !== '..') {
        echo "<li>$file</li>";
    }
}
echo "</ul>";

echo "<hr>";
echo "<p><a href='debug-live.php'>🔍 Run Full Diagnostic</a></p>";
?> 