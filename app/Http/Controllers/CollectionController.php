<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Collection;

class CollectionController extends Controller
{
    public function getIndex(){
        $collections = Collection::orderBy('created_at','desc')->get();
        return view('collection.index',compact('collections'));
    }
    public function getCreate(){
        return view('collection.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postCreate(Request $request)
    {

        $rules = array(
          'title' => 'required|alpha_numeric|max:200'
        );
        $validator = \Validator::make($request->all(), $rules);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        $inputs = $request->all();
        $inputs['created_by'] = \Auth::user()->id;
        Collection::create($inputs);
        return redirect('collection');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postDelete($id)
    {
        $collection = Collection::findOrFail($id);
        if(!\Auth::user()->admin && !\Auth::user()->manager && !\Auth::user()->approver){
            if($collection->created_by != \Auth::user()->id){
                abort(401);
            }
        }
        $collection->delete();
        return redirect('collection');
    }
}
