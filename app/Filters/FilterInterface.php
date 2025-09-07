<?php

namespace App\Filters;

interface FilterInterface
{
    public function apply(mixed $query, mixed $value): mixed;
}
