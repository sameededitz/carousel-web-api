<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Earning extends Model
{
    protected $fillable = ['user_id', 'referred_user_id', 'amount', 'purchase_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function referredUser()
    {
        return $this->belongsTo(User::class, 'referred_user_id');
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}
