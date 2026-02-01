<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnRequest extends Model
{
    protected static function booted()
    {
        static::creating(function ($return) {
            $return->uuid = \Ramsey\Uuid\Uuid::uuid4()->toString();
        });
    }
    protected $table = 'returns';
    protected $guarded = [];

    protected $casts = [
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'image' => 'string',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
    public function items()
    {
        return $this->hasMany(ReturnItem::class, 'return_id');
    }
    public function shipment()
    {
        return $this->hasOne(ReturnShipment::class, 'return_id');
    }
    public function refund()
    {
        return $this->hasOne(Refund::class, 'return_id');
    }

    /**
     * Get seller return address
     */
    public function getReturnAddressAttribute($value)
    {
        return $value;
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeColorAttribute()
    {
        return match ($this->return_status) {
            'requested' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            'item_sent_back' => 'info',
            'item_received' => 'primary',
            'refunded' => 'success',
            default => 'secondary',
        };
    }

    /**
     * Get status label in Indonesian
     */
    public function getStatusLabelAttribute()
    {
        return match ($this->return_status) {
            'requested' => 'Diajukan',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'item_sent_back' => 'Barang Dikirim',
            'item_received' => 'Barang Diterima',
            'refunded' => 'Dana Dikembalikan',
            default => ucfirst($this->return_status),
        };
    }
}
