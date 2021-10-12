<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Axie extends Model
{    
    protected $fillable = [
        'axie_id',
        'stage',
        'name',
        'breed',
        'ronin_address',
        'class',
        'image',
        'parts'
    ];

    protected $casts = [
        'parts' => 'array'
    ];
    
    public function account()
    {
        return $this->belongsTo('App\Account', 'account_id', 'id');
    }
    
}
