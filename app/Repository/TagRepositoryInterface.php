<?php


namespace App\Repository;


interface TagRepositoryInterface
{

    public function all();

    public function create($tag);

    public function delete($id);

    public function update($request,$id);

    public function findBySlug($slug);

    public function findById($id);

}
