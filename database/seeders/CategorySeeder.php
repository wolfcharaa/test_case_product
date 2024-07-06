<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'Молочные продукты',
            'Бакалея',
            'Сладости',
            'Выпечка',
            'Рыба',
            'Мясо',
            'Мороженное',
            'Полуфабрикаты',
            'Консервы',
            'Овощи',
            'Фрукты',
            'Техника',
            'Кухонная утварь',
        ];
        $factory = Category::factory();
        foreach (range(0, 11) as $index) {
            $factory->state(function (array $attributes) use ($types, $index): array {
                    return [
                        'name' => $types[$index],
                    ];
            })
                ->create();
        }
    }
}
