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
        'address2',
        'city',
        'province',
        'zip',
        'discord',
        'referrer',
        'notes',
    ];

    public function getNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }
    
    public function payouts()
    {
        return $this->hasMany('App\Payout', 'scholar_id', 'id');
    }
    
    public function scholarships()
    {
        return $this->hasMany('App\Scholarship', 'account_id', 'id');
    }
}
