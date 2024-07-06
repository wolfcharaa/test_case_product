<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string base64_image
 */
class Picture extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'id',
        'base64_image'
    ];
}
