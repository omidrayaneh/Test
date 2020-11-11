<?php


namespace App\Repository\Eloquent;


use App\Tag;
use App\Repository\TagRepositoryInterface;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class TagRepository implements TagRepositoryInterface
{

    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }


    public function findBySlug($slug)
    {
        return Tag::where('slug', $slug)->first();

    }

    public function findById($id)
    {
        return Tag::findOrFail($id);
    }

    public function all()
    {
        return Tag::all();
    }

    public function create($request)
    {
        $tag=new Tag();
        $title=Str::slug($request->get('title'));
        $tag->title=$request->get('title');
        $tag->slug=($title);
        $tag->description=$request->get('description');
        $tag->photo_id=$request->get('photo_id');
        $tag->status=false;
        $tag->save();

    }



    public function update($request, $id)
    {
        $tag=$this->findById($id);
        $title=Str::slug($request->get('title'));
        $tag->title=$request->get('title');
        $tag->status=$request->get('status');
        $tag->slug=($title);
        $tag->description=$request->get('description');
        $tag->status=$request->get('status');
        if ($request->get('photo_id')!=null)
        {
            $tag->photo_id=$request->get('photo_id');
        }
        $tag->save();
    }
    public function delete($id)
    {
        $tag=$this->findById($id);
        Session::flash('error', 'the tag '.$tag->title .' is deleted');
        $tag->delete();
    }

}
