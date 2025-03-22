<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPaymentDetail extends Model
{
    protected $fillable = ['user_id', 'paypal_email', 'paypal_username', 'paypal_phone'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
