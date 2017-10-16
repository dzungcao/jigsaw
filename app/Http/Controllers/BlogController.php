<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Blog;

class BlogController extends Controller
{
    public function getBlog($slug){
        $blog = Blog::where('slug',$slug)->where('active',1)->firstOrFail();
        return view('blog.public',compact('blog'));
    }
    public function getList()
    {
        $blogs = Blog::where('active',1)->get();
        return view('blog.list',compact('blogs'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::all();
        return view('blog.index',compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
                        'title'=>'required',
                        'content'=>'required'
                );
        $validator = \Validator::make($request->all(),$rules);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        $inputs = $request->all();
        $inputs['created_by'] = \Auth::user()->id;
        $inputs['active'] = isset($inputs['active']) ? 1:0;
        if(empty($inputs['slug'])){
            $inputs['slug'] = Blog::to_slug($inputs['title']);
        }
        else{
            $inputs['slug'] = Blog::to_slug($inputs['slug']);
        }
        $blog = Blog::create($inputs);
        return redirect('blog');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        $this->checkPermision($blog);
        return view('blog.view',compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        $this->checkPermision($blog);
        return view('blog.edit',compact('blog'));
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
        $blog = Blog::findOrFail($id);
        $this->checkPermision($blog);
        $rules = array(
                        'title'=>'required',
                        'content'=>'required',
                        
                );
        $validator = \Validator::make($request->all(),$rules);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        $inputs = $request->all();

        if(empty($inputs['slug'])){
            $inputs['slug'] = Blog::to_slug($inputs['title']);
        }
        else{
            $inputs['slug'] = Blog::to_slug($inputs['slug']);
        }
        $inputs['active'] = isset($inputs['active']) ? 1:0;
        unset($inputs['created_by']);
        $blog->fill($inputs);
        $blog->save();
        
        return redirect('blog');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $this->checkPermision($blog);
        $blog->delete();
        return redirect('blog');
    }

    private function checkPermision($blog){
        if($blog->created_by != \Auth::user()->id && !\Auth::user()->admin && !\Auth::user()->approver){
            abort(404);
        }
    }
}
