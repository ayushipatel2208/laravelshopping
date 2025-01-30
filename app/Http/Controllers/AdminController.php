<?php

namespace App\Http\Controllers;

use App\Models\admin;
use \Illuminate\Support\Facades\Validator;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend/admin_login');
        //
    }

    public function authenticate(Request $request){

        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if($validator->passes()){

            if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password],$request->get('remember'))){

                $admin = Auth::guard('admin')->user();

                if($admin->role == 2) {
                    return redirect('backend/index');
                } else {
                    Auth::guard('admin')->logout();
                    return redirect()->route('backend/index')->with('erroe','You are not authorized to access admin panel.');
                }

            } 
            else{
                return redirect()->route('backend/admin_login')->with('error','Either Email or Password is incorrect');
            }

        } else {
            return redirect()->route('backend/admin_login')->withErrors($validator)->withInput($request->only('email'));
        }
    
    }

//     public function getSlug(Request $request)
// {
//     try {
//         $title = $request->get('title');
//         if (!$title) {
//             return response()->json(['status' => false, 'message' => 'Title is required'], 400);
//         }
//         $slug = Str::slug($title); // Generate slug
//         return response()->json(['status' => true, 'slug' => $slug]);
//     } catch (\Exception $e) {
//         return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
//     }
// }


// public function generateSlug(Request $request)
// {
//     $slug = Str::slug($request->title, '-');
//     return response()->json(['slug' => $slug]);
// }

public function getSlug(Request $request)
{
    $title = $request->input('title');
    if (!$title) {
        return response()->json(['status' => false, 'message' => 'Title is required'], 400);
    }

    $slug = Str::slug($title); // Ensure `Str::slug` is used for generating slugs
    return response()->json([
        'status' => true, 'slug' => $slug
    ]);
}



    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

     

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(admin $admin)
    {
        //
    }
}
