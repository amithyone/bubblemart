<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'subtotal',
        'tax',
        'shipping',
        'total',
        'total_amount',
        'delivery_fee',
        'payment_method',
        'payment_reference',
        'status',
        'payment_status',
        'order_status',
        'tracking_number',
        'tracking_url',
        'carrier',
        'delivery_date',
        'delivery_note',
        'shipping_notes',
        'coupon_code',
        'discount',
        'delivered_at',
        'paid_at',
        'refunded_at',
        'refund_amount',
        'refund_transaction_id',
        'refund_reason',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'shipping' => 'decimal:2',
        'total' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'discount' => 'decimal:2',
        'delivery_date' => 'datetime',
        'delivered_at' => 'datetime',
        'paid_at' => 'datetime',
        'refunded_at' => 'datetime',
        'refund_amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid());
            }
        });
    }

    /**
     * Get formatted subtotal in Naira
     */
    public function getFormattedSubtotalAttribute()
    {
        return '₦' . number_format($this->subtotal, 2);
    }

    /**
     * Get formatted tax in Naira
     */
    public function getFormattedTaxAttribute()
    {
        return '₦' . number_format($this->tax, 2);
    }

    /**
     * Get formatted shipping in Naira
     */
    public function getFormattedShippingAttribute()
    {
        return '₦' . number_format($this->shipping, 2);
    }

    /**
     * Get formatted total in Naira
     */
    public function getFormattedTotalAttribute()
    {
        return '₦' . number_format($this->total, 2);
    }

    /**
     * Get formatted total with USD conversion
     */
    public function getFormattedTotalWithUsdAttribute()
    {
        $usdTotal = $this->total / 1600;
        return '₦' . number_format($this->total, 2) . ' ($' . number_format($usdTotal, 2) . ')';
    }
}
