<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{    
    protected $fillable = [
        'name',
        'code',
        'scholar_id',
        'user_id',
        'ronin_address',
        'tags',
        'split',
        'mmr',
        'next_claim_date',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'tags' => 'array'
    ];
    
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    
    public function scholar()
    {
        return $this->hasOne('App\Scholar', 'id', 'scholar_id');
    }
}
