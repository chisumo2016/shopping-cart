<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //Display the signup page
    public function getSignup()
    {
       return view('user.signup');
    }

    public  function postSignup(Request $request)
    {
        //Validation field
        $this ->validate($request, [
            'email'   =>'email|required|unique:user',
            'password'=>'required|min:4'
        ]);

        $user = new User([
            'email'   =>$request->input('email'),
            'password'=>bcrypt($request->input('password'))
        ]);
        //Save user into database
        $user->save();
        return redirect()->route('product.index');
    }

//    Signin logic
    public function  getSignin()
    {
        return view('user.signin');
    }

    public function  postSignin(Request $request)
    {
        //Validation field
        $this ->validate($request, [
            'email'   =>'email|required',
            'password'=>'required|min:4'
        ]);
        // Laravel Authetification
       if( Auth::attempt(['email' => $request->input('email'), 'password'=>$request->input('password')]))
        {
            // Successfully ->return profile
            return redirect()->route('user.profile');
        }
        return redirect()->back();
    }
    //User Profile

    public function getProfile()
    {
        return view('user.profile');
    }
}
