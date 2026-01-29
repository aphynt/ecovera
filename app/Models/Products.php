<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Products extends Model
{
    //

    protected $table = 'products';

    protected $guarded = [];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function category()
    {
        return $this->belongsTo(CategoryProduct::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImages::class, 'product_id')
            ->where('is_primary', 1);
    }


    protected static function booted()
    {
        static::creating(function ($category) {
            $category->uuid = Uuid::uuid4()->toString();
        });
    }
}
