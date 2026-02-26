<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Subscription extends Model
{
    protected $table = 'subscriptions';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::creating(function ($subscription) {
            $subscription->uuid = Uuid::uuid4()->toString();
        });
    }
}
