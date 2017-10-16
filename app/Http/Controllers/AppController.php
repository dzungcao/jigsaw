<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Field;
use App\Models\Application;
use App\Models\ContactForm;
use App\Models\Background;
use App\Models\ButtonTemplate;

class AppController extends Controller
{
    public function dashboard(){

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $applications = Application::where('user_id',\Auth::user()->id)
                                    ->where('temp',0)
                                    ->get();
        return view('application.index',compact('applications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $forms = ContactForm::all();
        return view('application.create',compact('forms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = ['form_id'=>'required','title'=>'required'];
        $validator = \Validator::make($request->all(),$rules);
        if($validator->fails()){
            return back()->withInput()->withErrors($validator);
        }
        $inputs = $request->all();
        $inputs['user_id'] = \Auth::user()->id;
        $inputs['key'] = md5(strtolower(str_random(16)));
        $form = ContactForm::find($request->get('form_id'));
        $app = Application::create($inputs);
        $app->build($form);
        return redirect('app');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $application = Application::findOrFail($id);
        $application->checkOwner();
        return view('application.view',compact('application'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $application = Application::findOrFail($id);
        $application->checkOwner();
        $templates = ButtonTemplate::all();
        $backgrounds = Background::where('guest',true)->where('active',true)->get();
        return view('application.edit',compact('application','backgrounds','templates'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = ['title'=>'required'];
        $validator = \Validator::make($request->all(),$rules);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        $app = Application::findOrFail($id);
        $app->checkOwner();
        $app->fill($request->all());
        $app->updateFields($request->get('label'));
        $app->save();
        if($request->has('request_type')){
            return \Response::json(['success'=>true,'text'=>\View::make('application.app_json',compact('app'))->render()]);
        }
        return redirect('app/'.$id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postAjax(Request $request)
    {
        $id = $request->get('id');
        $app = Application::findOrFail($id);
        $app->checkOwner();
        $inputs = $request->all();
        unset($inputs['key']);
        unset($inputs['user_id']);
        $app->fill($inputs);
        $app->ajaxUpdateFields($request->get('label'));
        $app->save();
        return \Response::json(['success'=>true,'message'=>'Update successfully']);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $app = Application::findOrFail($id);
        $app->checkOwner();
        $app->delete();
        return redirect('/');
    }
}
