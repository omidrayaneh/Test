<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Product;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
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
     * redirect to product create page
     * @return
     */
    public function create()
    {
         $tags=Tag::where('status',1)->get();
        return view('products.create',compact(['tags']));
    }

    /**
     * Store a newly created resource in storage.
     * store new product to database with form validation
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|unique:products',
        ], [
            'title.required'=>'product title is required',
            'title.min'=>'product title is less more than 3 character',
            'title.unique'=>'product all ready be taken'

        ]);
        if ($validator->fails()) {
            return redirect()->route('products.create')
                ->withErrors($validator)->withInput();
        }

        $product=new Product();
        $product->title=$request->input('title');
        $product->save();

        $tags=$request->input('tag_id');
        foreach ($tags as $tag){
            $array=[];
            $array = explode(',', $tag);
            $product->tags()->attach(($array));
        }



        return  redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
