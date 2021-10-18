<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

use App\User;
use App\Axie;
use App\Account;
use App\AccountLog;
use App\Payout;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\LogExports;

class DashboardController extends Controller
{
    //
    public function index() 
    {   

        return view('dashboard');
    }

    public function tracker() 
    {   
        $accounts = Account::with(['logs' => function($query) {
            $query->whereDate('date', '<=', Carbon::today())->orderBy('date', 'desc')->limit(2);
        }])->get();

        return view('tracker')
            ->with('accounts', $accounts);
    }

    public function daily_log(Request $request) 
    {   
        $input = $request->all();

        $start_date = Carbon::now()->subDays(14);
        if(isset($input['start_date']))
        {
            $start_date = Carbon::parse($input['start_date']);
        }

        $end_date = Carbon::now();
        if(isset($input['end_date']))
        {
            $end_date = Carbon::parse($input['end_date']);
        }

        $period = CarbonPeriod::create($start_date, $end_date);

        $accounts = Account::with(['logs' => function($query) use ($end_date, $start_date) {
            $query->whereDate('date', '<=', $end_date)->whereDate('date', '>=', $start_date)->orderBy('date', 'desc');
        }])->get();

        return view('daily_log')
            ->with('period', $period)
            ->with('accounts', $accounts);
    }

    public function export_logs(Request $request)
    {
        $input = $request->all();

        $start_date = Carbon::now()->subDays(14);
        if(isset($input['start_date']))
        {
            $start_date = Carbon::parse($input['start_date']);
        }

        $end_date = Carbon::now();
        if(isset($input['end_date']))
        {
            $end_date = Carbon::parse($input['end_date']);
        }

        return Excel::download(new LogExports($start_date, $end_date), "Tests.xlsx");

        /*

        $logs = AccountLog::with(['account'])->whereDate('date', '<=', $end_date)->whereDate('date', '>=', $start_date)->orderBy('date', 'desc')->get();

        $log_array = $logs->map->only('date_string', 'account.code', 'slp')->all();
        */
    }

    public function axies()
    {
        $axies = Axie::get();

        return view('axies')
            ->with('axies', $axies);
    }

    public function inventory()
    {
        $accounts = Account::get();

        $owners = $accounts->groupBy('owner');

        return view('inventory')
            ->with('owners', $owners)
            ->with('accounts', $accounts);
    }

    public function distros()
    {
        $accounts = Account::with(['logs'])->get();

        return view('distros')
            ->with('accounts', $accounts);
    }

    public function payouts()
    {
        $accounts = Account::with(['logs'])->limit(50)->get();

        foreach($accounts as $account)
        {
            $payout = $account->current_payout;

            if($payout)
            {
                $log = AccountLog::where('account_id', $account->id)->whereDate('date', '>=', $payout->from_date)->whereDate('date', '<=', $payout->to_date)->get();
            }
            else
            {
                $log = collect([(object)['slp' => '0']]);
            }

            $account->scope = $log;
        }

        return view('payouts')
            ->with('accounts', $accounts);
    }

    public function test()
    {
        $date = Carbon::now();

        $account = Account::find(1);
        $ronin_address = Str::replaceFirst("ronin:", "0x", $account->ronin_address);

        $response = Http::post('https://axieinfinity.com/graphql-server-v2/graphql', [
            'query' => "query GetAxieBriefList(\$auctionType: AuctionType, \$criteria: AxieSearchCriteria, \$from: Int, \$sort: SortBy, \$size: Int, \$owner: String) {\r\n    axies(auctionType: \$auctionType, criteria: \$criteria, from: \$from, sort: \$sort, size: \$size, owner: \$owner) {\r\n        total\r\n        results {\r\n        ...AxieBrief\r\n        __typename\r\n        }\r\n        __typename\r\n    }\r\n  }\r\n\r\nfragment AxieBrief on Axie {\r\n  id\r\n  name\r\n  stage\r\n  class\r\n  breedCount\r\n  image\r\n  title\r\n  battleInfo {\r\n    banned\r\n    __typename\r\n  }\r\n  auction {\r\n    currentPrice\r\n    currentPriceUSD\r\n    __typename\r\n  }\r\n  parts {\r\n    id\r\n    name\r\n    class\r\n    type\r\n    specialGenes\r\n    __typename\r\n  }\r\n  __typename\r\n  }\r\n",
            'variables' => '{"from":0,"owner":"'.$ronin_address.'","size":24,"sort":"IdDesc"}'
        ]);

        $data = $response->object();

        // dd($data->data);

        foreach($data->data->axies->results as $axie)
        {
            $dupe = Axie::where('axie_id', $axie->id)->first();

            if($dupe)
            {
                $dupe->update([
                    'stage' => $axie->stage,
                    'breed' => $axie->breedCount,
                    'ronin_address' => $ronin_address,
                    'class' => $axie->class,
                    'image' => $axie->image,
                    'parts' => $axie->parts
                ]);
                echo "Axie updated \n";

            }
            else
            {
                Axie::create([
                    'axie_id' => $axie->id,
                    'stage' => $axie->stage,
                    'breed' => $axie->breedCount,
                    'ronin_address' => $ronin_address,
                    'class' => $axie->class,
                    'image' => $axie->image,
                    'parts' => $axie->parts
                ]);
                echo "Axie created \n";
            }
        }



        /*

        $response = Http::retry(5, 100)->get('https://game-api.skymavis.com/game-api/clients/'.$ronin_address.'/items/1');

        $data = $response->object();
        // dd($data);

        if($data->success)
        {
            //Query logs
            $logs = AccountLog::where('account_id', $account->id)->where('date', $date->format('Y-m-d'))->get();

            if($logs->count() < 1)
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
            }
        }
        */
    }
}