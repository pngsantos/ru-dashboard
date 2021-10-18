<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Payout extends Model
{    
    protected $fillable = [
        'account_id',
        'scholar_id',
        'status',
        'slp',
        'usd',
        'team_weight',
        'split',
        'balance',
        'from_date',
        'to_date',
        'bonus',
    ];

    protected $casts = [
        'from_date' => 'datetime',
        'to_date' => 'datetime',
    ];
    
    public function account()
    {
        return $this->belongsTo('App\Account', 'account_id', 'id');
    }
    
    public function scholar()
    {
        return $this->belongsTo('App\Scholar', 'scholar_id', 'id');
    }

    public function getDiffDaysAttribute()
    {
        if($this->to_date->isPast())
        {
            return $this->to_date->diffInDays($this->from_date);
        }
        else
        {
            return Carbon::now()->diffInDays($this->from_date);
        }
    }

    public function getWeightAttribute()
    {
        if($this->team_weight)
        {
            return $this->team_weight;
        }

        return ($this->diff_days/14);
    }

    public function getCanFinalizeAttribute()
    {
        if($this->status == 'final')
        {
            return false;
        }

        return !$this->to_date->isFuture();
    }
}
