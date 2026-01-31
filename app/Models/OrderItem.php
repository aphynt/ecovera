<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class OrderItem extends Model
{
    protected $table = 'order_items';

    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function ($item) {
            $item->uuid = Uuid::uuid4()->toString();
        });
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
