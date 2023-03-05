<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountCreation;

class GithubController extends Controller
{
    function redirect(){
        return Socialite::driver('github')->redirect();
    }
    function callback(){
        $user = Socialite::driver('github')->user();
        $generated_password = Str::random(8);
        User::insert([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => bcrypt($generated_password),
            'created_at' => Carbon::now(),
            'role' => 'customer'
        ]);

        if(Auth::attempt([
            'email' => $user->getEmail(),
            'password' => $generated_password
        ])){
            // email send start
                $info = [
                    'email' => $user->getEmail(),
                    'name' => $user->getName(),
                    'password' => $generated_password,
                    'role' => 'customer'
                ];
                Mail::to($user->getEmail())->send(new AccountCreation($info));
            // email send end
            return redirect('dashboard');
        }
    }
}
