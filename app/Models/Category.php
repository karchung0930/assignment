<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'fee_rate', 'fee_fixed', 'fee_threshold'];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function calculateFee(float $cost): float
    {
        if ($this->fee_threshold && $cost > $this->fee_threshold) {
            return $this->fee_fixed;
        }

        return round($cost * $this->fee_rate, 2);
    }
}
