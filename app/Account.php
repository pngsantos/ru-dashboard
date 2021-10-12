<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use App\Scholarship;
use App\Payout;
use App\AccountLog;

use Illuminate\Support\Facades\Auth;

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
        'unclaimed_slp',
        'start_date',
        'next_claim_date',
        'owner',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'tags' => 'array',
        'next_claim_date' => 'date',
        'start_date' => 'date'
    ];
    
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    
    public function scholar()
    {
        return $this->hasOne('App\Scholar', 'id', 'scholar_id');
    }
    
    public function axies()
    {
        return $this->hasMany('App\Axie', 'account_id', 'id');
    }
    
    public function logs()
    {
        return $this->hasMany('App\AccountLog', 'account_id', 'id');
    }
    
    public function payouts()
    {
        return $this->hasMany('App\Payout', 'account_id', 'id');
    }
    
    public function scholarships()
    {
        return $this->hasMany('App\Scholarship', 'account_id', 'id');
    }

    public function getStartDateAttribute()
    {
        if(isset($this->attributes['start_date']))
        {
            if($this->attributes['start_date'])
            {
                return $this->start_date;
            }
        }

        return $this->created_at;
    }

    public function getDailyQuotaAttribute()
    {
        return 75;
    }

    public function getWeeklyQuotaAttribute()
    {
        if(!empty(array_intersect(['dev', 'dev team'], array_map('strtolower', $this->tags))))
        {
            return 750;
        }

        return 1000;
    }

    //Override create function to set start date and start balance
    public static function create(array $data = [])
    {
        $data['created_by'] = @Auth::user()->id;

        $account = static::query()->create($data);

        return $account;
    }


    public function save(array $options = [])
    {
        $scholar_id = $this->getOriginal('scholar_id');
        $start_date = $this->getOriginal('start_date');

        $return = parent::save($options);

        //Detect changed scholar
        if($scholar_id != $this->scholar_id)
        {
            if($this->scholar_id)
            {
                if($scholar_id)
                {
                    $scholarship = Scholarship::where('account_id', $this->id)->where('scholar_id', $scholar_id)->first();

                    //End scholarship
                    if($scholarship)
                    {
                        $scholarship->end_date = Carbon::now();
                        $scholarship->save();
                    }
                }

                //Create new scholarship
                if($this->scholar_id)
                {
                    //Create the scholarship
                    $scholarship = Scholarship::create([
                        'account_id' => $this->id,
                        'scholar_id' => $this->scholar_id,
                        'start_date' => $this->start_date,
                        'end_date' => null,
                        'created_by' => $this->created_by,
                    ]);
                }

                $this->create_new_payout();
            }
        }
        elseif($start_date != $this->start_date)
        {
            $this->create_new_payout();
        }

        return $return;
    }

    public function kick_scholar()
    {
        $this->name = $this->code . " - xxx";

        //End current scholarship
        $scholarship = Scholarship::where('account_id', $this->id)->where('scholar_id', $this->scholar_id)->first();

        if($scholarship)
        {
            $scholarship->end_date = Carbon::now();
            $scholarship->save();
        }

        //End current payout
        $payout = Payout::where('account_id', $this->id)->whereDate('to_date', '<=', Carbon::now())->first();

        if($payout)
        {
            $payout->to_date = Carbon::now();
            $payout->save();
        }

        $this->scholar_id = null;
        $this->save();
    }

    private function create_new_payout()
    {
        //End current payout
        $payout = Payout::where('account_id', $this->id)->where(function($query) {
            $query->whereDate('to_date', '>=', Carbon::now())->orWhereNull ('to_date');
        })->first();

        if($payout)
        {
            $payout->to_date = Carbon::now();
            $payout->save();
        }

        //Create the first payout
        Payout::create([
            'account_id' => $this->id,
            'scholar_id' => $this->scholar_id,
            'slp' => null,
            'team_weight' => null,
            'split' => $this->split,
            'from_date' => $this->start_date,
            'to_date' => $this->start_date->addDays(22)->next(Carbon::SATURDAY),
        ]);
    }
}
