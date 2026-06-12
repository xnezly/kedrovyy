<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property string|null $name
 * @property string $path
 */
class Image extends Model
{
    protected $guarded = ['id'];

    public function getUrlAttribute(): string
    {
        $path = $this->path;
        $webpPath = preg_replace('/\.(jpe?g|png|jfif)$/i', '.webp', $path) ?? $path;

        if ($webpPath !== $path && Storage::disk('public')->exists($webpPath)) {
            return '/storage/' . ltrim($webpPath, '/');
        }

        return '/storage/' . ltrim($path, '/');
    }
}
