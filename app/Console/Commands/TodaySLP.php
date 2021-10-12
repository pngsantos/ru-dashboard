<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Account;
use App\AccountLog;
use Illuminate\Support\Facades\Http;


use Carbon\Carbon;

class TodaySLP extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'TodaySLP:pull';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull SLP from API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = Carbon::now()->subDay();
        $accounts = Account::whereNotNull('ronin_address')->get();

        foreach($accounts as $account)
        {
            //Query logs
            $logs = AccountLog::where('account_id', $account->id)->where('date', $date->format('Y-m-d'))->get();
            
            if($logs->count() < 1)
            {
                $ronin_address = str_replace("ronin:", "0x", $account->ronin_address);
                
                //Get from API
                $response = Http::retry(5, 100)->get('https://game-api.skymavis.com/game-api/clients/'.$ronin_address.'/items/1');

                $data = $response->object();

                if($data->success)
                {
                    
                    $last_claimed = Carbon::parse($data->last_claimed_item_at);
                    $prev = AccountLog::where('account_id', 1)->where('date', $date->copy()->subDays(1)->format('Y-m-d'))->first();

                    if(!$prev)
                    {
                        $slp = $data->total;
                    }
                    elseif($account->next_claim_date->isBefore($last_claimed))
                    {
                        $slp = $data->total;
                    }
                    elseif( ($data->total - $prev->slp) <= 0)
                    {
                        $slp = $data->total;
                    }
                    else
                    {
                        $slp = $data->total - $prev->slp;
                    }

                    $prev = $slp;

                    AccountLog::create( [
                        'account_id' => $account->id,
                        'scholar_id' => $account->scholar_id,
                        'date' => $date,
                        'slp' => $slp,
                        'unclaimed_slp' => $data->total,
                        'slp_scholar' => 0,
                    ]);

                    $account->update(['unclaimed_slp' => $data->total, 'next_claim_date' => $last_claimed->copy()->addDays(7)]);

                    echo "Updated account $account->id-$account->ronin_address \n";
                }
            }
        }

        return 0;
    }
}
