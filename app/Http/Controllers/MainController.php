<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Admin;

use Illuminate\Http\Request;

class MainController extends Controller
{
    //
    function login(){
        return view('auth.login');
    }


   
    function check(Request $request){
        // Validate Request
        $request->validate([
        'email'=>'required|email',
        'password'=>'required|min:5|max:12',
        ]);
        $userinfo = Admin::where('email','=',$request->email)->first();
        if(!$userinfo){
            return back()->with('fail','Email is not recognized');
        }else{
            // check password
            if ($request->password == $userinfo->password){
                $request->session()->put('LoggedUser', $userinfo->id);
                return redirect('/admin/dashboard');
            }else{
                return back()->with('fail','Wrong password');
            }
        }
    }
 


    function dashboard(){
    //    $data=['LoggedUserInfo'=>Admin::where('id','=',session('LoggedUser'))->first()];
       $files=File::orderBy('created_at', 'DESC')->get()->all();

       return view('admin.dashboard', compact('files'));
    }

    function logout(){
        if(session()->has('LoggedUser')){
            session()->pull('LoggedUser');
            return redirect('/auth/login');
        }
     }


     
}
