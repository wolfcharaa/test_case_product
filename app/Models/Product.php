<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Orchid\Attachment\Models\Attachment;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use Orchid\Filters\Types;

/**
 * @property int id
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property int picture_id
 * @property string sku
 * @property string name
 * @property int count
 * @property int type_product
 *
 * @property ?Category category
 * @property ?Picture picture
 */
class Product extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;

    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'picture_id',
        'sku',
        'name',
        'count',
        'type_product',
    ];

    protected array $allowedSorts = [
        'id',
        'created_at',
        'sku',
        'name',
        'count',
        'type_product',
    ];

    protected array $allowedFilters = [
        'id' => Types\Where::class,
        'created_at' => Types\WhereDate::class,
        'sku' => Types\Where::class,
        'name' => Types\Where::class,
        'count' => Types\Where::class,
        'type_product' => Types\Where::class,
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'type_product');
    }

    public function picture(): HasOne
    {
        return $this->hasOne(Picture::class, 'id', 'picture_id');
    }
}
