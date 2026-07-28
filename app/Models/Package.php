<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name',
    'code',
    'monthly_price',
    'yearly_price',
    'menu_limit',
    'category_limit',
    'storage_limit_mb',
    'team_limit',
    'has_statistics',
    'has_custom_theme',
    'remove_branding',
    'language_limit',
    'is_active',
])]
class Package extends Model
{
    use HasFactory;

    public const CODE_FREE = 'free';

    protected function casts(): array
    {
        return [
            'monthly_price' => 'decimal:2',
            'yearly_price' => 'decimal:2',
            'menu_limit' => 'integer',
            'category_limit' => 'integer',
            'storage_limit_mb' => 'integer',
            'team_limit' => 'integer',
            'has_statistics' => 'boolean',
            'has_custom_theme' => 'boolean',
            'remove_branding' => 'boolean',
            'language_limit' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function priceFor(string $billingCycle): float
    {
        return $billingCycle === 'yearly'
            ? (float) ($this->yearly_price ?? $this->monthly_price * 12)
            : (float) $this->monthly_price;
    }

    public static function free(): ?self
    {
        return static::where('code', self::CODE_FREE)->first();
    }
}
