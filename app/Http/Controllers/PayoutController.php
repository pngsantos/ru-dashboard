<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Payout;
use App\Account;
use App\AccountLog;
use App\Scholar;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PayoutController extends Controller
{
    //
    public function initialize()
    {
        $accounts = Account::whereNotNull('scholar_id')->get();

        foreach($accounts as $account)
        {
            
        }
    }

    public function finalize(Request $request)
    {
        $input = $request->all();

        $payout = Payout::find($input['id']);

        $logs = AccountLog::where('account_id', $payout->account->id)->whereDate('date', '>=', $payout->from_date)->whereDate('date', '<=', $payout->to_date)->get();

        $payout->update(['status' => 'final', 'slp' => $logs->sum('slp'), 'team_weight' => $input['team_weight']]);

        //Create a new payout
        $new = Payout::create([
            'account_id' => $payout->account_id,
            'scholar_id' => $payout->scholar_id,
            'slp' => null,
            'team_weight' => null,
            'split' => $payout->account->split,
            'from_date' => $payout->to_date->addDay(),
            'balance' => null,
            'to_date' => $payout->to_date->next(Carbon::SATURDAY),
        ]);

        $response = [];
        $response['success'] = true;
        return response($response, 200);
    }
}