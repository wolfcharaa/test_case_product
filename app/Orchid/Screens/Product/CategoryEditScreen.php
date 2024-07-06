<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Product;

use App\Models\Category;
use App\Models\Product;
use App\Orchid\Layouts\Product\CategoryEditLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class CategoryEditScreen extends Screen
{
    public ?Category $category = null;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(?Category $category = new Category()): iterable
    {
        return [
            'category' => $category
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this?->category->exists ? 'Редактирование категории' : 'Создание новой категории';
    }

    public function commandBar(): iterable
    {
        return [
            Link::make('Вернуться')
                ->icon('action-undo')
                ->route('platform.categories'),

            Button::make('Удалить')
                ->icon('trash')
                ->confirm('Это действие безвозвратно удалит категорию. Удалить категорию?')
                ->canSee($this?->category->exists)
                ->method('remove', [
                    'id' => $this?->category->id
                ]),

            Button::make('Сохранить')
                ->icon('check')
                ->method('save')
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            CategoryEditLayout::class,
        ];
    }

    public function save(Category $category, Request $request)
    {
        $requestData = $request->validate([
            'category.name' => ['string'],
            'product.ids' => ['sometimes', 'array'],
        ]);

        $category->fill(Arr::get($requestData, 'category'))->save();

        if ($productIds = Arr::get($requestData, 'product', false)) {
            Product::query()->upsert([
                'type_category' => $category->id,
                'id' => $productIds
            ], ['id']);
        }

        Toast::info(
            $productIds
                ? 'Категория и привязка продуктов сохранена'
                : 'Категория сохранена'
        );

        return redirect()->route('platform.categories');
    }

    public function remove(Request $request)
    {
        if ($categoryId = $request->get('id', false)) {
            if (Category::query()->where('id', $categoryId)->exists()) {
                Category::query()->find($categoryId)->delete();
                Toast::info('Категория успешно удалена');
            } else {
                Toast::error(
                    'Не удалось удалить категорию'
                );
            }
        }

        return redirect()->route('platform.categories');
    }
}
