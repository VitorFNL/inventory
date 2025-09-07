<?php

namespace App\Infrastructure\Persistence\Eloquent\Filters\Product;

use App\Filters\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class EloquentDescriptionFilter implements FilterInterface
{
    public function apply(mixed $query, mixed $value): mixed
    {
        if (!$query instanceof Builder) {
            throw new \InvalidArgumentException('Query must be an instance of eloquent Builder');
        }

        if (!is_string($value)) {
            throw new \InvalidArgumentException('Value must be a string');
        }

        return $query->whereRaw('description ILIKE ?', ["%$value%"]);
    }
}