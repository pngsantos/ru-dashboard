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

        $rate = 0.01 * (100 - $payout->split) * $input['rate'];

        $payout->update(['status' => 'final', 'usd' => $rate * $logs->sum('slp'), 'slp' => $logs->sum('slp'), 'bonus' => $input['bonus'], 'team_weight' => $input['team_weight']]);

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

    public function edit($payout_id)
    {
        $payout = Payout::find($payout_id);

        $response_html = view('modals.partials.edit-payout-form')
            ->with('payout', $payout)
            ->render();

        $response = [];
        $response['html'] = $response_html;
        return response($response, 200);
    }

    public function update($payout_id, Request $request)
    {
        $input = $request->all();

        $payout = Payout::find($payout_id);

        $payout->update([
            'from_date' => $input["from_date"],
            'to_date' => $input["to_date"],
            'balance' => $input["balance"],
            'split' => $input["split"],
            'bonus' => $input["bonus"]
        ]);
        $payout->refresh();

        return redirect()->back()->with('success', 'Payout Updated');
    }
}