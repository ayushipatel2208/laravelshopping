<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Brands;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{

    public function index(Request $request){
        $brands = Brands::latest('id');

        if($request->get('keyword')) {
            $brands = $brands->where('name','like','%'.$request->keyword.'%');
        }

        $brands = $brands->paginate(10);

        return view('backend/Brands/list', compact(['brands']));
    }

    public function create(){
        return view('backend/Brands/brand');
    }

    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:brands,slug',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ]);
    }

    try {
        $brand = new Brands();
        $brand->name = $request->name;
        $brand->slug = $request->slug;
        $brand->status = $request->status ?? 0; // Default to inactive if no status provided
        $brand->save();

        Session::flash('success', 'Brand Added Successfully');

        return response()->json([
            'status' => true,
            'message' => 'Brand added successfully!',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'An error occurred while saving the brand.',
        ], 500);
    }
}

    public function edit($id, Request $request) {
        $brand = Brands::find($id);

        // if(empty($brand)) {
        //     Session::flash('error', 'Record Not Found');
        //     return redirect()->route('backend/Brands/list');
        // }
        // $data['brand'] = $brand;
        return view('backend/Brands/edit', compact(['brand']));
    }

    public function update($id, Request $request) {

        $brand = Brands::find($id);

        if(empty($brand)) {
            Session::flash('error', 'Record Not Found');

            return response()->json([
                'status' => false,
                'notFound' => true
            ]);
        }

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:brands,slug,'.$brand->id.',id',
        ]);
        if ($validator->passes()){

            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;
            $brand->save();

            Session::flash('success', 'Brand Updated Successfully');
            // return response()->json([
            //     'status' => true,
            //     'message' => 'Brand Updated Successfully'
            // ]);

            return redirect()->route('brand.index');

        }else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function destroy($id) {
        $brand = Brands::find($id);
        $brand->delete();

        Session::flash('success', 'Brand Deleted Successfully');
        return redirect()->route('brand.index');
    }

}
