<?php

namespace App\Models;

use App\Enums\ApplicationStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property int $user_id
 * @property int $room_id
 * @property int $number_of_guests
 * @property Carbon $check_in
 * @property Carbon $check_out
 * @property string|null $comment
 * @property ApplicationStatusEnum $status
 *
 * @property-read Room $room
 * @property-read User $user
 * @property-read Collection<Service> $services
 */
class Application extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'status' => ApplicationStatusEnum::class,
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class);
    }
}
