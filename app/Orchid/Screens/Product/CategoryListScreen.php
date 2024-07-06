<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Product;

use App\Models\Category;
use App\Orchid\Layouts\Product\CategoryTableLayout;
use App\Orchid\Layouts\Product\ProductTableLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class CategoryListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'categories' =>
                \App\Models\Category::query()
                    ->defaultSort('id', 'ASC')
                    ->filters()
                    ->paginate(50)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Категории';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Добавить категорию')
                ->route('platform.category.create')
                ->icon('plus'),
            Link::make('Добавить продукт')
                ->route('platform.product.create')
                ->icon('plus'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            CategoryTableLayout::class
        ];
    }

    public function remove(Request $request)
    {
        if ($categoryId = $request->get('id', false)) {
            if (Category::query()->where('id', $categoryId)->exists()) {
                Category::query()->find($categoryId)->delete();
                Toast::info('Продукт успешно удалён');
            } else {
                Toast::error(
                    'Не удалось удалить продукт'
                );
            }
        }

        return redirect()->route('platform.products');
    }
}
