<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $price
 * @property string|null $icon
 */
class Service extends Model
{
    public const BOOKING_ADDON_KEYWORDS = [
        'баня',
        'купель',
    ];

    protected $guarded = ['id'];

    public function scopeBookingAddons(Builder $query): Builder
    {
        return $query->where(function (Builder $builder): void {
            foreach (self::BOOKING_ADDON_KEYWORDS as $index => $keyword) {
                $method = $index === 0 ? 'where' : 'orWhere';
                $builder->{$method}('name', 'like', '%' . $keyword . '%');
            }
        });
    }

    public function getIconUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->icon);
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, thousands_separator: ' ') . ' ₽';
    }
}
