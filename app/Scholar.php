<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scholar extends Model
{    
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'payment_method',
        'payment_account',
        'payment_account_number',
        'mobile',
        'address',
        'discord',
        'referrer',
        'notes',
    ];
}
