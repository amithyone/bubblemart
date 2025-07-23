# Live Server Fixes for Bublemart

## Quick Fixes for HTTP 500 Error

### 1. Upload the Debug Script
- Upload `debug.php` to your public directory
- Access: `https://www.bublemart.shop/debug.php`
- Check what's missing or misconfigured

### 2. Environment File (.env)
Make sure your `.env` file on the live server has:
```env
APP_NAME=Bublemart
APP_ENV=production
APP_KEY=base64:your-app-key-here
APP_DEBUG=false
APP_URL=https://www.bublemart.shop

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

### 3. Generate Application Key
If you don't have an APP_KEY, run:
```bash
php artisan key:generate
```

### 4. Set Proper Permissions
```bash
# Make storage directories writable
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/

# Set proper ownership (replace 'www-data' with your web server user)
chown -R www-data:www-data storage/
chown -R www-data:www-data bootstrap/cache/
```

### 5. Install Dependencies
```bash
composer install --optimize-autoloader --no-dev
npm install --production
npm run build
```

### 6. Run Database Migrations
```bash
php artisan migrate --force
php artisan db:seed --force
```

### 7. Clear All Caches
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan optimize:clear
```

### 8. Create Storage Link
```bash
php artisan storage:link
```

### 9. Check PHP Extensions
Make sure these PHP extensions are installed:
- BCMath
- Ctype
- JSON
- Mbstring
- OpenSSL
- PDO
- Tokenizer
- XML
- cURL
- GD
- MySQL/MySQLi

### 10. Check Server Requirements
- PHP >= 8.1
- MySQL >= 5.7 or PostgreSQL >= 10
- Composer
- Node.js & NPM (for asset compilation)

## Common Issues & Solutions

### Issue: "Class not found" errors
**Solution**: Run `composer dump-autoload`

### Issue: Database connection errors
**Solution**: Check database credentials in `.env` file

### Issue: Permission denied errors
**Solution**: Fix file permissions (see step 4 above)

### Issue: Missing vendor directory
**Solution**: Run `composer install`

### Issue: Assets not loading
**Solution**: Run `npm run build` and check if assets are in public directory

### Issue: Session errors
**Solution**: Check session configuration and storage permissions

## Testing Steps

1. Upload `debug.php` to public directory
2. Visit `https://www.bublemart.shop/debug.php`
3. Check all the diagnostic information
4. Fix any issues found
5. Remove `debug.php` for security
6. Test your main site

## Emergency Fixes

If nothing else works:

1. **Enable Debug Mode** (temporarily):
   ```env
   APP_DEBUG=true
   ```
   This will show detailed error messages.

2. **Check Error Logs**:
   - Laravel logs: `storage/logs/laravel.log`
   - Server logs: Check your hosting provider's error logs

3. **Fallback to Basic Setup**:
   - Remove all custom routes temporarily
   - Test with just the basic Laravel welcome page

## Security Note
- Remove `debug.php` after debugging
- Set `APP_DEBUG=false` in production
- Never commit `.env` files to version control 