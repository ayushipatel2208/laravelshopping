<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Sub_category;
use Illuminate\Http\Request;

class ProductSubCategoryController extends Controller
{
    // public function index(Request $request) {
    //     if(!empty($request->cat_id)) {
    //         $subcategories = Sub_category::where('cat_id', $request->cat_id)
    //         ->orderBy('name', 'ASC')
    //         ->get();

    //         return response()->json([
    //             'status' => true,
    //             'subcategories' => $subcategories
    //         ]);
    //     } else {
    //         return response()->json([
    //             'status' => true,
    //             'subcategories' => []
    //         ]); 
    //     }
    // }

    public function getSubcategories(Request $request)
{
    $cat_id = $request->cat_id;

    if ($cat_id) {
        $subcategories = Sub_Category::where('cat_id', $cat_id)->get(['sub_id', 'name']);
        return response()->json([
            'status' => true,
            'subcategories' => $subcategories,
        ]);
       // return view('backend/Products/product', compact(['subcategories']));
    }

    return response()->json([
        'status' => false,
        'subcategories' => [],
    ]);
}
 }
