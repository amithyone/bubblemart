#!/bin/bash

echo "🚀 Bublemart Deployment Script"
echo "================================"

# Build assets
echo "📦 Building assets..."
npm run build

# Check if build was successful
if [ ! -d "public/build/assets" ]; then
    echo "❌ Build failed! Assets directory not found."
    exit 1
fi

echo "✅ Assets built successfully!"

# List built assets
echo "📁 Built assets:"
ls -la public/build/assets/

# Set permissions
echo "🔐 Setting permissions..."
chmod -R 755 public/build/
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/

echo "✅ Permissions set!"

# Clear Laravel caches
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

echo "✅ Caches cleared!"

echo ""
echo "🎉 Deployment preparation complete!"
echo ""
echo "📋 Next steps:"
echo "1. Upload the entire project to your server"
echo "2. Set APP_ENV=production in your .env file"
echo "3. Set APP_URL=https://yourdomain.com in your .env file"
echo "4. Run: php artisan migrate (if needed)"
echo "5. Your webhook URL: https://yourdomain.com/api/ipn/xtrapay"
echo ""
echo "🔧 If CSS is still broken:"
echo "- Check if public/build/ directory is uploaded"
echo "- Verify file permissions (755 for directories, 644 for files)"
echo "- Clear browser cache (Ctrl+F5)"
echo "- Check server error logs" 