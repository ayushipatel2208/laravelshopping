<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class ProductImageController extends Controller
{
    public function update(Request $request) {

       // dd($request->all());
        
        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $sourcePath = $image->getPathName();

        $productImage = new ProductImage();
        $productImage->pro_id = $request->pro_id;
        $productImage->save();

        $imageName = $request->pro_id . '-' . time() . '.' . $ext;
        $productImage->image = $imageName;
        $productImage->save();

         // Large Image
         $largeDestPath = public_path() . '/uploads/product/large/' . $imageName;
         $image = Image::make($sourcePath);
         $image->resize(1400, null, function ($constraint) {
             $constraint->aspectRatio();
         });
         $image->save($largeDestPath);
 
         // Small Image
         $smallDestPath = public_path() . '/uploads/product/small/' . $imageName;
         $image = Image::make($sourcePath);
         $image->fit(300, 300);
         $image->save($smallDestPath);

         Session::flash('success', 'Image saved successfully');

    return response()->json([
        'status' => true,
        'image_id' => $productImage->pro_id,
        'imagePath' => asset('uploads/product/small/'. $productImage->image),
        'message' => 'Image saved successfully'
    ]);       

    
   
  }

 

  public function destroy(Request $request)
  {
      // Fetch the product image by the pro_id from the request
      $productImage = ProductImage::where('pro_id', $request->pro_id)->first();
  
      if (empty($productImage)) {
          return response()->json([
              'status' => false,
              'message' => 'Image not found',
          ]);
      }
  
      // Delete image files from the folder
      File::delete(public_path('uploads/product/large/' . $productImage->image));
      File::delete(public_path('uploads/product/small/' . $productImage->image));
  
      // Delete the database record
      $productImage->delete();
  
      return response()->json([
          'status' => true,
          'message' => 'Image deleted successfully',
      ]);
  }
  
     
}
