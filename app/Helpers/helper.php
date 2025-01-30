<?php

use App\Models\Category;

 function getCategories() {
//     return Category::orderBy('name', 'ASC')
//     ->with('sub_category')
//     ->orderBy('id', 'DESC')
//     ->where('status', 1)
//     ->where('showHome', 'Yes')
//     ->get();
//  }

return Category::orderBy('name', 'ASC')
    ->with('sub_category')
    ->orderBy('cat_id', 'DESC') // or any other column that exists
    ->where('status', 1)
    ->where('showHome', 'Yes')
    ->get();

 }
?>

