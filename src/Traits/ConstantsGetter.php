<?php

namespace Lishun\EasyConst\Traits;

use Lishun\EasyConst\Annotation\EasyConstants;
use Lishun\EasyConst\Utils\ConstantsGroupStore;
use Lishun\EasyConst\Utils\ConstantsStore;
use ReflectionClass;

trait ConstantsGetter
{
    public static function getMsg(mixed $value, mixed $group = ''): string
    {
        return self::getConstantByGroup($value, $group)['msg'] ?? '';
    }

    public static function getExt(mixed $value, mixed $group = ''): array
    {
        return self::getConstantByGroup($value, $group)['ext'] ?? [];
    }

    public static function getConstantByGroup(mixed $value, mixed $group = ''): array
    {
        $list = self::getGroupConstants()[ $group ] ?? [];
        $c    = [];
        if ($list) {
            foreach ($list as $v) {
                if ($v['constantValue'] === $value) {
                    $c = $v;
                    break;
                }
            }
        }
        return $c;
    }

    public static function getAllConstants(string $ctName = ''): array
    {

        if (ConstantsStore::isset(static::class)) {
            $list = ConstantsStore::get(static::class);
            if ($ctName) {
                return $list[ $ctName ] ?? [];
            }
            return $list;
        }

        $data            = [];
        $reflectionClass = new ReflectionClass(static::class);
        foreach ($reflectionClass->getReflectionConstants() as $reflectionConstant) {
            $constantName        = $reflectionConstant->getName();
            $constantAnnotations = $reflectionConstant->getAttributes(EasyConstants::class, \ReflectionAttribute::IS_INSTANCEOF)[0] ?? null;
            $constantValue       = $reflectionConstant->getValue();

            $res = [
                'constantValue' => $constantValue,
                'constantName'  => $constantName,
                'group'         => '',
                'msg'           => '',
                'ext'           => [],
            ];

            if ($constantAnnotations) {
                $res['group'] = $constantAnnotations->newInstance()->group ?? '';
                $res['msg']   = $constantAnnotations->newInstance()->msg ?? '';
                $res['ext']   = $constantAnnotations->newInstance()->ext ?? [];
            }

            if ($ctName === $constantName) {
                $data = $res;
            }

            ConstantsStore::set(static::class, $res['constantName'], $res);
        }

        if ($ctName) {
            return $data;
        }

        return ConstantsStore::get(static::class);
    }


    public static function getGroupConstants(mixed $groupName = null): array
    {
        if (ConstantsGroupStore::issetGroups(static::class)) {
            $list = ConstantsGroupStore::getGroups(static::class);
            if ($groupName !== null) {
                return $list[ $groupName ] ?? [];
            }
            return $list;
        }

        $reflectionClass = new ReflectionClass(static::class);
        foreach ($reflectionClass->getReflectionConstants() as $reflectionConstant) {
            $constantValue       = $reflectionConstant->getValue();
            $constantName        = $reflectionConstant->getName();
            $constantAnnotations = $reflectionConstant->getAttributes(EasyConstants::class, \ReflectionAttribute::IS_INSTANCEOF)[0] ?? null;

            $res = [
                'constantName'  => $constantName,
                'constantValue' => $constantValue,
                'group'         => '',
                'msg'           => '',
                'ext'           => [],
            ];

            if ($constantAnnotations) {
                $res['group'] = $constantAnnotations->newInstance()->group ?? '';
                $res['msg']   = $constantAnnotations->newInstance()->msg ?? '';
                $res['ext']   = $constantAnnotations->newInstance()->ext ?? [];
            }

            ConstantsGroupStore::setGroups(static::class, $res['group'], $res['constantName'], $res);
        }
        $list = ConstantsGroupStore::getGroups(static::class);
        if ($groupName !== null) {
            return $list[ $groupName ] ?? [];
        }
        return $list;
    }
}