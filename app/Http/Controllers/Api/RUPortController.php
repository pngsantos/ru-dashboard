<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

use App\Account;
use App\AccountLog;

use Illuminate\Support\Str;

class RUPortController extends Controller
{
    public function get_token(Request $request)
    {
        $token = $request->header('token');

        if(@$token != config('services.p2eb.key'))
        {
            $response = [];
            $response['error'] = "Invalid key";

            return response($response, 500); 
        }

        $input = $request->all();

        $account = Account::where('code', $input['code'])->first();

        if(!$account)
        {
            $response = [];
            $response['error'] = "Invalid account";

            return response($response, 500); 
        }

        if($account->p2eb_token == "")
        {
            //Generate random token
            $token = Str::random(32);

            $account->update(['p2eb_token' => $token]);
        }
        else
        {
            $token = $account->p2eb_token;
        }

        $response = [];
        $response['token'] = $token;

        return response($response, 200); 
    }

    public function get_scholar_info(Request $request)
    {
        $token = $request->header('token');

        if(@$token != config('services.p2eb.key'))
        {
            $response = [];
            $response['error'] = "Invalid key";

            return response($response, 500); 
        }

        $input = $request->all();

        $account = Account::with(['scholar'])->where('code', $input['code'])->first();

        if(!$account)
        {
            $response = [];
            $response['error'] = "Invalid account";

            return response($response, 500); 
        }

        $response = [];
        $response['data'] = [
            'first_name' => $account->scholar->first_name,
            'last_name' => $account->scholar->last_name,
            'email' => $account->scholar->email,
        ];

        return response($response, 200); 
    }

    public function get_account_logs(Request $request)
    {
        
    }
}
