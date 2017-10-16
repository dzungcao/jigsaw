<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $gUser = Socialite::driver('google')->user();

        $user = User::where('email',$gUser->email)->first();
        if(!$user){
            $user = User::create(['email'=>$gUser->email,'name'=>$gUser->name,'password'=>str_random(8)]);
        }

        \Auth::login($user);
        return redirect('/');
    }
}
