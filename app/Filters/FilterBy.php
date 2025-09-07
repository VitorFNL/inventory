<?php

namespace App\Filters;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class FilterBy
{
    public function __construct(
        public readonly string $filterClass
    ) {}
}