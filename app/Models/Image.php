<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        return '/storage/' . ltrim($this->path, '/');
    }
}
