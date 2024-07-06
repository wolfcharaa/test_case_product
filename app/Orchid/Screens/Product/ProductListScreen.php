<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Product;

use App\Models\Product;
use App\Orchid\Layouts\Product\ProductTableLayout;
use Illuminate\Http\Request;
use mysql_xdevapi\Table;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class ProductListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'products' =>
                \App\Models\Product::query()
                    ->defaultSort('id', 'ASC')
                    ->filters()
                    ->paginate(25)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Продукты';
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
            ProductTableLayout::class
        ];
    }

    public function remove(Request $request)
    {
        if ($productId = $request->get('id', false)) {
            if (Product::query()->where('id', $productId)->exists()) {
                Product::query()->find($productId)->delete();
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
