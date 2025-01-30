<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
       // $admin = Auth::guard('admin')->user();
       // echo 'Welcome  '.$admin->name.' <a href="'.route('backend/logout').'">Logout</a>';
       return view('backend/index');
    }

    public function logout() {
        Auth::guard('admin')->logout();
        return redirect()->route('backend/admin_login');
    }
}
