<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{    
    protected $fillable = [
        'account_id',
        'scholar_id',
        'start_date',
        'end_date',
        'created_by',
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
