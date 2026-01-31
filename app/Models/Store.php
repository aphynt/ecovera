<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Store extends Model
{
    //
    protected $table = 'stores';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::creating(function ($category) {
            $category->uuid = Uuid::uuid4()->toString();
        });
    }
}
