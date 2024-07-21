<?php

declare(strict_types=1);

namespace App\Enums;

enum InvitationStatus: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case DECLINED = 'declined';
    case INVALIDATED = 'invalidated';

    public static function values(): array
    {
        $values = [];

        foreach (self::cases() as $value) {
            $values[] = $value->value;
        }

        return $values;
    }
}
