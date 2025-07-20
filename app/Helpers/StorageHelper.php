<?php

namespace App\Helpers;

class StorageHelper
{
    /**
     * Get the URL for a stored file
     */
    public static function getFileUrl($path)
    {
        if (empty($path)) {
            return null;
        }
        
        // For shared hosting, storage files should be directly accessible
        return asset('storage/' . $path);
    }
    
    /**
     * Get the URL for a product image
     */
    public static function getProductImageUrl($product)
    {
        if (!$product || empty($product->image)) {
            return asset('template-assets/img/ecommerce/image-6.jpg');
        }
        
        return self::getFileUrl($product->image);
    }
    
    /**
     * Get the URL for a user avatar
     */
    public static function getAvatarUrl($user)
    {
        if (!$user || empty($user->avatar)) {
            return asset('template-assets/img/avatars/1.jpg');
        }
        
        // Check if the file actually exists
        if (!self::fileExists($user->avatar)) {
            \Log::warning('Avatar file not found', [
                'user_id' => $user->id,
                'avatar_path' => $user->avatar
            ]);
            return asset('template-assets/img/avatars/1.jpg');
        }
        
        return self::getFileUrl($user->avatar);
    }
    
    /**
     * Check if a file exists in storage
     */
    public static function fileExists($path)
    {
        if (empty($path)) {
            return false;
        }
        
        return file_exists(storage_path('app/public/' . $path));
    }
} 