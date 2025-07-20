<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customization extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'type',
        'message',
        'media_path',
        'additional_cost',
        'special_request',
        'status',
        // Product-specific fields
        'ring_size',
        'bracelet_size',
        'necklace_length',
        'apparel_size',
        'frame_size',
        'cup_type',
        'card_type',
        'pillow_size',
        'blanket_size',
        'material',
        // New sender/receiver fields
        'sender_name',
        'receiver_name',
        'receiver_gender',
        'receiver_phone',
        'receiver_note',
        'delivery_method',
        'receiver_address',
        'receiver_zip',
        'receiver_city',
        'receiver_state',
        'receiver_street',
        'receiver_house_number',
    ];

    protected $casts = [
        'additional_cost' => 'decimal:2',
    ];

    /**
     * Get the user that owns the customization.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product for this customization.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
