<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'name',
        'phone',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'postal_code',
        'country',
        'is_default',
        'label',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Check if this is a US address
     */
    public function isUsAddress(): bool
    {
        return $this->country === 'US';
    }

    /**
     * Get country display name
     */
    public function getCountryDisplayNameAttribute(): string
    {
        $countries = \App\Models\Setting::getEnabledCountries();
        return $countries[$this->country] ?? $this->country;
    }

    /**
     * Get state display name (for US addresses)
     */
    public function getStateDisplayNameAttribute(): string
    {
        if ($this->isUsAddress()) {
            $states = \App\Models\Setting::getUsStates();
            return $states[$this->state] ?? $this->state;
        }
        return $this->state;
    }
}
