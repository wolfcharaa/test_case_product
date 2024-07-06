<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use Orchid\Filters\Types;

/**
 * @property int id
 * @property string created_at
 * @property string updated_at
 * @property string name
 *
 * @property-read Collection<int, Product> products
 */
class Category extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;

    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'name',
    ];

    protected array $allowedSorts = [
        'id',
        'created_at',
        'name',
    ];

    protected array $allowedFilters = [
        'id' => Types\Where::class,
        'created_at' => Types\WhereDate::class,
        'name' => Types\Where::class,
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'type_product');
    }
}
