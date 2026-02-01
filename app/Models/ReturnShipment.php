<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnShipment extends Model
{
    protected $table = 'return_shipments';
    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function ($shipment) {
            $shipment->uuid = \Ramsey\Uuid\Uuid::uuid4()->toString();
        });
    }

    protected $casts = [
        'shipped_at' => 'datetime',
        'received_at' => 'datetime',
    ];

    public function returnRequest()
    {
        return $this->belongsTo(ReturnRequest::class, 'return_id');
    }
}
