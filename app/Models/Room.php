<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $price
 *
 * @property-read Collection<Image> $images
 * @property-read Collection<Service> $services
 * @property-read Collection<Review> $reviews
 * @property-read Collection<Application> $applications
 */
class Room extends Model
{
    protected $guarded = ['id'];

    public function getImageUrlAttribute(): ?string
    {
        return $this->images->isNotEmpty()
            ? $this->images[0]->url
            : null;
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, thousands_separator: ' ') . ' ₽';
    }

    public function images(): BelongsToMany
    {
        return $this->belongsToMany(Image::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}
