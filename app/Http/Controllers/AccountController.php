<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Account;
use App\Scholar;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

use App\Imports\AccountsImport;
use Maatwebsite\Excel\Facades\Excel;

class AccountController extends Controller
{
    //
    public function store(Request $request) 
    {
        $input = $request->all();
        // dd($input);

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

        $account = Account::create([
            'name' => $input['name'],
            'code' => $input['code'],
            'scholar_id' => $scholar->id,
            'user_id' => @Auth::user()->id,
            'ronin_address' => $input['ronin_address'],
            'tags' => @$input['tags'],
            'split' => $input['split'],
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
}