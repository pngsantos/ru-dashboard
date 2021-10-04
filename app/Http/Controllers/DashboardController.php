<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;

use App\User;
use App\Account;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    //
    public function index() 
    {   

        return view('dashboard');
    }

    public function tracker() 
    {   
        $accounts = Account::get();

        return view('tracker')
            ->with('accounts', $accounts);
    }
}