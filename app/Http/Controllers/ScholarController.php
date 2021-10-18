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

class ScholarController extends Controller
{
    //
    public function index()
    {
        $scholars = Scholar::get();

        return view('scholar.index')
            ->with('scholars', $scholars);
    }
    
    public function store(Request $request) 
    {
        $input = $request->all();
        
        $scholar = Scholar::create([
            'first_name' => @$input["first_name"],
            'last_name' => @$input["last_name"],
            'email' => @$input["email"],
            'payment_method' => @$input["payment_method"],
            'payment_account' => @$input["payment_account"],
            'payment_account_number' => @$input["payment_account_number"],
            'mobile' => @$input["mobile"],
            'address' => @$input["address"],
            'referrer' => @$input["referrer"],
            'notes' => @$input["scholar_notes"],
            'discord' => @$input["discord"]
        ]);

        return redirect()->back()->with('success', 'Scholar Added');
    }

    public function view($scholar_id)
    {
        $scholar = Scholar::with(['logs'])->find($scholar_id);

        return view('scholar.view')
            ->with('scholar', $scholar);
    }

    public function edit($scholar_id)
    {
        $scholar = Scholar::find($scholar_id);

        $response_html = view('modals.partials.edit-scholar-form')
            ->with('scholar', $scholar)
            ->render();

        $response = [];
        $response['html'] = $response_html;
        return response($response, 200);
    }

    public function update($scholar_id, Request $request)
    {
        $input = $request->all();

        $scholar = Scholar::find($scholar_id);

        $scholar->update([
            'first_name' => $input["first_name"],
            'last_name' => $input["last_name"],
            'email' => $input["email"],
            'payment_method' => $input["payment_method"],
            'payment_account' => $input["payment_account"],
            'payment_account_number' => $input["payment_account_number"],
            'mobile' => $input["mobile"],
            'address' => $input["address"],
            'address2' => $input["address2"],
            'city' => $input["city"],
            'province' => $input["province"],
            'zip' => $input["zip"],
            'referrer' => $input["referrer"],
            'notes' => $input["scholar_notes"],
            'discord' => $input["discord"]
        ]);

        return redirect()->back()->with('success', 'Scholar Updated');
    }

    public function delete(Request $request)
    {
        $input = $request->all();

        $scholar = Scholar::find($input['scholar_id']);

        $scholar->delete();

        $response = [];
        $response['success'] = true;
        return response($response, 200);
    }
}