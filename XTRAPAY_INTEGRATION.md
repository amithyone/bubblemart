# XtraPay Payment Integration

## Overview

This application integrates with XtraPay for processing bank transfers. The integration includes:

1. **Virtual Account Generation** - Creates temporary bank accounts for payments
2. **Payment Verification** - Checks payment status via API
3. **Webhook Processing** - Receives real-time payment notifications
4. **Order Management** - Automatically updates order status based on payment

## How It Works

### 1. Payment Flow

1. **User initiates payment** → Cart page selects XtraPay
2. **Virtual account generated** → XtraPay creates temporary bank account
3. **User transfers money** → To the provided bank account
4. **Payment verification** → System checks payment status
5. **Order confirmation** → Order status updated to "processing"

### 2. Payment Verification Methods

#### A. Manual Verification (User clicks "I've Made the Transfer")
- User clicks button to check payment status
- System calls XtraPay API to verify payment
- Order updated if payment confirmed

#### B. Webhook Notifications (Automatic)
- XtraPay sends webhook when payment is received
- System automatically updates order status
- No user action required

## Configuration

### Environment Variables

Add these to your `.env` file:

```env
# XtraPay API Configuration
XTRAPAY_ACCESS_KEY=your_xtrapay_access_key_here
XTRAPAY_WEBHOOK_SECRET=your_webhook_secret_here

# Optional: Demo mode (when API keys not set)
# System will use demo mode automatically if keys are missing
```

### Webhook URL

Configure this webhook URL in your XtraPay dashboard:

```
https://yourdomain.com/api/webhook/xtrapay
```

## API Endpoints

### 1. Generate Virtual Account
```
POST /cart/generate-xtrapay
```

**Request:**
```json
{
    "amount": 5000
}
```

**Response:**
```json
{
    "success": true,
    "reference": "ABC123456789",
    "accountNumber": "1234567890",
    "bank": "Demo Bank",
    "accountName": "BUBLEMART DEMO ACCOUNT",
    "amount": 5000,
    "expiry": 600
}
```

### 2. Check Payment Status
```
POST /cart/check-payment
```

**Request:**
```json
{
    "reference": "ABC123456789"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Payment confirmed successfully!",
    "order_id": 123,
    "order_number": "ORD-ABC123"
}
```

### 3. Webhook Endpoint
```
POST /api/webhook/xtrapay
```

**Webhook Payload:**
```json
{
    "reference": "ABC123456789",
    "status": "success",
    "amount": 5000,
    "transaction_id": "TXN123456"
}
```

## Demo Mode

When XtraPay API keys are not configured, the system automatically falls back to demo mode:

- Virtual accounts are simulated
- Payment verification returns success after delay
- Webhook processing works with demo data
- Perfect for development and testing

## Error Handling

### Common Issues

1. **Payment Not Confirmed**
   - User hasn't made the transfer yet
   - Transfer amount doesn't match exactly
   - Bank processing delay

2. **API Errors**
   - Invalid API key
   - Network connectivity issues
   - XtraPay service unavailable

3. **Webhook Issues**
   - Invalid webhook signature
   - Missing required fields
   - Order not found

### Logging

All payment activities are logged in Laravel logs:

```bash
# View payment logs
tail -f storage/logs/laravel.log | grep -i xtrapay
```

## Testing

### Manual Testing

1. **Generate payment** → Use cart page
2. **Check status** → Click "I've Made the Transfer"
3. **Verify order** → Check order status in admin

### Webhook Testing

Use tools like ngrok to test webhooks locally:

```bash
# Install ngrok
npm install -g ngrok

# Start tunnel
ngrok http 8000

# Use the ngrok URL in XtraPay webhook configuration
```

## Security

### Webhook Verification

- All webhooks are verified using HMAC signature
- Invalid signatures are rejected
- Demo mode skips signature verification

### API Security

- API calls use Bearer token authentication
- All requests are logged for monitoring
- Error responses don't expose sensitive data

## Troubleshooting

### Payment Not Confirmed

1. Check if user transferred exact amount
2. Verify bank account details
3. Wait for bank processing (can take 5-10 minutes)
4. Check XtraPay dashboard for transaction status

### Webhook Not Working

1. Verify webhook URL is accessible
2. Check webhook secret configuration
3. Review webhook logs for errors
4. Test webhook endpoint manually

### API Errors

1. Verify API key is correct
2. Check network connectivity
3. Review API response logs
4. Contact XtraPay support if needed

## Support

For issues with:

- **XtraPay API** → Contact XtraPay support
- **Application Integration** → Check logs and documentation
- **Configuration** → Verify environment variables

## Files Modified

- `app/Services/XtrapayService.php` - Core payment service
- `app/Http/Controllers/CartController.php` - Payment handling
- `app/Http/Controllers/Api/XtrapayProcessController.php` - Webhook processing
- `routes/api.php` - API routes
- `resources/views/cart/index.blade.php` - Frontend payment UI 