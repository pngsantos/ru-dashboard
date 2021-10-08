<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Account;
use App\AccountLog;
use App\Scholar;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

use App\Imports\AccountsImport;
use App\Imports\LogsImport;
use Maatwebsite\Excel\Facades\Excel;

class AccountController extends Controller
{
    //
    public function index($account_id)
    {
        $account = Account::with(['logs'])->find($account_id);

        return view('account.view')
            ->with('account', $account);
    }
    
    public function store(Request $request) 
    {
        $validated = $request->validate([
            'ronin_address' => 'required|unique:accounts|max:255'
        ]);

        $input = $request->all();
        // dd($input);

        if(isset($data['email']))
        {
            $scholar = Scholar::create([
                'first_name' => $input["first_name"],
                'last_name' => $input["last_name"],
                'email' => $input["email"],
                'payment_method' => $input["payment_method"],
                'payment_account' => $input["payment_account"],
                'payment_account_number' => $input["payment_account_number"],
                'mobile' => $input["mobile"],
                'address' => $input["address"],
                'referrer' => $input["referrer"],
                'notes' => $input["scholar_notes"],
                'discord' => $input["discord"]
            ]);
        }

        $account = Account::create([
            'name' => $input['name'],
            'code' => $input['code'],
            'scholar_id' => @$scholar->id,
            'user_id' => @Auth::user()->id,
            'ronin_address' => $input['ronin_address'],
            'tags' => @$input['tags'],
            'split' => $input['split'],
            'owner' => $input["owner"],
            'notes' => $input["notes"],
            'created_by' => @Auth::user()->id,
        ]);

        return redirect()->back()->with('success', 'Account Added');
    }

    public function import(Request $request) 
    {
        $input = $request->all();

        if($request->hasFile('import_file'))
        {
            $file = $request->file('import_file');
            $path1 = $file->storeAs(
                'temp', 'import_file.'.$file->extension()
            ); 
            $path = storage_path('app').'/'.$path1;  

            Excel::import(new AccountsImport, $path);
        }

        return redirect()->back()->with('success', 'Accounts Added');
    }

    public function import_logs(Request $request) 
    {
        $input = $request->all();

        if($request->hasFile('import_file'))
        {
            $file = $request->file('import_file');
            $path1 = $file->storeAs(
                'temp', 'import_file.'.$file->extension()
            ); 
            $path = storage_path('app').'/'.$path1;  

            Excel::import(new LogsImport, $path);
        }

        return redirect()->back()->with('success', 'Logs Added');
    }

    public function view($account_id)
    {
        $account = Account::with(['logs'])->find($account_id);

        return view('account.view')
            ->with('account', $account);
    }

    public function edit($account_id)
    {
        $account = Account::with(['logs', 'scholar'])->find($account_id);


        $response_html = view('modals.partials.edit-account-form')
            ->with('account', $account)
            ->render();

        $response = [];
        $response['html'] = $response_html;
        return response($response, 200);
    }

    public function update($account_id, Request $request)
    {
        $input = $request->all();

        $account = Account::find($account_id);

        $account->update([
            'name' => $input['name'],
            'code' => $input['code'],
            'ronin_address' => $input['ronin_address'],
            'tags' => @$input['tags'],
            'split' => $input['split'],
            'owner' => $input["owner"],
            'notes' => $input["notes"]
        ]);

        if($account->scholar)
        {
            if($account->scholar->email && ($account->scholar->email == $input["email"]))
            {
                $account->scholar->update([
                    'first_name' => $input["first_name"],
                    'last_name' => $input["last_name"],
                    'email' => $input["email"],
                    'payment_method' => $input["payment_method"],
                    'payment_account' => $input["payment_account"],
                    'payment_account_number' => $input["payment_account_number"],
                    'mobile' => $input["mobile"],
                    'address' => $input["address"],
                    'referrer' => $input["referrer"],
                    'notes' => $input["scholar_notes"],
                    'discord' => $input["discord"]
                ]);
            }
            else
            {
                $scholar = Scholar::create([
                    'first_name' => $input["first_name"],
                    'last_name' => $input["last_name"],
                    'email' => $input["email"],
                    'payment_method' => $input["payment_method"],
                    'payment_account' => $input["payment_account"],
                    'payment_account_number' => $input["payment_account_number"],
                    'mobile' => $input["mobile"],
                    'address' => $input["address"],
                    'referrer' => $input["referrer"],
                    'notes' => $input["scholar_notes"],
                    'discord' => $input["discord"]
                ]);

                $account->scholar_id = $scholar->id;
                $account->save();
            }
        }
        else
        {
            $scholar = Scholar::create([
                'first_name' => $input["first_name"],
                'last_name' => $input["last_name"],
                'email' => $input["email"],
                'payment_method' => $input["payment_method"],
                'payment_account' => $input["payment_account"],
                'payment_account_number' => $input["payment_account_number"],
                'mobile' => $input["mobile"],
                'address' => $input["address"],
                'referrer' => $input["referrer"],
                'notes' => $input["scholar_notes"],
                'discord' => $input["discord"]
            ]);
        }

        return redirect()->back()->with('success', 'Account Added');
    }

    public function pull_slp(Request $request)
    {
        $input = $request->all();

        $account = Account::find($input['account_id']);
        $date = Carbon::now();

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

                return redirect()->back()->with('success', 'SLP logged');
            }
        }

        return redirect()->back()->with('success', 'SLP already pulled');
    }

    public function kick_scholar(Request $request)
    {
        $input = $request->all();

        $account = Account::find($input['account_id']);
        $account->kick_scholar();

        $response = [];
        $response['success'] = true;
        return response($response, 200);
    }

    public function edit_log($log_id)
    {
        
        $log = AccountLog::find($log_id);


        $response_html = view('modals.partials.edit-log-form')
            ->with('log', $log)
            ->render();

        $response = [];
        $response['html'] = $response_html;
        return response($response, 200);
    }

    public function update_log($log_id, Request $request)
    {
        $input = $request->all();

        $log = AccountLog::find($log_id);

        if(Auth::check())
        {
            if($log->slp == 0)
            {
                $log->update(['slp' => $input['slp'], 'slp_scholar' => $input['slp_scholar']]);
            }
            else
            {
                $log->update(['slp_scholar' => $input['slp_scholar']]);
            }
        }
        else
        {
        }

        return redirect()->back()->with('success', 'Daily log updated');
    }

    public function delete(Request $request)
    {
        $input = $request->all();

        $account = Account::find($input['account_id']);

        $account->delete();

        $response = [];
        $response['success'] = true;
        return response($response, 200);
    }
}