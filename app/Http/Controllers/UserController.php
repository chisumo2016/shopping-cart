<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use  Session;


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
            'email'   =>'email|required|unique:users',
            'password'=>'required|min:4'
        ]);

        $user = new User([
            'email'   =>$request->input('email'),
            'password'=>bcrypt($request->input('password'))
        ]);
        //Save user into database
        $user->save();
        Auth::login($user);

        //Check if my session has oldurl
        if(Session::has('oldUrl')){
            $oldUrl =Session::get('oldUrl');
            Session::forget('oldUrl');
            return redirect()->to($oldUrl);
        }
        //return redirect()->route('product.index');
        return redirect()->route('user.profile');
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
            //Check if my session has oldurl
            if(Session::has('oldUrl')){
                $oldUrl =Session::get('oldUrl');
                Session::forget('oldUrl');
                return redirect()->to($oldUrl);
            }
            // Successfully ->return profile
            return redirect()->route('user.profile');
        }
        return redirect()->back();
    }
    //User Profile

    public function getProfile()
    {
        $orders = Auth::user()->orders;  //Fetching all orders
        $orders->transform(function($order, $key) {
            $order->cart = unserialize($order->cart);
            return $order;
        });
        return view('user.profile', compact('orders'));
    }

    //User log out
    public function getLogout()
    {
        Auth::logout();
        return redirect()->route('user.signin');
        //return redirect()->back();
    }
}
