<?php

namespace App\Shortener\Enums;

enum HTTPStatuses: int
{
    case OK = 200;
    case CREATED = 201;
    case MOVED_PERMANENTLY = 301;
    case FOUND = 302;
    case NOT_FOUND = 404;

    public static function getValidStatuses(): array
    {
        return [
            self::OK->value,
            self::CREATED->value,
            self::MOVED_PERMANENTLY->value,
            self::FOUND->value,
        ];
    }
}
