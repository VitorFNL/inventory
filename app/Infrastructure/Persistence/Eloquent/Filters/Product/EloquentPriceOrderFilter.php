<?php

namespace App\Infrastructure\Persistence\Eloquent\Filters\Product;

use App\Enums\QueryOrderEnum;
use App\Filters\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class EloquentPriceOrderFilter implements FilterInterface
{
    public function apply(mixed $query, mixed $value): mixed
    {
        if (!$query instanceof Builder) {
            throw new \InvalidArgumentException('Query must be an instance of eloquent Builder');
        }

        if (!$value instanceof QueryOrderEnum) {
            throw new \InvalidArgumentException('Value must be an instance of QueryOrderEnum');
        }

        return $query->orderBy('price', $value->value);
    }
}