<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Picture;

class PictureController extends Controller
{
    public function getIndex(){
        if(\Auth::user()->approver || \Auth::user()->manager){
            $pictures = Picture::orderBy('created_at','desc')->get();
        }
        else
            $pictures = Picture::where('created_by',\Auth::user()->id)
                    ->orderBy('created_at','desc')
                    ->get();
        return view('picture.index',compact('pictures'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postCreate(Request $request)
    {
        $file = $request->file('file');

        // Tell the validator that this file should be an image
        $rules = array(
          'picture' => 'mimes:jpeg,jpg,png|required|max:5000' // max 10000kb
        );
        $validator = \Validator::make(['picture'=>$file], $rules);
        if($validator->fails()){
            return \Response::json('error',400);    
        }

        $extension = $file->getClientOriginalExtension();
        $fileUrl =  time().'_'.strtolower(str_random(8)).'.'.$extension;
        
        $file->move(public_path().'/piclib/', $fileUrl);
        $inputs['path'] = $fileUrl;
        $inputs['created_by'] = \Auth::user()->id;
        Picture::create($inputs);
        
        return \Response::json(['success'=>true,'message'=>'File has been uploaded']);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postDelete($id)
    {
        $pic = Picture::findOrFail($id);
        if(!\Auth::user()->admin && !\Auth::user()->manager && !\Auth::user()->approver){
            if($pic->created_by != \Auth::user()->id){
                abort(401);
            }
        }
        \File::delete('piclib/'.$pic->path);
        $pic->delete();
        return back();
    }
}
