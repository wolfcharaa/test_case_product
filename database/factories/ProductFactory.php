<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'picture_id' => null,
            'sku' => $this->faker->uuid,
            'name' => $this->faker->word,
            'count' => $this->faker->randomNumber(3),
            'type_product' => Category::query()->inRandomOrder()->exists()
                ? Category::query()->inRandomOrder()->value('id')
                : Category::factory()->create()->first()->id,
        ];
    }
}
