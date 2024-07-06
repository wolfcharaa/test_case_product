<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Product;

use App\Models\Category;
use App\Models\Product;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\TD;

class ProductEditLayout extends Rows
{
    protected function fields(): iterable
    {
        /** @var Product $product */
        $product = request('product');

        return [
            Quill::make('image')
                ->value($product?->picture?->base64_image)
                ->toolbar(['media'])->base64(),
            Input::make('product.sku')
                ->readonly()
                ->value($product?->name)
                ->title('SKU продукта')
                ->help('Поле генерируется автоматически'),
            Input::make('product.count')
                ->required()
                ->mask([
                    'alias' => 'integer',
                    'min' => 0,
                    'max' => 32767,
                    'allowMinus' => false,
                    'numericInput' => true,
                ])
                ->value($product?->count)
                ->title('Количество на складе')
                ->help('100'),
            Input::make('product.name')
                ->required()
                ->value($product?->name)
                ->title('Наименование продукта')
                ->help('Молоко'),
            Relation::make('product.type_product')
                ->fromModel(Category::class, 'name', 'id')
                ->help('Выберите, если хотите привязать продукт к категории')
        ];
    }
}
