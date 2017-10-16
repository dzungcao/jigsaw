<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Socialite;

class FacebookAuthController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $fUser = Socialite::driver('facebook')->user();
        $email = $fUser->email;
        if(!$fUser->email){
            $fUser->email = $fUser->id.'@fb.com';
        }

        $user = User::where('email',$fUser->email)->first();
        if(!$user){
            $user = User::create(['email'=>$fUser->email,'name'=>$fUser->name,'password'=>str_random(8),'username'=>$fUser->id]);
            if($email){
                /*\Mail::send('emails.fb_account_created', ['name'=>$fbUser->name], function ($m) use ($email) {
                    $m->to($email)->subject('Your account has been created');
                });*/
            }
        }
        $user->avatar = $fUser->avatar;
        $user->save();
        
        \Auth::login($user);
        return redirect('/');
    }
}
