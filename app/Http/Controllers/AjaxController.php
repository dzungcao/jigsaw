<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Field;
use App\Models\ContactForm;
use App\Models\FormField;
use App\Models\Application;

class AjaxController extends Controller
{

    public function postRemovefield(Request $request){
        $id = $request->get('id');
        $field = FormField::findOrFail($id);
        $field->delete();
        return back();
    }
    public function postUpdatefield(Request $request)
    {
        $rules = ['label'];
        $validator = \Validator::make($request->all(),$rules);
        if($validator->fails()){
            return back();
        }
        $formField = FormField::findOrFail($request->get('id'));
        $inputs = $request->all();
        unset($inputs['form_id']);
        unset($inputs['field_id']);
        $formField->fill($inputs);
        $formField->save();
        return back();
    }
    public function postAddfield(Request $request)
    {

        $rules = ['field_id'=>'required','form_id'=>'required'];
        $validator = \Validator::make($request->all(),$rules);
        if($validator->fails()){
            /*return \Response::json(['success'=>false,'errors'=>$validator->errors()]);*/
            return back();
        }
        $inputs = $request->all();
        FormField::create($inputs);
        //return \Response::json(['success'=>true]);
        return back();
    }
    public function postApp(Request $request){
        $rules = ['emails'=>'required','response_text'=>'required','application_id'=>'required'];
        $validator = \Validator::make($request->all(),$rules);
        if($validator->fails()){
            return back()->withInput()->withErrors($validator);
        }
        $emails = $request->get('emails');
        $responseText = $request->get('response_text');
        $app = Application::findOrFail($request->get('application_id'));
        $inputs = $request->all();
        //unset($inputs['user_id']);
        $app->fill($inputs);
        $app->save();
        return back()->with('success-message','Your setting has been saved successfully');
    }
}
