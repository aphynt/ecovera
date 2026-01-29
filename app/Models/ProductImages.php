<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class ProductImages extends Model
{
    //
    protected $table = 'product_images';

    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function ($category) {
            $category->uuid = Uuid::uuid4()->toString();
        });
    }
}
