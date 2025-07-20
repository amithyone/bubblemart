<?php
/**
 * Storage Test Script
 * Upload this to public_html/ and visit: yourdomain.com/test-storage.php
 * This will help verify if storage is properly configured
 */

echo "<h1>Storage Test Results</h1>";

// Test 1: Check if storage directory exists
echo "<h2>1. Storage Directory Check</h2>";
if (is_dir(__DIR__ . '/storage')) {
    echo "✅ Storage directory exists<br>";
} else {
    echo "❌ Storage directory does not exist<br>";
}

// Test 2: Check if storage is a symlink
echo "<h2>2. Storage Symlink Check</h2>";
if (is_link(__DIR__ . '/storage')) {
    echo "✅ Storage is a symlink<br>";
    echo "Symlink target: " . readlink(__DIR__ . '/storage') . "<br>";
} else {
    echo "❌ Storage is not a symlink<br>";
}

// Test 3: Check if products directory exists
echo "<h2>3. Products Directory Check</h2>";
if (is_dir(__DIR__ . '/storage/products')) {
    echo "✅ Products directory exists<br>";
} else {
    echo "❌ Products directory does not exist<br>";
}

// Test 4: List product images
echo "<h2>4. Product Images</h2>";
$productsDir = __DIR__ . '/storage/products';
if (is_dir($productsDir)) {
    $files = scandir($productsDir);
    $imageFiles = array_filter($files, function($file) {
        return in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']);
    });
    
    if (count($imageFiles) > 0) {
        echo "✅ Found " . count($imageFiles) . " product images:<br>";
        foreach (array_slice($imageFiles, 0, 5) as $file) {
            echo "- $file<br>";
        }
        if (count($imageFiles) > 5) {
            echo "- ... and " . (count($imageFiles) - 5) . " more<br>";
        }
    } else {
        echo "❌ No product images found<br>";
    }
} else {
    echo "❌ Products directory not accessible<br>";
}

// Test 5: Test direct file access
echo "<h2>5. Direct File Access Test</h2>";
$testFile = __DIR__ . '/storage/products/image-1.jpg';
if (file_exists($testFile)) {
    echo "✅ Test file exists: image-1.jpg<br>";
    echo "File size: " . filesize($testFile) . " bytes<br>";
} else {
    echo "❌ Test file not found: image-1.jpg<br>";
}

// Test 6: Check file permissions
echo "<h2>6. File Permissions</h2>";
$storageDir = __DIR__ . '/storage';
if (is_dir($storageDir)) {
    echo "Storage directory permissions: " . substr(sprintf('%o', fileperms($storageDir)), -4) . "<br>";
    echo "Storage directory readable: " . (is_readable($storageDir) ? "✅ Yes" : "❌ No") . "<br>";
}

echo "<hr>";
echo "<p><strong>If you see ❌ errors above, you need to fix your storage setup.</strong></p>";
echo "<p>Common solutions:</p>";
echo "<ul>";
echo "<li>Create storage symlink: <code>ln -s ../bublemart/storage/app/public storage</code></li>";
echo "<li>Or copy storage folder manually to public_html/storage/</li>";
echo "<li>Check file permissions</li>";
echo "</ul>";

// Clean up - remove this file after testing
echo "<p><em>Remember to delete this test file after testing!</em></p>";
?> 