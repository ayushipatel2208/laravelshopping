<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Sub_category;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{

    public function index(Request $request) {
        $subcategories = Sub_category::select('sub_categories.*','categories.name as categoryName')
                                                       ->latest('sub_categories.sub_id') 
                                                       ->leftjoin('categories', 'categories.cat_id', '=', 'sub_categories.cat_id');

        if(!empty($request->get('keyword'))) {
            $subcategories = $subcategories->where('sub_categories.name', 'like', '%'.$request->get('keyword').'%');
            $subcategories = $subcategories->orwhere('categories.name', 'like', '%'.$request->get('keyword').'%');
        } 

        $subcategories = $subcategories->paginate(10);

        return view('backend/sub_table', compact(['subcategories']));

    }

    public function create() {
        $category = Category::orderBy('name', 'ASC')->get();
        // $data['category'] = $category;
        return view('backend/sub_category', compact(['category']));
    }

    public function store(Request $request) {
        //dd($request->all());
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:sub_categories',
            'cat_id' => 'required',
            'status' => 'required'
        ]);
        if ($validator->passes()) {

            $subCategory = new Sub_category();
            $subCategory->name = $request->name;
            $subCategory->slug = $request->slug;
            $subCategory->status = $request->status;
            $subCategory->cat_id = $request->cat_id;
            $subCategory->showHome = $request->showHome;
            $subCategory->save();

            //$request->session()->flash('success','Sub Category Created Successfully.');
            Session::flash('success','Sub Category Created Successfully');

            // return response()->json([
            //     'status' => true,
            //     'message' => 'Sub Category Created Successfully.'
            // ]);

            return redirect()->route('sub_table.index');

        } else {
            Session::flash('error','Erroe Sub Category');
            return response([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function edit($id)
    {
        $subCategory = Sub_Category::find($id); // Or use first() if using a query builder
    
        if (!$subCategory) {
            abort(404, 'SubCategory not found'); // Return an appropriate error
        }
    
        $categories = Category::all(); // Assuming a Category model exists for dropdown options
    
        return view('backend/editsub_category', compact('subCategory', 'categories'));
    }
    

//    public function edit ($id, Request $request) {

//         $subCategory = Category::find($id);
//         if(empty($subCategory)) {
//             Session::flash('error', 'Record Not Found');
//             return redirect()->route('backend/sub_table');
//         }

//         $categories = Category::orderBy('name', 'ASC')->get();
//         // $data['categories'] = $categories;
//          //$data['subCategory'] = $subCategory;
//         return view('backend/editsub_category', compact(['categories']));

//     }

    public function update($id, Request $request) {

        // dd($request->all());

        $subCategory = Sub_category::find($request->sub_id);

        if(empty($subCategory)) {
            Session::flash('error', 'Record Not Found');
            return response([
                'status' => false,
                'notFound' => true
            ]);
            return redirect()->route('backend/sub_table');
        }

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            //'slug' => 'required|unique:sub_categories,slug,'.$subCategory->sub_id.',id',
            'cat_id' => 'required',
            'status' => 'required'
        ]);
        if ($validator->passes()) {

            $subCategory->name = $request->name;
            $subCategory->slug = $request->slug;
            $subCategory->status = $request->status;
            $subCategory->cat_id = $request->cat_id;
            $subCategory->showHome = $request->showHome;
            $subCategory->save();

            Session::flash('success','Sub Category Updated Successfully');

            return response()->json([
                'status' => true,
                'message' => 'Sub Category Created Successfully.'
            ]);

            return redirect()->route('sub_table.index');

        } else {
            Session::flash('error','Erroe Sub Category');
            return response([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function destroy($subCategoryId, Request $request){
        $subCategory = Sub_category::find($subCategoryId);
       Session::flash('error','Record Not Found');
        if(empty($subCategory)) {
            return response()->json([
                'status' => false,
                'notFound' => true
            ]);
           // return redirect()->route('backend/list');
        }
        
        $subCategory->delete();

        Session::flash('success','Sub Category Deleted Successfully');

        // return response()->json([
        //     'status' => true,
        //     'message' => 'Category Deleted Successfully'
        // ]);

        return redirect()->route('sub_table.index');

    }

}
