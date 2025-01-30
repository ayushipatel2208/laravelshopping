<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index() {

       $products = Product::where('is_featured', 'Yes')
       ->orderBy('id', 'DESC')
       ->where('status', 1)
       ->take(8)
       ->get();

      $latestproducts = Product::orderBy('cat_id', 'DESC')
      ->where('status', 1)
      ->take(8)
      ->get();
     
    //  dd($latestproducts);

        return view('frontend.home', compact(['products', 'latestproducts']));
    }
}
