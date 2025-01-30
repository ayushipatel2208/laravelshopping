<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TempImage;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
// use Intervention\Image\ImageManager;
use Intervention\Image\Facades\Image;

class TempImagesController extends Controller
{
    public function create(Request $request){
        $image = $request->image;
        Log::info('Request data:', $request->all());

        if(!empty($image)){
            $ext = $image->getClientOriginalExtension();
            $newName = time().'.'.$ext;

            $tempImage = new TempImage();
            $tempImage->name = $newName;
            $tempImage->save();

            $image->move(public_path().'/temp',$newName);

            // Generate thumbnail

            $sourcePath = public_path().'/temp/'.$newName;
            $destPath = public_path().'/temp/thumb/'.$newName;
            $image = Image::make($sourcePath);
            $image->fit(300,275);
            $image->save($destPath);

            Session::flash('success', 'Image Uploaded Successfully');

            return response()->json([
                'status' => true,
                'image_id' => $tempImage->id,
                'ImagePath' => asset('/temp/thumb/'.$newName),
                'message' => 'Image saved successfully'
            ]);
        }

    }
    
}
