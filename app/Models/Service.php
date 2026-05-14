<?php

namespace App\Models;

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
    protected $guarded = ['id'];

    public function getIconUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->icon);
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, thousands_separator: ' ') . ' ₽';
    }
}
