<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\TempImage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
 

class CategoryController extends Controller
{
    public function index(Request $request){
        $categories = Category::latest();

        if(!empty($request->get('keyword'))){
            $categories = $categories->where('name', 'like', '%'.$request->get('keyword').'%');

        }
        $categories = $categories->paginate(10);
        //$data['categories'] = $categories;

        return view('backend/list', compact(['categories']));

    }

    public function create(){
       return view('backend/category'); 
    }

    public function store(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:categories',
        ]);

        if($validator->passes()){

            $category = new Category();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->showHome = $request->showHome;
            $category->save();

            //Save Image Here
            // if(!empty($request->image_id)) {
            //     $tempImage = TempImage::find($request->image_id);
            //     $extArray = explode('.',$tempImage->name);
            //     $ext = last($extArray);

            //     //dd($tempImage);
            //     $newImageName = $category->cat_id.'.'.$ext;
            //     $sPath = public_path().'/temp/'.$tempImage->name;
            //     //dd($sPath);
            //     $dPath = public_path().'/uploads/category/'.$newImageName;
            //     File::copy($sPath, $dPath);

            //     //Generate Image Thumbnail
            //     $dPath = public_path().'/uploads/category/thumb/'.$newImageName;
            //     $img = Image::make($dPath);
            //     //$img->resize(450, 600);
            //     $img->fit(450, 600, function ($constraint){
            //         $constraint->upsize();
            //     });
            //     $img->save($sPath);
                 

            //     $category->image = $newImageName;
            //     $category->save();
            // }

            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);
                if (!$tempImage) {
                    dd("TempImage not found for ID: " . $request->image_id);
                }
            
                $extArray = explode('.', $tempImage->name);
                $ext = last($extArray);
            
                $newImageName = $category->cat_id . '.' . $ext;
                $sPath = public_path() . '/temp/' . $tempImage->name;
                $dPath = public_path() . '/uploads/category/' . $newImageName;
            
                if (!file_exists($sPath)) {
                    dd("Source file does not exist at: " . $sPath);
                }
            
                // Ensure directories exist
                if (!File::exists(public_path('uploads/category'))) {
                    File::makeDirectory(public_path('uploads/category/'), 0755, true);
                }
                if (!File::exists(public_path('uploads/category/thumb'))) {
                    File::makeDirectory(public_path('uploads/category/thumb/'), 0755, true);
                }
            
                // Copy file
                File::copy($sPath, $dPath);
            
                // Generate thumbnail
                $thumbPath = public_path() . '/uploads/category/thumb/' . $newImageName;
                $img = Image::make($dPath);
                $img->fit(450, 600, function ($constraint) {
                    $constraint->upsize();
                });
                $img->save($thumbPath);
            
                $category->image = $newImageName;
                $category->save();
            }
            


            Session::flash('success','Category added Successfully');

            return redirect()->route('category.index');
        }
        else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function edit(Request $request, Category $category, $id){

        $category = Category::find($id);
       // $categories = Category::get();
        // if(!empty($category)){
        //     return redirect()->route('list.index');
        // }
        return view('backend/edit',compact(['category']));
        
    }

    public function update(Request $request, Category $category,$id){

         $category = Category::find($id);
        if(empty($category)){
            Session::flash('error','category not found');
            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Category not found'
            ]);
        }


        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,'.$category->cat_id.',cat_id'
        ]);

        if($validator->passes()) {

            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->showHome = $request->showHome;
            $category->save();

            $oldImage = $category->image;

            //Save Image Here
            if(!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.',$tempImage->name);
                $ext = last($extArray);

                $newImageName = $category->cat_id.'-'.time().'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                $dPath = public_path().'/uploads/category/'.$newImageName;
                File::copy($sPath, $dPath);

                //Generate Image Thumbnail
                $dpath = public_path().'/uploads/category/thumb/'.$newImageName;
                $img = Image::make($sPath);
                //$img->resize(450, 600);
                $img->fit(450, 600, function ($constraint){
                    $constraint->upsize();
                });
                $img->save($dPath);
                 

                $category->image = $newImageName;
                $category->save();

                //Delete All Images Here
                File::delete(public_path().'/uploads/category/thumb/'.$oldImage);
                File::delete(public_path().'/uploads/category/'.$oldImage);

            }

             //$request->session()->flush('success','Category updated Successfully');
            Session::flash('success','Category updated Successfully');



          // return redirect('backend/list')->with('success','Category updated Successfully');
            // return response()->json([
            //     'status' => true,
            //     'message' => 'Category updated Successfully'
            // ]);

             return redirect()->route('category.index')->with('success','Category updated Successfully');


        }
        else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

     public function destroy($categoryId, Request $request)
{
    // Attempt to find the category
    $category = Category::find($categoryId);

    // If the category is not found
    if (empty($category)) {
        Session::flash('error', 'Category not found');
        return response()->json([
            'status' => false,
            'message' => 'Category not found'
        ]);
    }

    // Delete the category's images
    if ($category->image) {
        File::delete(public_path('/uploads/category/thumb/' . $category->image));
        File::delete(public_path('/uploads/category/' . $category->image));
    }

    // Delete the category
    $category->delete();

    // Return success response
    Session::flash('success', 'Category deleted successfully');
    // return response()->json([
    //     'status' => true,
    //     'message' => 'Category deleted successfully'
    // ]);

    return redirect()->route('category.index');
}

    
        }
