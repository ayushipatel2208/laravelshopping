<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\ProductSubCategoryController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\TempImagesController;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('frontend/home', [FrontController::class, 'index'])->name('frontend.index');
Route::get('frontend/shop/{categorySlug?}/{subcategorySlug?}', [ShopController::class, 'index'])->name('frontend.shop');

Route::get('backend/index', function () {
    return view('backend/index');
});

Route::get('backend/admin_login', function () {
    return view('backend\admin_login');
});


Route::group(['prefix' => 'admin'],function(){
       Route::group(['middleware' => 'admin.guest'], function(){

        Route::get('backend/admin_login', [AdminController::class, 'index'])->name('backend/admin_login');
        Route::post('admin.authenticate', [AdminController::class, 'authenticate'])->name('admin.authenticate');


       });

       Route::group(['middleware' => 'admin.auth'], function(){
        Route::get('backend/index', [HomeController::class, 'index'])->name('admin.dashboard');
        Route::get('\logout', [HomeController::class, 'logout'])->name('backend/logout');

//category routes
Route::get('backend/list', [CategoryController::class, 'index'])->name('category.index'); 
Route::get('category/create', [CategoryController::class, 'create'])->name('category.create');    
Route::post('backend/category', [CategoryController::class, 'store'])->name('category.store'); 
Route::get('backend/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');   
Route::put('backend/edit/{id}', [CategoryController::class, 'update'])->name('category.update');    
Route::delete('backend/delete/{id}', [CategoryController::class, 'destroy'])->name('category.delete'); 

//sub category routes
Route::get('backend/sub_table', [SubCategoryController::class, 'index'])->name('sub_table.index'); 
Route::get('backend/sub_category', [SubCategoryController::class, 'create'])->name('sub_category.create'); 
Route::post('backend/sub_category', [SubCategoryController::class, 'store'])->name('sub_category.store'); 
Route::get('backend/editsub_category/{id}', [SubCategoryController::class, 'edit'])->name('sub_category.edit');   
Route::put('backend/editsub_category/{id}', [SubCategoryController::class, 'update'])->name('sub_category.update');
Route::get('backend/subdelete/{id}', [SubCategoryController::class, 'destroy'])->name('sub_category.delete'); 

//Brands Routes

Route::get('backend/Brands/list', [BrandController::class, 'index'])->name('brand.index'); 
Route::get('backend/Brands/brand', [BrandController::class, 'create'])->name('brand.create'); 
Route::post('backend/Brands/brands', [BrandController::class, 'store'])->name('brand.store');
Route::get('backend/Brands/edit/{id}', [BrandController::class, 'edit'])->name('brand.edit');  
Route::put('backend/Brands/edit/{id}', [BrandController::class, 'update'])->name('brand.update');
Route::get('backend/Brands/delete/{id}', [BrandController::class, 'destroy'])->name('brand.delete'); 

//Product Routes
Route::get('backend/Products/list', [ProductController::class, 'index'])->name('product.index'); 
Route::get('backend/Products/product', [ProductController::class, 'create'])->name('product.create');
Route::post('backend/Products/product', [ProductController::class, 'store'])->name('product.store');
Route::get('backend/Products/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');  
Route::put('backend/Products/edit/{id}', [ProductController::class, 'update'])->name('product.update');
Route::delete('backend/Products/delete/{id}', [ProductController::class, 'destroy'])->name('product.delete'); 

Route::get('/product-subcategories', [ProductSubCategoryController::class, 'getSubcategories'])->name('product-subcategory.getSubcategories');

Route::post('/product-images/update', [ProductImageController::class, 'update'])->name('product-image.update');
Route::delete('/product-images', [ProductImageController::class, 'destroy'])->name('product-image.destroy');

//temp-images-create
Route::post('backend/upload-temp-image', [TempImagesController::class, 'create'])->name('temp-images.create');

 });

    //category
 
    Route::get('backend/category', function () {
        return view('backend/category');
    });

//     Route::get('getSlug',function(Request $request){
//         dd($request->all());
//     $slug = '';
//     if(!empty($request->title)) {
//         $slug = Str::slug($request->title);
//     }

//     return response()->json([
//         'status' => true,
//         'slug' => $slug
//     ]);
// })->name('admin/getSlug'); 

Route::get('admin/getSlug', [AdminController::class, 'getSlug'])->name('admin/getSlug');


});
