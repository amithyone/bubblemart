<?php

namespace App\Helpers;

class AssetHelper
{
    public static function getAssetUrl($path)
    {
        // Check if we're in development and Vite is available
        if (app()->environment('local') && file_exists(public_path('build/manifest.json'))) {
            return asset($path);
        }
        
        // For production, use the built assets
        return asset($path);
    }
    
    public static function templateAsset($path)
    {
        // For shared hosting, assets are directly accessible
        return asset($path);
    }
    
    public static function viteAssets($assets)
    {
        // Check if we're in development and Vite is available
        if (app()->environment('local') && file_exists(public_path('build/manifest.json'))) {
            return app('vite')->__invoke($assets);
        }
        
        // For production, return empty string (assets will be loaded manually)
        return '';
    }
    
    public static function loadBuiltAssets()
    {
        $manifestPath = public_path('build/manifest.json');
        
        if (!file_exists($manifestPath)) {
            return '';
        }
        
        $manifest = json_decode(file_get_contents($manifestPath), true);
        $html = '';
        
        foreach ($manifest as $entry) {
            if (isset($entry['file'])) {
                $extension = pathinfo($entry['file'], PATHINFO_EXTENSION);
                $url = asset('build/' . $entry['file']);
                
                if ($extension === 'css') {
                    $html .= "<link rel=\"stylesheet\" href=\"{$url}\">\n";
                } elseif ($extension === 'js') {
                    $html .= "<script src=\"{$url}\" defer></script>\n";
                }
            }
        }
        
        return $html;
    }

    public static function asset($path)
    {
        // For shared hosting deployment, assets are directly accessible
        return asset($path);
    }
    
    /**
     * Universal asset helper that handles all asset types
     */
    public static function getAsset($path)
    {
        // For shared hosting, all assets are directly accessible
        return asset($path);
    }
} 