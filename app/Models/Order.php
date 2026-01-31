<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Order extends Model
{
    protected $table = 'orders';

    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function ($order) {
            $order->uuid = Uuid::uuid4()->toString();
            $order->order_code = 'ORD-' . strtoupper(uniqid());
        });
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}
