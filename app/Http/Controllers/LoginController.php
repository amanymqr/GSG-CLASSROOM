<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function create(){
        return view('login');
    }

    public function store(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required',
        ]);
        $user= User::where('email', '=', $request->email)->first();
        if($user && Hash::check($request->password , $user->password)){
            //aythenticated
            Auth::login($user);
            return redirect()->route('classroom.index');
        }
        return back()->withInput()->withErrors([
        "email" => "Invalid email ."
        ]);
    }
}
