<?php
/**
 * Storage Fix Script for Shared Hosting
 * Upload this to public_html/ and run it to fix storage issues
 */

echo "<h1>Storage Fix for Bublemart</h1>";

// Check current directory
echo "<h2>1. Current Directory</h2>";
echo "Current directory: " . __DIR__ . "<br>";

// Check if storage directory exists
echo "<h2>2. Storage Directory Check</h2>";
$storagePath = __DIR__ . '/storage';
if (is_dir($storagePath)) {
    echo "✅ Storage directory exists<br>";
    echo "Storage path: $storagePath<br>";
} else {
    echo "❌ Storage directory does not exist<br>";
}

// Check if storage is a symlink
echo "<h2>3. Storage Symlink Check</h2>";
if (is_link($storagePath)) {
    echo "✅ Storage is a symlink<br>";
    echo "Symlink target: " . readlink($storagePath) . "<br>";
} else {
    echo "❌ Storage is not a symlink<br>";
}

// Check Laravel app directory
echo "<h2>4. Laravel App Directory Check</h2>";
$laravelPath = __DIR__ . '/../bublemart';
if (is_dir($laravelPath)) {
    echo "✅ Laravel app directory exists<br>";
    echo "Laravel path: $laravelPath<br>";
} else {
    echo "❌ Laravel app directory not found<br>";
}

// Check storage/app/public directory
echo "<h2>5. Storage App Public Directory</h2>";
$storageAppPublic = $laravelPath . '/storage/app/public';
if (is_dir($storageAppPublic)) {
    echo "✅ Storage app public directory exists<br>";
    echo "Storage app public: $storageAppPublic<br>";
} else {
    echo "❌ Storage app public directory not found<br>";
}

// Check product images
echo "<h2>6. Product Images Check</h2>";
$productsDir = $storageAppPublic . '/products';
if (is_dir($productsDir)) {
    echo "✅ Products directory exists<br>";
    $files = scandir($productsDir);
    $imageFiles = array_filter($files, function($file) {
        return in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']);
    });
    echo "Found " . count($imageFiles) . " product images<br>";
} else {
    echo "❌ Products directory not found<br>";
}

// Provide solutions
echo "<h2>7. Solutions</h2>";
echo "<h3>Option A: Create Symlink (Recommended)</h3>";
echo "<p>If you have SSH access, run these commands:</p>";
echo "<code>";
echo "cd " . __DIR__ . "<br>";
echo "rm -rf storage<br>";
echo "ln -s ../bublemart/storage/app/public storage<br>";
echo "</code>";

echo "<h3>Option B: Manual Copy</h3>";
echo "<p>If symlinks don't work, manually copy the storage folder:</p>";
echo "<code>";
echo "cp -r " . $laravelPath . "/storage/app/public " . __DIR__ . "/storage<br>";
echo "chmod -R 755 " . __DIR__ . "/storage<br>";
echo "</code>";

echo "<h3>Option C: Using File Manager</h3>";
echo "<ol>";
echo "<li>Go to your hosting file manager</li>";
echo "<li>Navigate to public_html/</li>";
echo "<li>Delete the existing storage folder (if it exists)</li>";
echo "<li>Create a symbolic link:</li>";
echo "<ul>";
echo "<li>Source: ../bublemart/storage/app/public</li>";
echo "<li>Link name: storage</li>";
echo "</ul>";
echo "</ol>";

// Test file access
echo "<h2>8. Test File Access</h2>";
$testFile = $storageAppPublic . '/products/image-1.jpg';
if (file_exists($testFile)) {
    echo "✅ Test file exists: image-1.jpg<br>";
    echo "File size: " . filesize($testFile) . " bytes<br>";
    
    // Try to copy it to public_html for testing
    $copyPath = __DIR__ . '/test-image-1.jpg';
    if (copy($testFile, $copyPath)) {
        echo "✅ Successfully copied test file to public_html<br>";
        echo "Test URL: <a href='test-image-1.jpg' target='_blank'>test-image-1.jpg</a><br>";
    } else {
        echo "❌ Failed to copy test file<br>";
    }
} else {
    echo "❌ Test file not found: image-1.jpg<br>";
}

echo "<hr>";
echo "<p><strong>After fixing storage, delete this file for security!</strong></p>";
?>
