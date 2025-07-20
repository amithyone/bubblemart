<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Notification;
use App\Models\WalletTransaction;
use App\Channels\TelegramChannel;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register global asset helper function
        if (!function_exists('asset_path')) {
            function asset_path($path) {
                // For template assets, always prepend public/
                if (str_starts_with($path, 'template-assets/')) {
                    return asset('public/' . $path);
                }
                
                // For storage assets
                if (str_starts_with($path, 'storage/')) {
                    if (app()->environment('production')) {
                        return asset('public/' . $path);
                    }
                    return asset($path);
                }
                
                // For build assets
                if (str_starts_with($path, 'build/')) {
                    if (app()->environment('production')) {
                        return asset('public/' . $path);
                    }
                    return asset($path);
                }
                
                // Default case - check if we're in production
                if (app()->environment('production')) {
                    return asset('public/' . $path);
                }
                
                return asset($path);
            }
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set the global HOME constant for authentication redirects
        if (!defined('HOME')) {
            define('HOME', '/');
        }
        
        // Register custom blade directive for template assets
        Blade::directive('templateAsset', function ($expression) {
            return "<?php echo asset($expression); ?>";
        });
        
        // Register custom blade directive for live server assets
        Blade::directive('liveAsset', function ($expression) {
            return "<?php echo asset($expression); ?>";
        });
        
        // Custom route model binding for WalletTransaction
        Route::bind('transaction', function ($value) {
            $transaction = WalletTransaction::findOrFail($value);
            
            // Check if the authenticated user owns this transaction
            $user = auth()->user();
            if (!$user || !$user->wallet || $transaction->wallet_id !== $user->wallet->id) {
                abort(403, 'You are not authorized to view this transaction.');
            }
            
            return $transaction;
        });
        
        // Register Telegram notification channel
        Notification::extend('telegram', function ($app) {
            return new TelegramChannel();
        });
    }
}
