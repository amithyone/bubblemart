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
            $setting = Setting::where('key', $key)->first();
            if ($setting) {
                // Handle array values (like enabled_countries)
                if (is_array($value)) {
                    $value = json_encode($value);
                }
                
                $setting->update(['value' => $value]);
                Setting::clearCache();
            }
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully!');
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