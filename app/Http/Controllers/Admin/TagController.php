<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Display a listing of the tags.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $tags=Tag::with('photo')->get();
        return view('tags.index',compact(['tags']));
    }

    /**
     * Show the form for creating a new tag.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('tags.create');
    }

    /**
     * Store a newly created tag in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return false|\Illuminate\Http\RedirectResponse|string
     */
    public function store(Request $request)
    {
        if ($request->input('photo_id')==null)
        {
            Session::flash('error', 'the tag photo is required');
            return redirect('tags/create');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|unique:tags',
            'description' => 'required|min:10',
            'photo_id' => 'required',
        ], [
            'title.required'=>'article title is required',
            'title.min'=>'article title is less more than 3 character',
            'title.unique'=>'article title is taken',
            'description.required'=>'article description is required',
            'description.min'=>'article description is less more than 10 character',
            'photo_id.required'=>'article photo is required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('tags.create')
                ->withErrors($validator)->withInput();
        }
        $tag=new Tag();
        $title=Str::slug($request->input('title'));
        $tag->title=$request->input('title');
        $tag->slug=($title);
        $tag->description=$request->input('description');
        $tag->photo_id=$request->input('photo_id');
        $tag->status=false;
        $tag->save();
        return  redirect('tags');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id)
    {
        $tag=Tag::with('photo')->where('id',$id)->first();
        return view('tags.edit',compact(['tag']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|unique:tags,title,'.$id,
            'description' => 'required|min:10',
        ], [
            'title' => 'required|min:3|unique:tags,title,' . $id,
            'title.min'=>'article title is less more than 3 character',
            'title.unique'=>'article title is taken',
            'description.required'=>'article description is required',
            'description.min'=>'article description is less more than 10 character',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)->withInput();
        }
        $tag=Tag::findOrFail($id);
        $title=Str::slug($request->input('title'));
        $tag->title=$request->input('title');
        $tag->status=$request->input('status');
        $tag->slug=($title);
        $tag->description=$request->input('description');
        $tag->status=$request->input('status');
        if ($request->input('photo_id')!=null)
        {
            $tag->photo_id=$request->input('photo_id');
        }
        $tag->save();
        return  redirect('tags');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $tag=Tag::findOrFail($id);
        Session::flash('error', 'the tag '.$tag->title .' is deleted');
        $tag->delete();
    }
}
