<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\TelegramNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::orderBy('group')->orderBy('key')->get();
        $groups = $settings->groupBy('group');
        
        return view('admin.settings.index', compact('groups', 'settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'settings' => 'required|array'
        ]);

        foreach ($request->settings as $key => $value) {
            // Skip null values (empty fields)
            if ($value === null) {
                continue;
            }
            
            // Handle array values (like enabled_countries)
            if (is_array($value)) {
                $value = json_encode($value);
            }
            
            // Convert empty strings to appropriate defaults
            if ($value === '') {
                $value = $this->getDefaultValue($key);
            }
            
            // Create or update setting
            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                    'type' => is_numeric($value) ? 'number' : 'string',
                    'group' => $this->getSettingGroup($key),
                    'description' => $this->getSettingDescription($key)
                ]
            );
            
            Setting::clearCache();
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully!');
    }

    /**
     * Get the group for a setting key
     */
    private function getSettingGroup($key)
    {
        return match($key) {
            'exchange_rate', 'markup_percentage', 'shipping_cost_usd', 'tax_percentage' => 'pricing',
            'telegram_bot_token', 'telegram_chat_id', 'telegram_enabled', 'telegram_message_template' => 'notifications',
            'enabled_countries' => 'shipping',
            default => 'general'
        };
    }

    /**
     * Get the description for a setting key
     */
    private function getSettingDescription($key)
    {
        return match($key) {
            'exchange_rate' => 'Exchange rate from USD to NGN (Naira)',
            'markup_percentage' => 'Additional percentage markup on all products',
            'shipping_cost_usd' => 'Standard shipping cost in USD',
            'tax_percentage' => 'Tax percentage applied to orders',
            'telegram_bot_token' => 'Telegram bot token from @BotFather',
            'telegram_chat_id' => 'Telegram chat ID for notifications',
            'telegram_enabled' => 'Enable or disable Telegram notifications',
            'telegram_message_template' => 'Template for Telegram notification messages',
            'enabled_countries' => 'List of countries enabled for international shipping',
            default => null
        };
    }

    /**
     * Get default value for a setting key
     */
    private function getDefaultValue($key)
    {
        return match($key) {
            'telegram_bot_token', 'telegram_chat_id' => '',
            'telegram_enabled' => '0',
            'notify_new_orders', 'notify_order_updates', 'notify_payments' => '1',
            'notify_low_stock' => '0',
            'telegram_message_template' => '🎉 New order received!',
            'exchange_rate' => '1600',
            'markup_percentage' => '0',
            'shipping_cost_usd' => '5.99',
            'tax_percentage' => '8',
            default => ''
        };
    }

    public function updateExchangeRate()
    {
        try {
            $apiUrl = Setting::getValue('exchange_rate_api_url', 'https://api.exchangerate-api.com/v4/latest/USD');
            
            $response = Http::get($apiUrl);
            
            if ($response->successful()) {
                $data = $response->json();
                $ngnRate = $data['rates']['NGN'] ?? null;
                
                if ($ngnRate) {
                    Setting::setValue('exchange_rate', $ngnRate, 'number', 'pricing', 'Exchange rate from USD to NGN (Naira)');
                    
                    return redirect()->route('admin.settings.index')
                        ->with('success', "Exchange rate updated to ₦" . number_format($ngnRate, 2) . " per $1");
                } else {
                    return redirect()->route('admin.settings.index')
                        ->with('error', 'Could not fetch NGN rate from API');
                }
            } else {
                return redirect()->route('admin.settings.index')
                    ->with('error', 'Failed to fetch exchange rate from API');
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.index')
                ->with('error', 'Error updating exchange rate: ' . $e->getMessage());
        }
    }

    public function testExchangeRate()
    {
        $currentRate = Setting::getExchangeRate();
        $markup = Setting::getMarkupPercentage();
        
        // Test calculation
        $usdPrice = 10.00;
        $baseNairaPrice = $usdPrice * $currentRate;
        $markupAmount = $baseNairaPrice * ($markup / 100);
        $finalNairaPrice = $baseNairaPrice + $markupAmount;
        
        return response()->json([
            'current_rate' => $currentRate,
            'markup_percentage' => $markup,
            'test_calculation' => [
                'usd_price' => $usdPrice,
                'base_naira_price' => $baseNairaPrice,
                'markup_amount' => $markupAmount,
                'final_naira_price' => $finalNairaPrice,
                'formatted_price' => '₦' . number_format($finalNairaPrice, 2) . ' ($' . number_format($usdPrice, 2) . ')'
            ]
        ]);
    }

    public function testTelegram(Request $request)
    {
        $request->validate([
            'bot_token' => 'required|string',
            'chat_id' => 'required|string'
        ]);

        $result = TelegramNotificationService::testConnection(
            $request->bot_token,
            $request->chat_id
        );

        return response()->json($result);
    }
} 