<?php

namespace App\UseCases\ListProducts;

use App\Filters\FilterBy;
use App\Infrastructure\Persistence\Eloquent\Filters\Product\EloquentDescriptionFilter;
use App\Infrastructure\Persistence\Eloquent\Filters\Product\EloquentNameFilter;
use App\Infrastructure\Persistence\Eloquent\Filters\Product\EloquentPriceOrderFilter;
use App\Enums\QueryOrderEnum;

class ListProductsInput
{
    public function __construct(
        #[FilterBy(EloquentNameFilter::class)]
        public ?string $nameFilter = null,
        #[FilterBy(EloquentDescriptionFilter::class)]
        public ?string $descriptionFilter = null,
        #[FilterBy(EloquentPriceOrderFilter::class)]
        public ?QueryOrderEnum $priceOrderFilter = null,
    ) {}
}