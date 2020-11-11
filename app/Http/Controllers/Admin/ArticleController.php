<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Http\Controllers\Controller;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

     /**
     * Show the form for creating a new resource.
     *  redirect to article create page
     * @return
     */
    public function create()
    {
        $tags=Tag::where('status',1)->get();
        return view('articles.create',compact(['tags']));
    }

    /**
     * Store a newly created resource in storage.
     * store new article to database with form validation
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Validation\Validator|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|unique:articles',
        ], [
            'title.required'=>'article title is required',
            'title.min'=>'article title is less more than 3 character',
            'title.unique'=>'article all ready be taken',
        ]);
        if ($validator->fails()) {
            return redirect()->route('products.create')
                ->withErrors($validator)->withInput();
        }

        $article=new Article();
        $article->title=$request->input('title');
        $article->save();

        $tags=$request->input('tag_id');
        foreach ($tags as $tag){
            $array=[];
            $array = explode(',', $tag);
            $article->tags()->attach(($array));
        }



        return  redirect('/');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        //
    }
}
