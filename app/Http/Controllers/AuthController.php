<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm(){
        return view("auth.login");
    }

    public function login(Request $request){

        $fields = $request->validate([
            "email"=> "required|email|exists:users,email",
            "password"=> "required",
        ]);
        
        if (Auth::attempt($fields)) {
            $request->session()->regenerate();
            return redirect()->intended();
        }

        return back()->withErrors(['email'=> 'Invalid Credentials.']);
    }

    public function showRegisterForm(){
        return view("auth.register");
    }

    public function register(Request $request){

        $fields = $request->validate([
            "name" => "required|max:50",
            "email"=> "email|required|unique:users,email",
            "password"=> "required|confirmed"
        ]);


        $user = User::create($fields);
        Auth::login($user);

        return redirect("dashboard");

    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();

        return redirect("login");
    }
}
