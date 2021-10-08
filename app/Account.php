<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Scholarship;

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
        'next_claim_date',
        'owner',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'tags' => 'array',
        'next_claim_date' => 'date'
    ];
    
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    
    public function scholar()
    {
        return $this->hasOne('App\Scholar', 'id', 'scholar_id');
    }
    
    public function logs()
    {
        return $this->hasMany('App\AccountLog', 'account_id', 'id');
    }

    //Override create function to set start date and start balance
    public static function create(array $data = [])
    {
        if(isset($data['scholar_id']))
        {
            //Create a new scholarship
        }

        $model = static::query()->create($data);

        return $model;
    }


    public function save(array $options = [])
    {
        $account = $this;

        $return = parent::save($options);


        return $return;
    }

    public function update(array $attributes = [], array $options = [])
    {
        $account = $this;

        $return = parent::update($attributes, $options);

        return $return;
    }

    public function kick_scholar()
    {
        $this->name = $this->code . " - xxx";

        $this->scholar_id = null;
        $this->save();
    }
}
