<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Shipment extends Model
{
    protected $table = 'shipments';

    protected $guarded = [];

    protected $casts = [
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($shipment) {
            $shipment->uuid = Uuid::uuid4()->toString();
        });
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
