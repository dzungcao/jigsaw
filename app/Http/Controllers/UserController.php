<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Models\Application;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $users = User::all();
        return view('user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCreate()
    {
        $users = User::all();
        return view('user.index',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getView($id)
    {
        if(\Input::has('application')){
            $applications = Application::where('user_id',$id)->get();
        }else{
            $applications = [];
        }
        $user = User::findOrFail($id);
        return view('user.view',compact('user','applications'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getEdit($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postEdit(Request $request, $id)
    {

        if(!\Auth::user()->admin){
            abort(404);
        }
        $user = User::findOrFail($id);
        $rules = array();
        $validator = \Validator::make($request->all(),$rules);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        $inputs = $request->all();
        $inputs['admin'] = isset($inputs['admin']) ? true:false;
        $inputs['manager'] = isset($inputs['manager']) ? true:false;
        $inputs['user'] = isset($inputs['user']) ? true:false;
        $user->fill($inputs);
        $user->save();
        return back();
    }
}
