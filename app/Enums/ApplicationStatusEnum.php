<?php

namespace App\Enums;

enum ApplicationStatusEnum: string
{
    case PENDING = 'pending';
    case CONFIRMED = 'confirmed';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'На рассмотрении',
            self::CONFIRMED => 'Подтверждено',
            self::CANCELLED => 'Отменено',
        };
    }
}
