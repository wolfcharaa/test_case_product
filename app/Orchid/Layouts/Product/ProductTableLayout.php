<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Product;

use App\Models\Product;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ProductTableLayout extends Table
{
    protected $target = 'products';

    protected function columns(): iterable
    {
        return [
            TD::make()->render(static fn(Product $product) => CheckBox::make('id')->render()),

            TD::make('id', 'ID')->sort()->filter(TD::FILTER_NUMERIC),
            TD::make('created_at', 'Время создания')->sort()->filter()->render(
                static fn(Product $product) => $product->created_at->toDateTimeString()
            ),
            TD::make('name', 'Наименование продукта')->sort()->filter(),
            TD::make('sku', 'Уникальный идентификатор')->sort()->filter(),
            TD::make('count', 'Количество на складе')->sort()->filter(),
            TD::make('type_product', 'Тип категории')->sort()->filter()->render(static function (Product $product) {
                return $product->category->name ?? '-';
            }),

            TD::make('image', 'Изображение')
                ->width(1)
                ->render(static function (Product $product): string {
                    if (!$product->picture) {
                        return '';
                    }

                    return str_replace(
                        '>',
                        " style='max-width: 340px; max-height: 340px;'>",
                        $product->picture->base64_image);
                }),

            TD::make('action', 'Действия')->render(function (Product $product) {
                return DropDown::make()
                    ->icon('pencil')
                    ->list([
                        Link::make(__('Edit'))
                            ->icon('pencil')
                            ->route('platform.product.edit', $product->id),

                        Button::make(__('Remove'))
                            ->icon('trash')
                            ->confirm('Это действие безвозвратно удалит банк. Удалить банк?')
                            ->method('remove', [
                                'id' => $product->id
                            ])
                    ]);
            })
        ];
    }
}
