<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Product;

use App\Models\Category;
use App\Models\Product;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class CategoryEditLayout extends Rows
{
    protected function fields(): iterable
    {
        /** @var Category $category */
        $category = request('category');

        return [
            Input::make('category.name')
                ->required()
                ->value($category?->name)
                ->title('Имя категории'),
            Select::make('product.ids')
                ->help('Выберите, если хотите привязать продукт к категории')
                ->multiple()
                ->fromModel(Product::class, 'name', 'id')
        ];
    }
}
