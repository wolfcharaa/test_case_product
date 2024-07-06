<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Product;

use App\Models\Picture;
use App\Models\Product;
use App\Orchid\Layouts\Product\ProductEditLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;
use Symfony\Component\Uid\Uuid;

class ProductEditScreen extends Screen
{
    public ?Product $product = null;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Product $product): iterable
    {
        return [
            'product' => $product
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this?->product->exists ? 'Редактирование продукта' : 'Создание нового продукта';
    }

    public function commandBar(): iterable
    {
        return [
            Link::make('Вернуться')
                ->icon('action-undo')
                ->route('platform.products'),

            Button::make('Удалить')
                ->icon('trash')
                ->confirm('Это действие безвозвратно удалит продукт. Удалить продукт?')
                ->canSee($this?->product->exists)
                ->method('remove', [
                    'id' => $this?->product->id
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
            ProductEditLayout::class,
        ];
    }

    public function save(Product $product, Request $request)
    {
        $requestData = $request->validate([
            'image' => ['sometimes', 'string'],
            'product.name' => ['required', 'string'],
            'product.sku' => ['nullable', 'uuid'],
            'product.count' => ['required', 'numeric'],
            'product.type_product' => ['sometimes', 'numeric'],
        ]);

        $image = Arr::get($requestData, 'image');
        if (isset($image) && !$product->picture_id) {
            $picture = new Picture();
            $picture->base64_image = $image;
            $picture->save();
        } else {
            $picture = $product->picture;
            $picture->base64_image = $image;
            $picture->save();
        }

        $fillData = Arr::get($requestData, 'product');
        $fillData['sku'] = $fillData['sku'] ?? Uuid::v4()->toRfc4122();
        $fillData['picture_id'] = $picture->id;
        $product->fill($fillData)->save();

        Toast::info(
            Arr::has($requestData, 'product.type_product')
                ? 'Продукт и привязка к категории сохранена'
                : 'Продукт сохранён'
        );

        return redirect()->route('platform.products');
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
