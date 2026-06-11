<?php

namespace App\Models;

use App\Enums\ApplicationStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property int $user_id
 * @property int $room_id
 * @property string|null $guest_name
 * @property int|null $guest_age
 * @property string|null $guest_phone
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
        'guest_age' => 'integer',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'status' => ApplicationStatusEnum::class,
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', '!=', ApplicationStatusEnum::CANCELLED->value);
    }

    public function scopeOverlapping(Builder $query, Carbon|string $checkIn, Carbon|string $checkOut): Builder
    {
        return $query
            ->where('check_in', '<', $checkOut)
            ->where('check_out', '>', $checkIn);
    }

    public static function hasBookingConflict(
        int $roomId,
        Carbon|string $checkIn,
        Carbon|string $checkOut,
        ?int $ignoreApplicationId = null,
    ): bool {
        return static::query()
            ->where('room_id', $roomId)
            ->when($ignoreApplicationId !== null, static function (Builder $query) use ($ignoreApplicationId): Builder {
                return $query->whereKeyNot($ignoreApplicationId);
            })
            ->active()
            ->overlapping($checkIn, $checkOut)
            ->exists();
    }

    public static function formatPhone(?string $phone): ?string
    {
        if (!$phone) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $phone);

        if (!$digits) {
            return null;
        }

        if (strlen($digits) === 11 && str_starts_with($digits, '8')) {
            $digits = '7' . substr($digits, 1);
        }

        if (strlen($digits) !== 11 || !str_starts_with($digits, '7')) {
            return $phone;
        }

        return sprintf(
            '+7 (%s) %s-%s-%s',
            substr($digits, 1, 3),
            substr($digits, 4, 3),
            substr($digits, 7, 2),
            substr($digits, 9, 2),
        );
    }

    public function getContactNameAttribute(): ?string
    {
        return $this->guest_name ?: $this->user?->name;
    }

    public function getContactAgeAttribute(): ?int
    {
        return $this->guest_age ?? $this->user?->age;
    }

    public function getContactPhoneDigitsAttribute(): ?string
    {
        $phone = $this->guest_phone ?: $this->user?->phone;

        if (!$phone) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $phone);

        if (!$digits) {
            return null;
        }

        if (strlen($digits) === 11 && str_starts_with($digits, '8')) {
            $digits = '7' . substr($digits, 1);
        }

        return strlen($digits) === 11 ? $digits : null;
    }

    public function getContactPhoneFormattedAttribute(): ?string
    {
        return self::formatPhone($this->contact_phone_digits);
    }

    public function syncContactSnapshotToUser(): self
    {
        if (!$this->relationLoaded('user') || !$this->user) {
            return $this;
        }

        if ($this->contact_name) {
            $this->user->name = $this->contact_name;
        }

        if ($this->contact_age !== null) {
            $this->user->age = $this->contact_age;
        }

        if ($this->contact_phone_formatted) {
            $this->user->phone = $this->contact_phone_formatted;
        }

        return $this;
    }

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
