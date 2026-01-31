<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnItem extends Model
{
    protected $table = 'return_items';
    protected $guarded = [];

    public function returnRequest()
    {
        return $this->belongsTo(ReturnRequest::class, 'return_id');
    }
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
