<?php

declare(strict_types=1);

namespace App\Orchid\Layouts;

use App\Orchid\Filters\ProductFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class ProductSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): array
    {
        return [
            ProductFilter::class
        ];
    }
}
