<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Brands;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Sub_category;
// use App\Models\Sub_category;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
// use Nette\Utils\Image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public function index(Request $request){
        $products = Product::latest('pro_id')->with('product_images');

        if ($request->get('keyword') != "") {
            $products = $products->where('title', 'like', '%'.$request->keyword.'%');
        }

        $products = $products->paginate();
        //dd($products);

        return view('backend/Products/list', compact(['products']));
    }



    public function create(){
        $categories = Category::orderBy('name', 'ASC')->get();
        $brands = Brands::orderBy('name', 'ASC')->get();
        return view('backend/Products/product', compact(['categories', 'brands']));
    }

    public function store(Request $request) {

        // dd($request->image_array);
        // exit();

        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:products',
            'price' => 'required|numeric',
            'sku' => 'required|unique:products',
            'track_qty' => 'required|in:Yes,No',
            'cat_id' => 'required|numeric',
            'is_featured' => 'required|in:Yes,No',
        ];

        if (!empty($request->track_qty) && $request->track_qty == 'Yes') {
            $rules['qty'] = 'required|numeric';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $product = new Product();
            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->compare_price = $request->compare_price;
            $product->sku = $request->sku;
            $product->barcode = $request->barcode;
            $product->track_qty = $request->track_qty;
            $product->qty = $request->qty;
            $product->status = $request->status;
            $product->cat_id = $request->cat_id;
            $product->sub_id = $request->sub_id;
            $product->id = $request->id;
            $product->is_featured = $request->is_featured;
            $product->save();

            // Save Gallary Pics
            // if(!empty($request->image_array)){
            //     foreach ($request->image_array as $temp_image_id) {

            //         $tempImageInfo = TempImage::find($temp_image_id);
            //         $extArray = explode('.',$tempImageInfo->name);
            //         $ext = last($extArray); // like jpg,gif,png, etc

            //         $productImage = new ProductImage();
            //         $productImage->pro_img_id = $product->pro_id;
            //         $productImage->image = 'NULL';
            //         $productImage->save();

            //         $imageName = $product->pro_id.'-'.$productImage->pro_img_id.'-'.time().'.'.$ext;
            //         $productImage->image = 'NULL';
            //         $productImage->save();

            //         // Generate Product Thumbnail

            //         // Large Image
            //         $sourcePath = public_path().'/temp/'.$tempImageInfo->name;
            //         $destPath = public_path().'/uploads/product/large/'.$imageName;
            //         $image = Image::make($sourcePath);
            //         $image->resize(1400, null, function ($constraint) {
            //             $constraint->aspectRatio();
            //         });
            //         $image->save($destPath);

            //         // Small Image
            //         $destPath = public_path().'/uploads/product/small/'.$imageName;
            //         $image = Image::make($sourcePath);
            //         $image->fit(300,300);  
            //         $image->save($destPath);

            //     }
            // }

            if (!empty($request->image_array)) {
            foreach ($request->image_array as $temp_image_id) {

        $tempImageInfo = TempImage::find($temp_image_id);
        $extArray = explode('.', $tempImageInfo->name);
        $ext = last($extArray); // like jpg, gif, png, etc.

        $productImage = new ProductImage();
        $productImage->pro_id = $product->pro_id;

        // Generate unique image name
        $imageName = $product->pro_id . '-' . time() . '.' . $ext;

        // Large Image
        $sourcePath = public_path() . '/temp/' . $tempImageInfo->name;
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

        // Save image path in the database
        $productImage->image = $imageName;
        $productImage->save();
    }
}


            Session::flash('success', 'Product Added Successfully');

            return response()->json([
                'status' => true,
                'message' => 'Product Added Successfully'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

    }

    public function edit($id, Request $request) {
        $product = Product::find($id);
       // dd($product);
        if (empty($product)) {

            // Session::flash('error','Product not Found');
             return redirect()->route('product.index')->with('error', 'Product not found');
         }

         //Fetch Product Image

         $productImages = ProductImage::where('pro_id', $product->pro_id)->get();

        $subcategories = Sub_category::where('cat_id', $product->cat_id)->get();
        // dd($subcategories);

        $categories = Category::orderBy('name', 'ASC')->get();
        $brands = Brands::orderBy('name', 'ASC')->get();

        $data = compact('product','productImages','subcategories','brands');
         //dd($data);
        return view('backend/Products/edit', compact(['product','categories','brands','subcategories','productImages']));
    }
     
    public function update($id, Request $request){

        $product = Product::find($id);

        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:products,slug,'.$product->cat_id.',id',
            'price' => 'required|numeric',
            'sku' => 'required|unique:products,sku,'.$product->cat_id.',id',
            'track_qty' => 'required|in:Yes,No',
            'cat_id' => 'required|numeric',
            'is_featured' => 'required|in:Yes,No',
        ];

        if (!empty($request->track_qty) && $request->track_qty == 'Yes') {
            $rules['qty'] = 'required|numeric';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->compare_price = $request->compare_price;
            $product->sku = $request->sku;
            $product->barcode = $request->barcode;
            $product->track_qty = $request->track_qty;
            $product->qty = $request->qty;
            $product->status = $request->status;
            $product->cat_id = $request->cat_id;
            $product->sub_id = $request->sub_id;
            $product->id = $request->id;
            $product->is_featured = $request->is_featured;
            $product->save();


            Session::flash('success', 'Product Updated Successfully');

            return response()->json([
                'status' => true,
                'message' => 'Product Updated Successfully'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

    }

    // public function destroy($id, Request $request) {
    //     $product = new Product($id);

    //     if (empty($product)) {
    //     Session::flash('error', 'Product not Found');
    //         return response()->json([
    //             'status' => false,
    //             'notFound' => 'true'
    //         ]);
    //     }

    //    $productImages = ProductImage::where('pro_id', $id)->get();

    //     if(!empty($productImage)) {
    //         foreach($productImages as $productImage) {
    //     File::delete(public_path('/uploads/product/large/'. $productImage->image));
    //     File::delete(public_path('/uploads/product/small/'. $productImage->image));
    //     }
    //     ProductImage::where('pro_id', $id)->delete();
    //     }
    //     $product->delete();

    //     Session::flash('success', 'Product deleted successfully');

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Product deleted successfully'
    //         ]);

    //         return redirect()->route('product.index');

    //   }

    public function destroy($id, Request $request)
{
    $product = Product::find($id);

    if (!$product) {
        Session::flash('error', 'Product not Found');
        return response()->json([
            'status' => false,
            'notFound' => true
        ]);
    }

    $productImages = ProductImage::where('pro_id', $id)->get();

    if (!$productImages->isEmpty()) {
        foreach ($productImages as $productImage) {
            $largeImagePath = public_path('/uploads/product/large/' . $productImage->image);
            $smallImagePath = public_path('/uploads/product/small/' . $productImage->image);

            if (File::exists($largeImagePath)) {
                File::delete($largeImagePath);
            }
            if (File::exists($smallImagePath)) {
                File::delete($smallImagePath);
            }
        }
        ProductImage::where('pro_id', $id)->delete();
    }

    $product->delete();

    Session::flash('success', 'Product deleted successfully');

    return response()->json([
        'status' => true,
        'message' => 'Product deleted successfully'
    ]);
}


}
