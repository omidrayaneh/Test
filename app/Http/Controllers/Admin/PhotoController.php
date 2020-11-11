<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function upload(Request $request)
    {
        $uploadedFile = $request->file('file');
        $filename = time().$uploadedFile->getClientOriginalName();
        $original_name = $uploadedFile->getClientOriginalName();

        Storage::disk('local')->putFileAs(
            'public/photos', $uploadedFile, $filename
        );

        $photo = new Photo();
        $photo->original_name = $original_name;
        $photo->path = $filename;
        $photo->save();

        return response()->json([
            'photo_id' => $photo->id,
            'message'=>'yes'
        ]);
    }
}
