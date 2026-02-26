<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Products extends Model
{
    //

    protected $table = 'products';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
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

    public function images()
    {
        return $this->hasMany(ProductImages::class, 'product_id');
    }


    protected static function booted()
    {
        static::creating(function ($category) {
            $category->uuid = Uuid::uuid4()->toString();
        });
    }
}
