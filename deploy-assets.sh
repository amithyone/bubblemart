#!/bin/bash

# Bublemart Assets Deployment Script
# This script helps deploy template assets to your live server

echo "🚀 Bublemart Assets Deployment Script"
echo "======================================"

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    echo "❌ Error: Please run this script from the Laravel project root directory"
    exit 1
fi

echo "✅ Laravel project detected"

# Check if assets exist
if [ ! -d "public/template-assets" ]; then
    echo "❌ Error: template-assets directory not found in public/"
    exit 1
fi

echo "✅ Template assets found"

# Create deployment package
echo "📦 Creating deployment package..."
cd public
tar -czf ../complete-assets.tar.gz template-assets/
cd ..

echo "✅ Deployment package created: complete-assets.tar.gz"
echo ""
echo "📋 Next Steps:"
echo "=============="
echo "1. Upload 'complete-assets.tar.gz' to your live server"
echo "2. Extract it in your live server's public/ directory:"
echo "   tar -xzf complete-assets.tar.gz -C public/"
echo "3. Set proper permissions:"
echo "   chmod -R 755 public/template-assets/"
echo "4. Clear Laravel cache:"
echo "   php artisan cache:clear"
echo "   php artisan config:clear"
echo "   php artisan view:clear"
echo "5. Create storage link:"
echo "   php artisan storage:link"
echo ""
echo "🔗 Test URLs after deployment:"
echo "https://yourdomain.com/template-assets/css/app.css"
echo "https://yourdomain.com/template-assets/js/app.js"
echo "https://yourdomain.com/template-assets/img/favicon.png"
echo ""
echo "✨ Deployment package ready!" 