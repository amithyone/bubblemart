# Bublemart Deployment Guide

## CSS/Asset Issues on Live Server

If you're experiencing broken CSS on your live server, follow these steps:

### 1. Build Assets for Production
```bash
npm run build
```

### 2. Upload the Entire Project
Make sure to upload the `public/build/` directory along with your project.

### 3. Set Environment Variables
In your `.env` file on the live server:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

### 4. Clear Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### 5. Set Proper Permissions
```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod -R 755 public/build/
```

### 6. Document Root Configuration
Point your domain to the main project folder (not the public subfolder):
```
Document Root: /path/to/your/bublemart
```

### 7. Webhook URL
Your XtraPay webhook URL will be:
```
https://yourdomain.com/api/ipn/xtrapay
```

### 8. Troubleshooting CSS Issues

If CSS is still broken:

1. **Check Asset Paths**: Ensure the `public/build/` directory is accessible
2. **Clear Browser Cache**: Hard refresh (Ctrl+F5 or Cmd+Shift+R)
3. **Check File Permissions**: Make sure web server can read the build files
4. **Verify .htaccess**: Ensure URL rewriting is working

### 9. Alternative Asset Loading

If you continue having issues, you can manually specify the asset paths in your layouts:

**For Main Layout (app.blade.php):**
```html
<link rel="stylesheet" href="{{ asset('build/assets/app-DbaZCfaT.css') }}">
<script src="{{ asset('build/assets/app-BDAque31.js') }}" defer></script>
```

**For Admin Layout (admin.blade.php):**
```html
<link rel="stylesheet" href="{{ asset('build/assets/app-NS0_ynA5.css') }}">
<script src="{{ asset('build/assets/app-BDAque31.js') }}" defer></script>
```

### 10. File Structure After Deployment
```
yourdomain.com/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
│   ├── build/
│   │   ├── assets/
│   │   │   ├── app-DbaZCfaT.css
│   │   │   ├── app-NS0_ynA5.css
│   │   │   └── app-BDAque31.js
│   │   └── manifest.json
│   └── index.php
├── resources/
├── routes/
├── storage/
├── vendor/
├── .env
├── .htaccess
└── index.php
```

### 11. Common Issues and Solutions

**Issue**: CSS not loading
**Solution**: Check if `public/build/assets/` directory exists and is readable

**Issue**: 404 errors for assets
**Solution**: Ensure `.htaccess` is in the root directory and URL rewriting is enabled

**Issue**: Mixed content errors
**Solution**: Use HTTPS URLs in your `APP_URL` environment variable

**Issue**: Permission denied
**Solution**: Set proper file permissions (755 for directories, 644 for files) 