<?php

namespace Lishun\EasyConst;

interface EasyConstantsInterface
{
    public static function getMsg(mixed $value, mixed $group = null): string;

    public static function getExt(mixed $value, mixed $group = null): array;

    public static function getAllConstants(): array;

    public static function getGroupConstants(): array;
}