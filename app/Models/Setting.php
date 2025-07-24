<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'description'
    ];

    /**
     * Get a setting value by key
     */
    public static function getValue(string $key, $default = null)
    {
        $cacheKey = "setting_{$key}";
        
        return Cache::remember($cacheKey, 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? static::castValue($setting->value, $setting->type) : $default;
        });
    }

    /**
     * Set a setting value
     */
    public static function setValue(string $key, $value, string $type = 'string', string $group = 'general', ?string $description = null)
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'group' => $group,
                'description' => $description
            ]
        );

        // Clear cache
        Cache::forget("setting_{$key}");
        
        return $setting;
    }

    /**
     * Cast value based on type
     */
    protected static function castValue($value, $type)
    {
        return match($type) {
            'number' => (float) $value,
            'integer' => (int) $value,
            'boolean' => (bool) $value,
            'json' => json_decode($value, true),
            default => $value
        };
    }

    /**
     * Get exchange rate (USD to NGN)
     */
    public static function getExchangeRate(): float
    {
        return static::getValue('exchange_rate', 1600.0);
    }

    /**
     * Get markup percentage
     */
    public static function getMarkupPercentage(): float
    {
        return static::getValue('markup_percentage', 0.0);
    }

    /**
     * Get shipping cost in USD
     */
    public static function getShippingCostUsd(): float
    {
        return static::getValue('shipping_cost_usd', 5.99);
    }

    /**
     * Get tax percentage
     */
    public static function getTaxPercentage(): float
    {
        return static::getValue('tax_percentage', 8.0);
    }

    /**
     * Get Telegram bot token
     */
    public static function getTelegramBotToken(): string
    {
        return static::getValue('telegram_bot_token', '');
    }

    /**
     * Get Telegram chat ID
     */
    public static function getTelegramChatId(): string
    {
        return static::getValue('telegram_chat_id', '');
    }

    /**
     * Check if Telegram notifications are enabled
     */
    public static function isTelegramEnabled(): bool
    {
        return static::getValue('telegram_enabled', false);
    }

    /**
     * Check if specific notification type is enabled
     */
    public static function isNotificationEnabled(string $type): bool
    {
        return static::getValue("notify_{$type}", true);
    }

    /**
     * Get Telegram message template
     */
    public static function getTelegramMessageTemplate(): string
    {
        return static::getValue('telegram_message_template', '🎉 New order received!');
    }

    /**
     * Get enabled countries list
     */
    public static function getEnabledCountries(): array
    {
        return static::getValue('enabled_countries', [
            'US' => 'United States',
            'CA' => 'Canada',
            'GB' => 'United Kingdom',
            'AU' => 'Australia',
            'DE' => 'Germany',
            'FR' => 'France',
            'IT' => 'Italy',
            'ES' => 'Spain',
            'NL' => 'Netherlands',
            'BE' => 'Belgium',
            'CH' => 'Switzerland',
            'AT' => 'Austria',
            'SE' => 'Sweden',
            'NO' => 'Norway',
            'DK' => 'Denmark',
            'FI' => 'Finland',
            'IE' => 'Ireland',
            'NZ' => 'New Zealand',
            'JP' => 'Japan',
            'SG' => 'Singapore',
            'HK' => 'Hong Kong',
            'KR' => 'South Korea',
            'AE' => 'United Arab Emirates',
            'SA' => 'Saudi Arabia',
            'IL' => 'Israel',
            'BR' => 'Brazil',
            'MX' => 'Mexico',
            'AR' => 'Argentina',
            'CL' => 'Chile',
            'CO' => 'Colombia',
            'PE' => 'Peru',
            'ZA' => 'South Africa',
            'EG' => 'Egypt',
            'MA' => 'Morocco',
            'NG' => 'Nigeria',
            'KE' => 'Kenya',
            'GH' => 'Ghana',
            'UG' => 'Uganda',
            'TZ' => 'Tanzania',
            'ET' => 'Ethiopia',
            'IN' => 'India',
            'PK' => 'Pakistan',
            'BD' => 'Bangladesh',
            'LK' => 'Sri Lanka',
            'NP' => 'Nepal',
            'TH' => 'Thailand',
            'VN' => 'Vietnam',
            'MY' => 'Malaysia',
            'ID' => 'Indonesia',
            'PH' => 'Philippines'
        ]);
    }

    /**
     * Get US states list
     */
    public static function getUsStates(): array
    {
        return [
            'AL' => 'Alabama', 'AK' => 'Alaska', 'AZ' => 'Arizona', 'AR' => 'Arkansas', 'CA' => 'California',
            'CO' => 'Colorado', 'CT' => 'Connecticut', 'DE' => 'Delaware', 'FL' => 'Florida', 'GA' => 'Georgia',
            'HI' => 'Hawaii', 'ID' => 'Idaho', 'IL' => 'Illinois', 'IN' => 'Indiana', 'IA' => 'Iowa',
            'KS' => 'Kansas', 'KY' => 'Kentucky', 'LA' => 'Louisiana', 'ME' => 'Maine', 'MD' => 'Maryland',
            'MA' => 'Massachusetts', 'MI' => 'Michigan', 'MN' => 'Minnesota', 'MS' => 'Mississippi', 'MO' => 'Missouri',
            'MT' => 'Montana', 'NE' => 'Nebraska', 'NV' => 'Nevada', 'NH' => 'New Hampshire', 'NJ' => 'New Jersey',
            'NM' => 'New Mexico', 'NY' => 'New York', 'NC' => 'North Carolina', 'ND' => 'North Dakota', 'OH' => 'Ohio',
            'OK' => 'Oklahoma', 'OR' => 'Oregon', 'PA' => 'Pennsylvania', 'RI' => 'Rhode Island', 'SC' => 'South Carolina',
            'SD' => 'South Dakota', 'TN' => 'Tennessee', 'TX' => 'Texas', 'UT' => 'Utah', 'VT' => 'Vermont',
            'VA' => 'Virginia', 'WA' => 'Washington', 'WV' => 'West Virginia', 'WI' => 'Wisconsin', 'WY' => 'Wyoming'
        ];
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache()
    {
        $settings = static::all();
        foreach ($settings as $setting) {
            Cache::forget("setting_{$setting->key}");
        }
    }
} 