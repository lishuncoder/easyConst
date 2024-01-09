<?php


namespace Lishun\EasyConst\Utils;

class ConstantsStore
{
    protected static mixed $store = [];

    public static function set(string $class, string|int $name, $value): bool
    {
        self::$store[ $class ][ $name ] = $value;

        return true;
    }

    public static function isset(string $class): bool
    {
        return isset(self::$store[ $class ]);
    }

    public static function get(string $class): array
    {
        return self::$store[ $class ] ?? [];
    }
}