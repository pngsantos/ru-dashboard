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
    protected $last_cutoff;
    protected $next_payout;

    protected $fillable = [
        'name',
        'group_id',
        'code',
        'scholar_id',
        'user_id',
        'ronin_address',
        'tags',
        'split',

        /* Game data */
        'mmr',
        'unclaimed_slp',
        'next_claim_date',

        /* Onboarding */
        'start_date',
        'balance',
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

    public function current_payout()
    {
        return $this->hasOne('App\Payout', 'account_id', 'id')->orderBy('to_date', 'desc')->latest();
    }

    public function getIsFirstPayoutAttribute()
    {
        $payout = $this->date_started->next(Carbon::SATURDAY)->addDays(14);

        return (!$payout->isPast());
    }

    public function getDateStartedAttribute()
    {
        if($this->start_date)
        {
            return (Carbon::parse($this->start_date));
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

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if(isset($attributes['last_cutoff']))
        {
            $this->last_cutoff = $attributes['last_cutoff'];
        }

        if(isset($attributes['next_payout']))
        {
            $this->next_payout = $attributes['next_payout'];
        }
    }

    //Override create function to set start date and start balance
    public static function create(array $data = [])
    {
        $data['created_by'] = @Auth::user()->id;

        $account = static::query()->create($data);

        return $account;
    }

    public function update(array $attributes = [], array $options = [])
    {
        if(isset($attributes['last_cutoff']))
        {
            $this->last_cutoff = $attributes['last_cutoff'];
        }

        if(isset($attributes['next_payout']))
        {
            $this->next_payout = $attributes['next_payout'];
        }

        $return = parent::update($attributes, $options);

        return $return;
    }

    public function getCurrentScholarshipAttribute()
    {
        $scholarship = Scholarship::where('account_id', $this->id)->where('scholar_id', $this->scholar_id)->orWhereNull('end_date')->limit(1)->first();

        return $scholarship;
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
                        'start_date' => $this->scholar_start_date ? $this->scholar_start_date : $this->date_started,
                        'end_date' => null,
                        'created_by' => $this->created_by,
                    ]);
                }

                $this->create_new_payout(@$this->last_cutoff, @$this->next_payout);
            }
            else
            {
                
            }
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

    public function create_new_payout($start_date = false, $end_date = false)
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

        if($start_date)
        {
            $start_date = Carbon::parse($start_date);

            if($end_date)
            {
                $end_date = Carbon::parse($end_date);
            }
            else
            {
                $end_date = $start_date->addDays(14);
            }
        }
        else if($end_date)
        {
            $end_date = Carbon::parse($end_date);
            $start_date = $end_date->subDays(14);
        }
        else
        {
            $start_date = $this->date_started;
            $end_date = $this->date_started->next(Carbon::SATURDAY)->addDays(14);
        }

        //Check if new account

        if($end_date->isPast())
        {
            //Compute next payout
            $next_saturday = Carbon::now()->next(Carbon::SATURDAY);

            if($next_saturday->diffInDays($end_date) % 14 == 0)
            {
                $new_payout = Payout::create([
                    'account_id' => $this->id,
                    'scholar_id' => $this->scholar_id,
                    'slp' => null,
                    'team_weight' => null,
                    'split' => $this->split,
                    'from_date' => Carbon::now()->next(Carbon::SATURDAY)->subDays(14),
                    'balance' => null,
                    'to_date' =>  Carbon::now()->next(Carbon::SATURDAY),
                ]);
            }
            else
            {
                $new_payout = Payout::create([
                    'account_id' => $this->id,
                    'scholar_id' => $this->scholar_id,
                    'slp' => null,
                    'team_weight' => null,
                    'split' => $this->split,
                    'from_date' => Carbon::now()->next(Carbon::SATURDAY)->subDays(7),
                    'balance' => null,
                    'to_date' =>  Carbon::now()->next(Carbon::SATURDAY)->addDays(7),
                ]);
            }
            
        }
        else
        {
            //Create the first payout
            $new_payout = Payout::create([
                'account_id' => $this->id,
                'scholar_id' => $this->scholar_id,
                'slp' => null,
                'team_weight' => null,
                'split' => $this->split,
                'from_date' => $start_date,
                'balance' => $this->balance,
                'to_date' => $end_date,
            ]);
        }

        return $new_payout;
    }

    /*

        elseif($start_date != $this->start_date)
        {
            if($this->start_date->isBefore($start_date))
            {
                if($this->current_payout)
                {
                    $this->current_payout->update([
                        'from_date' => $this->date_started,
                        'balance' => $this->balance,
                        'to_date' => $this->date_started->next(Carbon::SATURDAY)->addDays(14),
                    ]);
                }
                else
                {
                    $this->create_new_payout();
                }
            }
            else
            {
                $this->create_new_payout();
            }
            
        }
    */
}
