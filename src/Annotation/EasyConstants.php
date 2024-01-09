<?php

declare(strict_types=1);


namespace Lishun\EasyConst\Annotation;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_CLASS_CONSTANT)]
class EasyConstants
{
    public function __construct(
        public readonly ?string               $msg = null,
        public readonly null|string|int|array $group = null,
        public readonly ?array                $ext = null,
    ) {}
}