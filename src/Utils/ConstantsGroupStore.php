<?php


namespace Lishun\EasyConst\Utils;

class ConstantsGroupStore
{
    protected static mixed $groups = [];

    public static function setGroups(string $class, string|int|null $groupName, string|int $name, $value): bool
    {
        self::$groups[ $class ][ $groupName ][ $name ] = $value;

        return true;
    }

    public static function issetGroups(string $class): bool
    {
        return isset(self::$groups[ $class ]);
    }

    public static function getGroups(string $class): array
    {
        return self::$groups[ $class ] ?? [];
    }
}