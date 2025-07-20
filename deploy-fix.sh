#!/bin/bash

echo "=== Bublemart Asset Path Fix Deployment Script ==="
echo ""

# Step 1: Update all asset paths in blade templates
echo "1. Updating asset paths in blade templates..."
find resources/views -name "*.blade.php" -exec sed -i "s|asset('template-assets|asset('public/template-assets|g" {} \;
echo "   ✓ Asset paths updated"

# Step 2: Clear Laravel cache
echo "2. Clearing Laravel cache..."
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
echo "   ✓ Cache cleared"

# Step 3: Create storage link if it doesn't exist
echo "3. Creating storage link..."
php artisan storage:link
echo "   ✓ Storage link created"

# Step 4: Set proper permissions
echo "4. Setting permissions..."
chmod -R 755 public/
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
echo "   ✓ Permissions set"

# Step 5: Verify assets exist
echo "5. Verifying assets..."
if [ -f "public/template-assets/css/app.css" ]; then
    echo "   ✓ CSS file exists"
else
    echo "   ✗ CSS file missing!"
fi

if [ -f "public/template-assets/js/app.js" ]; then
    echo "   ✓ JS file exists"
else
    echo "   ✗ JS file missing!"
fi

echo ""
echo "=== Deployment Complete ==="
echo ""
echo "Next steps:"
echo "1. Upload all files to your server"
echo "2. Make sure your domain points to the root directory (not /public)"
echo "3. Test the website at your domain"
echo "4. If assets still don't load, check your server's .htaccess configuration"
echo ""
echo "If you still have issues, try accessing:"
echo "  - https://yourdomain.com/public/template-assets/css/app.css"
echo "  - https://yourdomain.com/public/template-assets/js/app.js" 