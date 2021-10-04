<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;

use App\User;
use App\Account;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    //
    public function login() 
    {   
        return view('login');
    }

    public function do_login(Request $request)
    {
        $input = $request->all();

         if (Auth::attempt(['email' => $input['email'], 'password' => $input['password']])) {
            $user = User::findOrFail(Auth::user()->id);
            $user->save();

            return redirect()->route('tracker')->with('success', 'Welcome back!');
        } 
        else 
        {
            return back()->with('error-big', 'Email and/or password invalid.');
        }
    }
}