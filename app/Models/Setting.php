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
    public static function setValue(string $key, $value, string $type = 'string', string $group = 'general', string $description = null)
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