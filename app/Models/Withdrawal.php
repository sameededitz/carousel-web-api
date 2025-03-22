<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'paypal_email',
        'paypal_username',
        'paypal_phone',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
