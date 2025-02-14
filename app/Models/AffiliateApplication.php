<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateApplication extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'referral_code',
        'approved_at',
    ];

    // Hide the password from JSON responses.
    protected $hidden = ['password'];
}
