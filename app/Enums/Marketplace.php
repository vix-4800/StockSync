<?php

namespace App\Enums;

enum Marketplace: string
{
    case WILDBERRIES = 'wildberries';
    case OZON = 'ozon';
    case YANDEXMARKET = 'yandex';

    public static function values(): array
    {
        $values = [];

        foreach (self::cases() as $case) {
            $values[] = $case->value;
        }

        return $values;
    }
}
