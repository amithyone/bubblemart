# PayVibe Payment Gateway Integration

## Overview
PayVibe is a virtual account payment gateway that allows users to fund their wallets through bank transfers. This integration provides a seamless payment experience for BubleMart users.

## API Endpoints

### Base URL
```
https://payvibeapi.six3tech.com/api
```

### Virtual Account Initiation
**Endpoint:** `POST /v1/payments/virtual-accounts/initiate`

**Request Body:**
```json
{
    "reference": "PAYVIBE_1234567890_1234",
    "product_identifier": "fadded_sms",
    "amount": 500000
}
```

**Response:**
```json
{
    "status": "success",
    "data": {
        "reference": "PAYVIBE_1234567890_1234",
        "account_number": "1234567890",
        "bank_name": "Test Bank",
        "account_name": "BUBLEMART/PAYVIBE",
        "amount": 500000
    }
}
```

### Payment Status Check
**Endpoint:** `POST /v1/payments/virtual-accounts/status`

**Request Body:**
```json
{
    "reference": "PAYVIBE_1234567890_1234",
    "product_identifier": "fadded_sms"
}
```

## Implementation Details

### Files Created/Modified

1. **`app/Services/PayVibeService.php`**
   - Main service class for PayVibe API integration
   - Handles virtual account generation
   - Processes payment status checks
   - Manages webhook processing

2. **`app/Http/Controllers/Api/PayVibeWebhookController.php`**
   - Handles PayVibe webhook notifications
   - Processes completed payments
   - Updates wallet balances

3. **`app/Http/Controllers/WalletController.php`**
   - Added `generatePayVibe()` method
   - Creates pending transactions
   - Returns virtual account details

4. **`app/Services/WalletChargeService.php`**
   - Added `processPayment()` method
   - Handles payment processing for multiple gateways
   - Updates transaction status and wallet balance

### Routes Added

**Web Routes:**
```php
Route::post('/wallet/generate-payvibe', [WalletController::class, 'generatePayVibe'])
    ->name('wallet.generate-payvibe');
```

**API Routes:**
```php
Route::post('/webhook/payvibe', [PayVibeWebhookController::class, 'handleWebhook'])
    ->name('api.webhook.payvibe');
```

## Usage

### Frontend Integration

```javascript
// Generate PayVibe virtual account
fetch('/wallet/generate-payvibe', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify({
        amount: 5000 // Amount in Naira
    })
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        // Display virtual account details
        console.log('Account Number:', data.accountNumber);
        console.log('Bank:', data.bank);
        console.log('Amount:', data.amount);
    }
});
```

### Webhook Configuration

Set up the following webhook URL in your PayVibe dashboard:
```
https://yourdomain.com/api/webhook/payvibe
```

## Payment Flow

1. **User initiates funding:**
   - User enters amount on wallet page
   - System calculates charges
   - PayVibe virtual account is generated

2. **Virtual account details displayed:**
   - Account number, bank name, and amount shown
   - User transfers money to the virtual account

3. **Payment verification:**
   - PayVibe sends webhook notification
   - System processes the payment
   - Wallet balance is updated
   - Transaction status is marked as completed

## Error Handling

The integration includes comprehensive error handling:

- **API failures:** Logged and user-friendly messages displayed
- **Webhook processing:** Graceful handling of invalid payloads
- **Database transactions:** Rollback on failures
- **Duplicate payments:** Prevention of double processing

## Security Features

- **Reference validation:** Ensures payment references match
- **Amount verification:** Prevents amount tampering
- **Transaction status checks:** Prevents duplicate processing
- **Comprehensive logging:** All operations logged for debugging

## Configuration

No additional environment variables are required. The integration uses the default PayVibe configuration:

- **Product Identifier:** `fadded_sms`
- **Base URL:** `https://payvibeapi.six3tech.com/api`

## Testing

### Test Payment Flow
1. Generate a virtual account with a small amount
2. Use PayVibe test credentials to make a transfer
3. Verify webhook processing
4. Check wallet balance update

### Manual Verification
```php
// Check payment status manually
$payVibeService = new \App\Services\PayVibeService();
$status = $payVibeService->checkPaymentStatus('PAYVIBE_REFERENCE');
```

## Support

For issues with the PayVibe integration:
1. Check application logs for detailed error messages
2. Verify webhook URL configuration
3. Ensure proper API credentials
4. Contact PayVibe support for API-related issues 