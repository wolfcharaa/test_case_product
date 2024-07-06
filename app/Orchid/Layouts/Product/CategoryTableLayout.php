<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Product;

use App\Models\Category;
use App\Models\Product;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CategoryTableLayout extends Table
{
    protected $target = 'categories';

    protected function columns(): iterable
    {
        return [
            TD::make()->render(static fn (Category $category) => CheckBox::make('id')),
            TD::make('id', 'ID')->sort()->filter(TD::FILTER_NUMERIC),
            TD::make('name', 'Наименование продукта')->sort()->filter(),
            TD::make('products', 'Привязанные продукты')->sort()->filter()->render(static function (Category $category) {
                $products = $category->products->map(static fn (Product $product) => $product->name);

                return $products->isNotEmpty() ? implode("\n, ", $products->toArray()) : '-';
            }),

            TD::make('action', 'Действия')->render(function (Category $category) {
                return DropDown::make()
                    ->icon('options-vertical')
                    ->list([
                        Link::make(__('Edit'))
                            ->icon('pencil')
                            ->route('platform.category.edit', $category->id),

                        Button::make(__('Remove'))
                            ->icon('trash')
                            ->confirm('Это действие безвозвратно удалит категорию. Удалить категорию?')
                            ->method('remove', [
                                'id' => $category->id
                            ])
                    ]);
            })
        ];
    }
}
