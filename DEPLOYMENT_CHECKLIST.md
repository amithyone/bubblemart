# Laravel Deployment Checklist for Shared Hosting (cPanel)

## Pre-Deployment Setup

### 1. File Structure for Shared Hosting
Your hosting structure should look like this:
```
/home/yourusername/
├── public_html/          # Web root (this is where your domain points)
│   ├── index.php         # Laravel's public/index.php
│   ├── .htaccess         # Laravel's public/.htaccess
│   ├── css/              # All CSS files
│   ├── js/               # All JS files
│   ├── template-assets/  # Template assets
│   ├── storage/          # Storage symlink (IMPORTANT!)
│   └── build/            # Compiled assets
└── bublemart/            # Laravel app (outside public_html for security)
    ├── app/
    ├── bootstrap/
    ├── config/
    ├── database/
    ├── resources/
    ├── routes/
    ├── storage/
    └── vendor/
```

### 2. Upload Instructions

#### Step 1: Upload Laravel App
- Upload the entire Laravel project to your hosting account
- Place it OUTSIDE of public_html (e.g., in `/home/yourusername/bublemart/`)

#### Step 2: Upload Public Files
- Copy ALL contents from the `public/` folder to `public_html/`
- This includes: index.php, .htaccess, css/, js/, template-assets/, etc.

#### Step 3: Update index.php Paths
Edit `public_html/index.php` and update these lines:
```php
// Change from:
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

// To:
require __DIR__.'/../bublemart/vendor/autoload.php';
$app = require_once __DIR__.'/../bublemart/bootstrap/app.php';
```

### 3. Storage Setup (CRITICAL FOR IMAGES)

#### Step 4: Create Storage Symlink
After uploading, you need to create the storage symlink. In your hosting control panel:

**Option A: Using SSH (if available)**
```bash
cd /home/yourusername/public_html
ln -s ../bublemart/storage/app/public storage
```

**Option B: Using File Manager**
1. Go to your hosting file manager
2. Navigate to `public_html/`
3. Create a symbolic link:
   - Source: `../bublemart/storage/app/public`
   - Link name: `storage`

**Option C: Manual Copy (if symlinks not allowed)**
1. Copy the entire `storage/app/public/` folder to `public_html/storage/`
2. Update file permissions: `chmod -R 755 public_html/storage/`

#### Step 5: Verify Storage Setup
Test that your storage is accessible by visiting:
`https://yourdomain.com/storage/products/image-1.jpg`

### 4. Environment Configuration

#### Step 6: Set Environment
- Copy `.env.example` to `.env` in your Laravel root directory
- Update the following in `.env`:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
DB_HOST=localhost
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

#### Step 7: Generate Application Key
```bash
php artisan key:generate
```

### 5. Database Setup

#### Step 8: Run Migrations
```bash
php artisan migrate
```

#### Step 9: Seed Database (if needed)
```bash
php artisan db:seed
```

### 6. File Permissions

#### Step 10: Set Permissions
```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod -R 755 public_html/storage/  # If using manual copy method
```

### 7. Final Steps

#### Step 11: Clear Caches
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

#### Step 12: Test Your Application
- Visit your domain
- Check that all assets load (CSS, JS, images)
- Test product images specifically
- Test all functionality

## Troubleshooting

### Assets Not Loading (404 Errors)
- Ensure all files from `public/` are in `public_html/`
- Check that `index.php` paths are correct
- Verify file permissions

### Product Images Not Showing
- **Most common issue**: Storage symlink not created
- Check if `public_html/storage/` exists and points to the correct location
- Verify file permissions on storage folder
- Test direct access: `yourdomain.com/storage/products/image-1.jpg`

### Database Connection Issues
- Check database credentials in `.env`
- Ensure database exists and user has proper permissions

### 500 Server Errors
- Check error logs in cPanel
- Verify file permissions
- Ensure all required PHP extensions are enabled

## Security Notes

- Keep Laravel app files OUTSIDE of public_html
- Only files that need to be web-accessible should be in public_html
- Set proper file permissions
- Use HTTPS in production
- Keep `.env` file secure and outside public_html

## Performance Tips

- Enable OPcache if available
- Use CDN for static assets if possible
- Optimize images
- Enable compression in .htaccess 