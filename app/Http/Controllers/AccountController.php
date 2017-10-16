<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Models\Application;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $user = \Auth::user();
        if(str_contains($user->email,'@fb.com')){
            return view('account.change_email',compact('user'));    
        }
        return view('account.index',compact('user'));
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postIndex(Request $request)
    {
        $rules = ['name'=>'required'];
        $validator = \Validator::make($request->all(),$rules);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        $user = \Auth::user();
        $user->name = $request->get('name');
        $user->username = $request->get('username');
        $user->save();
        return back();
    }

    public function postEmail(Request $request)
    {
        $rules = ['email'=>'required|email|unique:users','username'=>'required|alpha_num|unique:users,id'];
        $validator = \Validator::make($request->all(),$rules);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        $user = \Auth::user();
        $user->email = $request->get('email');
        $user->username = $request->get('username');
        $user->save();
        return back();
    }
}
