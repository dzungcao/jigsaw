<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Category;

class CategoryController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $categories = Category::all();
        return view('category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCreate()
    {
        return view('category.create');
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
                        'title'=>'required',
                );
        $validator = \Validator::make($request->all(),$rules);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        $inputs = $request->all();
        $inputs['created_by'] = \Auth::user()->id;
        $inputs['active'] = isset($inputs['active']) ? 1:0;
        $Category = Category::create($inputs);
        return redirect('category');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getView($id)
    {
        $category = Category::findOrFail($id);
        return view('category.view',compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getEdit($id)
    {
        $category = Category::findOrFail($id);
        return view('category.edit',compact('category'));
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
        $category = Category::findOrFail($id);
        $rules = array(
                        'title'=>'required',                        
                );
        $validator = \Validator::make($request->all(),$rules);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        $inputs = $request->all();

        $inputs['active'] = isset($inputs['active']) ? 1:0;
        unset($inputs['created_by']);
        $category->fill($inputs);
        $category->save();
        
        return redirect('category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postDelete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect('category');
    }
}
