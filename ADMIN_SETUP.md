# Bublemart Admin Panel Setup Guide

This guide will help you set up the complete admin panel for Bublemart with Telegram notifications.

## 🚀 Quick Start

### 1. Create Admin User

```bash
php artisan admin:create admin@bublemart.com your_password
```

### 2. Set Up Telegram Notifications

```bash
php setup_telegram.php
```

### 3. Access Admin Panel

Visit: `http://localhost:8006/admin`

## 📋 Admin Features

### ✅ Product Management
- Add/Edit/Delete products
- Manage product categories
- Upload product images
- Set pricing and stock levels
- Toggle product status

### ✅ Category Management
- Create and manage product categories
- Organize products by category
- Toggle category visibility

### ✅ Order Management
- View all orders
- Update order status
- Add tracking information
- Cancel orders
- Mark orders as delivered

### ✅ Shipping Management
- Track pending shipments
- Mark orders as shipped
- Add tracking numbers
- Bulk shipping updates
- Shipping analytics

### ✅ User Management
- View all users
- Manage user wallets
- Add/deduct wallet funds
- View user orders

### ✅ Telegram Notifications
- New order notifications
- Order status updates
- Shipping updates
- Multiple recipient support

## 🔧 Configuration

### Environment Variables

Add these to your `.env` file:

```env
# Telegram Configuration
TELEGRAM_BOT_TOKEN=your_bot_token_here
TELEGRAM_CHAT_ID=your_chat_id_here
TELEGRAM_CHAT_ID_2=second_chat_id_here
TELEGRAM_CHAT_ID_3=third_chat_id_here
TELEGRAM_CHAT_ID_4=fourth_chat_id_here
TELEGRAM_CHAT_ID_5=fifth_chat_id_here
```

### Setting Up Telegram Bot

1. **Create a Bot:**
   - Message @BotFather on Telegram
   - Send `/newbot`
   - Follow the instructions
   - Save your bot token

2. **Get Chat ID:**
   - Send a message to your bot
   - Visit: `https://api.telegram.org/bot{YOUR_BOT_TOKEN}/getUpdates`
   - Find your `chat_id` in the response

3. **Test Notifications:**
   ```bash
   php artisan telegram:test "Hello from Bublemart!"
   ```

## 📱 Telegram Notifications

### What Triggers Notifications

1. **New Order Placed**
   - Customer places an order
   - Admin receives detailed order info
   - Includes customer details and items

2. **Order Status Updates**
   - Order status changes (pending → processing → shipped → delivered)
   - Admin receives status change notification
   - Includes tracking information if available

3. **Shipping Updates**
   - Orders marked as shipped
   - Orders marked as delivered
   - Includes tracking numbers and carrier info

### Notification Format

```
🛍️ NEW ORDER PLACED!

📋 Order Details:
• Order #: ORD123456
• Customer: John Doe
• Email: john@example.com
• Phone: +1234567890
• Total: ₦15,000.00
• Payment: Wallet
• Status: Pending

📦 Items:
• Gift Box (x1) - ₦15,000.00

📍 Delivery Address:
• John Doe
• 123 Main Street
• Lagos, Lagos 100001
• Phone: +1234567890

⏰ Order Time: Jul 13, 2025 5:30 PM

🔗 Admin Link: http://localhost:8006/admin/orders/1
```

## 🛠️ Admin Commands

### Create Admin User
```bash
php artisan admin:create [email] [password]
```

### Test Telegram Notifications
```bash
php artisan telegram:test [message]
```

### Clear Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

## 📊 Admin Dashboard

### Main Dashboard
- Total users, products, orders, categories
- Recent activities
- Monthly revenue chart
- Top selling products
- Wallet transaction summary

### Shipping Dashboard
- Pending shipments
- Shipped today
- Delivered today
- Total shipping costs
- Recent shipments

### Analytics
- Order analytics
- Revenue reports
- User statistics
- Product performance

## 🔐 Security

### Admin Middleware
- Only users with `is_admin = true` can access admin panel
- All admin routes are protected
- CSRF protection enabled

### User Permissions
- Regular users cannot access admin areas
- Admin users have full access to all features
- Secure authentication required

## 🎨 Customization

### Admin Layout
- Dark theme with modern design
- Responsive layout
- Bootstrap 5 components
- Font Awesome icons

### Branding
- Customizable logo
- Brand colors
- Company information
- Contact details

## 🚨 Troubleshooting

### Telegram Notifications Not Working

1. **Check Bot Token:**
   ```bash
   php artisan tinker
   echo config('services.telegram.bot_token');
   ```

2. **Check Chat ID:**
   ```bash
   php artisan tinker
   echo config('services.telegram.chat_id');
   ```

3. **Test Connection:**
   ```bash
   php artisan telegram:test
   ```

4. **Check Logs:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

### Admin Access Issues

1. **Check User Admin Status:**
   ```bash
   php artisan tinker
   $user = App\Models\User::where('email', 'admin@bublemart.com')->first();
   echo $user->is_admin ? 'Admin' : 'Not Admin';
   ```

2. **Clear Cache:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

### Image Upload Issues

1. **Check Storage Link:**
   ```bash
   php artisan storage:link
   ```

2. **Check Permissions:**
   ```bash
   chmod -R 775 storage/
   chmod -R 775 public/storage/
   ```

## 📞 Support

For additional help:

1. Check the Laravel logs: `storage/logs/laravel.log`
2. Review the Telegram Bot API documentation
3. Ensure all environment variables are set correctly
4. Verify database migrations are up to date

## 🔄 Updates

To update the admin panel:

1. Pull latest changes
2. Run migrations: `php artisan migrate`
3. Clear cache: `php artisan config:clear`
4. Test functionality

---

**Happy Administering! 🎉** 