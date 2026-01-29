<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class CategoryProduct extends Model
{
    //
    protected $table = 'categories';

    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function ($category) {
            $category->uuid = Uuid::uuid4()->toString();
        });
    }

    public function products()
    {
        return $this->hasMany(Products::class, 'category_id');
    }
}
