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
        if (Auth::check()) {
            //
            return redirect()->route('tracker')->with('success', 'Welcome back!');
        }

        return view('login');
    }

    public function do_login(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);


         if (Auth::attempt(['email' => $input['email'], 'password' => $input['password']], isset($input['remember-me']))) {
            $user = User::findOrFail(Auth::user()->id);
            $user->save();

            Auth::login($user, isset($input['remember-me']));

            return redirect()->route('tracker')->with('success', 'Welcome back!');
        } 
        else 
        {
            return back()->with('error', 'Email and/or password invalid.');
        }
    }

    public function do_logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}