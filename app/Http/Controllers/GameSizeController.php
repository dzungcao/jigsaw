<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\GameSize;

class GameSizeController extends Controller
{

    public function getIndex(){
        $sizes = GameSize::all();
        return view('gamesize.index',compact('sizes'));
    }
    public function getCreate(){
        return view('gamesize.create');
    }
    public function postCreate()
    {
        $rules = ['title'=>'required','row'=>'required|integer|min:6|max:10','col'=>'required|integer|min:6|max:10'];
        $validator = \Validator::make(\Input::get(),$rules);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        $size = new GameSize();
        $size->title = \Input::get('title');
        $size->row = \Input::get('row');
        $size->col = \Input::get('col');
        $size->pieces = $size->col * $size->row;
        $size->save();
        return redirect('gamesize');
    }
    public function postUpdate($id)
    {
        $size = GameSize::findOrFail($id);
        $size->title = \Input::get('title');
        $size->row = \Input::get('row');
        $size->col = \Input::get('col');
        $size->pieces = $size->col * $size->row;
        $size->save();
        return back();
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postDelete($id)
    {
        $size = GameSize::findOrFail($id);
        $size->delete();
        return redirect('gamesize');
    }
}
