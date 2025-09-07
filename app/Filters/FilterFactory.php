<?php

namespace App\Filters;

use ReflectionClass;
use ReflectionProperty;

class FilterFactory
{
    public function createFromDTO(object $dto): array
    {
        $applicableFilters = [];
        $reflectionClass = new ReflectionClass($dto);
        $properties = $reflectionClass->getProperties(ReflectionProperty::IS_PUBLIC);

        foreach ($properties as $property) {
            $value = $property->getValue($dto);

            // Pega apenas os valores não nulos.
            if ($value === null) {
                continue;
            }

            // Pega o atributo #[FilterBy] da propriedade.
            $attributes = $property->getAttributes(FilterBy::class);

            if (count($attributes) > 0) {
                $attributeInstance = $attributes[0]->newInstance();
                $filterClass = $attributeInstance->filterClass;

                $filterInstance = app()->make($filterClass);

                $applicableFilters[] = [
                    'filter' => $filterInstance,
                    'value' => $value
                ];
            }
        }

        return $applicableFilters;
    }
}