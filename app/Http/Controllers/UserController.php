<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

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
}
