<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{    
    protected $fillable = [
        'account_id',
        'scholar',
        'slp',
        'team_weight',
        'split',
        'from_date',
        'to_date',
    ];

    protected $casts = [
        'from_date' => 'datetime',
        'to_date' => 'datetime',
    ];
}
