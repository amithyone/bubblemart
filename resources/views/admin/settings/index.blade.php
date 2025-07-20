@extends('layouts.admin-mobile')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1><i class="fas fa-cog me-2"></i>Application Settings</h1>
                <div>
                    <button class="btn btn-success me-2" onclick="updateExchangeRate()">
                        <i class="fas fa-sync me-2"></i>Update Exchange Rate
                    </button>
                    <button class="btn btn-info" onclick="testCalculation()">
                        <i class="fas fa-calculator me-2"></i>Test Calculation
                    </button>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                
                <!-- Pricing Settings -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-dollar-sign me-2"></i>Pricing Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exchange_rate" class="form-label">
                                        <strong>Exchange Rate (USD to NGN)</strong>
                                        <small class="text-muted d-block">Current rate: ₦{{ number_format($settings->where('key', 'exchange_rate')->first()->value ?? 1600, 2) }} per $1</small>
                                    </label>
                                    <input type="number" class="form-control" id="exchange_rate" name="settings[exchange_rate]" 
                                           value="{{ $settings->where('key', 'exchange_rate')->first()->value ?? 1600 }}" 
                                           step="0.01" min="1" required>
                                    <div class="form-text">Rate used to convert USD prices to Naira</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="markup_percentage" class="form-label">
                                        <strong>Markup Percentage (%)</strong>
                                        <small class="text-muted d-block">Additional percentage added to all product prices</small>
                                    </label>
                                    <input type="number" class="form-control" id="markup_percentage" name="settings[markup_percentage]" 
                                           value="{{ $settings->where('key', 'markup_percentage')->first()->value ?? 0 }}" 
                                           step="0.01" min="0" max="100">
                                    <div class="form-text">Percentage markup applied to all products (0 = no markup)</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="shipping_cost_usd" class="form-label">
                                        <strong>Shipping Cost (USD)</strong>
                                        <small class="text-muted d-block">Standard shipping cost in USD</small>
                                    </label>
                                    <input type="number" class="form-control" id="shipping_cost_usd" name="settings[shipping_cost_usd]" 
                                           value="{{ $settings->where('key', 'shipping_cost_usd')->first()->value ?? 5.99 }}" 
                                           step="0.01" min="0" required>
                                    <div class="form-text">Base shipping cost that will be converted to Naira</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tax_percentage" class="form-label">
                                        <strong>Tax Percentage (%)</strong>
                                        <small class="text-muted d-block">Tax rate applied to all orders</small>
                                    </label>
                                    <input type="number" class="form-control" id="tax_percentage" name="settings[tax_percentage]" 
                                           value="{{ $settings->where('key', 'tax_percentage')->first()->value ?? 8 }}" 
                                           step="0.01" min="0" max="100" required>
                                    <div class="form-text">Tax percentage applied to order subtotals</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Exchange Rate Settings -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-sync me-2"></i>Exchange Rate Management</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="auto_update_exchange_rate" class="form-label">
                                        <strong>Auto Update Exchange Rate</strong>
                                    </label>
                                    <select class="form-control" id="auto_update_exchange_rate" name="settings[auto_update_exchange_rate]">
                                        <option value="true" {{ ($settings->where('key', 'auto_update_exchange_rate')->first()->value ?? 'false') == 'true' ? 'selected' : '' }}>Yes</option>
                                        <option value="false" {{ ($settings->where('key', 'auto_update_exchange_rate')->first()->value ?? 'false') == 'false' ? 'selected' : '' }}>No</option>
                                    </select>
                                    <div class="form-text">Automatically update exchange rate from external API</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exchange_rate_update_frequency" class="form-label">
                                        <strong>Update Frequency</strong>
                                    </label>
                                    <select class="form-control" id="exchange_rate_update_frequency" name="settings[exchange_rate_update_frequency]">
                                        <option value="daily" {{ ($settings->where('key', 'exchange_rate_update_frequency')->first()->value ?? 'daily') == 'daily' ? 'selected' : '' }}>Daily</option>
                                        <option value="weekly" {{ ($settings->where('key', 'exchange_rate_update_frequency')->first()->value ?? 'daily') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                        <option value="monthly" {{ ($settings->where('key', 'exchange_rate_update_frequency')->first()->value ?? 'daily') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    </select>
                                    <div class="form-text">How often to automatically update the exchange rate</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="exchange_rate_api_url" class="form-label">
                                <strong>Exchange Rate API URL</strong>
                            </label>
                            <input type="url" class="form-control" id="exchange_rate_api_url" name="settings[exchange_rate_api_url]" 
                                   value="{{ $settings->where('key', 'exchange_rate_api_url')->first()->value ?? 'https://api.exchangerate-api.com/v4/latest/USD' }}" 
                                   required>
                            <div class="form-text">API endpoint for fetching current exchange rates</div>
                        </div>
                    </div>
                </div>

                <!-- Telegram Notification Settings -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fab fa-telegram me-2"></i>Telegram Notification Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telegram_enabled" class="form-label">
                                        <strong>Enable Telegram Notifications</strong>
                                    </label>
                                    <select class="form-control" id="telegram_enabled" name="settings[telegram_enabled]">
                                        <option value="true" {{ ($settings->where('key', 'telegram_enabled')->first()->value ?? 'false') == 'true' ? 'selected' : '' }}>Yes</option>
                                        <option value="false" {{ ($settings->where('key', 'telegram_enabled')->first()->value ?? 'false') == 'false' ? 'selected' : '' }}>No</option>
                                    </select>
                                    <div class="form-text">Enable or disable Telegram notifications</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telegram_bot_token" class="form-label">
                                        <strong>Bot Token</strong>
                                    </label>
                                    <input type="text" class="form-control" id="telegram_bot_token" name="settings[telegram_bot_token]" 
                                           value="{{ $settings->where('key', 'telegram_bot_token')->first()->value ?? '' }}" 
                                           placeholder="1234567890:ABCdefGHIjklMNOpqrsTUVwxyz">
                                    <div class="form-text">Your Telegram bot token from @BotFather</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telegram_chat_id" class="form-label">
                                        <strong>Chat ID</strong>
                                    </label>
                                    <input type="text" class="form-control" id="telegram_chat_id" name="settings[telegram_chat_id]" 
                                           value="{{ $settings->where('key', 'telegram_chat_id')->first()->value ?? '' }}" 
                                           placeholder="-1001234567890">
                                    <div class="form-text">Chat ID where notifications will be sent</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telegram_notification_types" class="form-label">
                                        <strong>Notification Types</strong>
                                    </label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="notify_new_orders" name="settings[notify_new_orders]" value="true" 
                                               {{ ($settings->where('key', 'notify_new_orders')->first()->value ?? 'true') == 'true' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="notify_new_orders">
                                            New Orders
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="notify_order_updates" name="settings[notify_order_updates]" value="true" 
                                               {{ ($settings->where('key', 'notify_order_updates')->first()->value ?? 'true') == 'true' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="notify_order_updates">
                                            Order Status Updates
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="notify_payments" name="settings[notify_payments]" value="true" 
                                               {{ ($settings->where('key', 'notify_payments')->first()->value ?? 'true') == 'true' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="notify_payments">
                                            Payment Confirmations
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="notify_low_stock" name="settings[notify_low_stock]" value="true" 
                                               {{ ($settings->where('key', 'notify_low_stock')->first()->value ?? 'false') == 'true' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="notify_low_stock">
                                            Low Stock Alerts
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telegram_message_template" class="form-label">
                                        <strong>Message Template</strong>
                                    </label>
                                    <textarea class="form-control" id="telegram_message_template" name="settings[telegram_message_template]" rows="3" 
                                              placeholder="🎉 New order received!">{{ $settings->where('key', 'telegram_message_template')->first()->value ?? '🎉 New order received!' }}</textarea>
                                    <div class="form-text">Template for notification messages (use {order_id}, {customer_name}, etc.)</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telegram_test_message" class="form-label">
                                        <strong>Test Message</strong>
                                    </label>
                                    <button type="button" class="btn btn-outline-info btn-sm" onclick="testTelegramNotification()">
                                        <i class="fab fa-telegram me-1"></i>Send Test Message
                                    </button>
                                    <div class="form-text">Send a test message to verify your Telegram configuration</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Test Calculation Results -->
                <div class="card mb-4" id="testResults" style="display: none;">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-calculator me-2"></i>Test Calculation Results</h5>
                    </div>
                    <div class="card-body">
                        <div id="testResultsContent"></div>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i>Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateExchangeRate() {
    if (confirm('Update exchange rate from external API?')) {
        window.location.href = '{{ route("admin.settings.update-exchange-rate") }}';
    }
}

function testCalculation() {
    fetch('{{ route("admin.settings.test-exchange-rate") }}')
        .then(response => response.json())
        .then(data => {
            const resultsDiv = document.getElementById('testResultsContent');
            resultsDiv.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h6>Current Settings:</h6>
                        <p><strong>Exchange Rate:</strong> ₦${data.current_rate.toLocaleString()} per $1</p>
                        <p><strong>Markup:</strong> ${data.markup_percentage}%</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Test Calculation ($10.00 product):</h6>
                        <p><strong>Base Price:</strong> ₦${data.test_calculation.base_naira_price.toLocaleString()}</p>
                        <p><strong>Markup:</strong> ₦${data.test_calculation.markup_amount.toLocaleString()}</p>
                        <p><strong>Final Price:</strong> <span class="text-primary fw-bold">${data.test_calculation.formatted_price}</span></p>
                    </div>
                </div>
            `;
            document.getElementById('testResults').style.display = 'block';
        })
        .catch(error => {
            alert('Error testing calculation: ' + error.message);
        });
}

function testTelegramNotification() {
    const botToken = document.getElementById('telegram_bot_token').value;
    const chatId = document.getElementById('telegram_chat_id').value;
    
    if (!botToken || !chatId) {
        alert('Please enter both Bot Token and Chat ID before testing.');
        return;
    }
    
    if (confirm('Send a test Telegram notification?')) {
        fetch('{{ route("admin.settings.test-telegram") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                bot_token: botToken,
                chat_id: chatId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('✅ Test message sent successfully! Check your Telegram.');
            } else {
                alert('❌ Error sending test message: ' + data.message);
            }
        })
        .catch(error => {
            alert('❌ Error testing Telegram notification: ' + error.message);
        });
    }
}
</script>
@endsection 