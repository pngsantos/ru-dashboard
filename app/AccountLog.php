<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountLog extends Model
{    
    protected $fillable = [
        'account_id',
        'scholar_id',
        'date',
        'slp',
        'slp_scholar',
        'unclaimed_slp',
        'notes',
    ];

    protected $casts = [
        'date' => 'date:Y-m-d'
    ];
    
    public function account()
    {
        return $this->belongsTo('App\Account', 'account_id', 'id');
    }
    
    public function scholar()
    {
        return $this->belongsTo('App\Scholar', 'scholar_id', 'id');
    }
}
