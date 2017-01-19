<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use App\Order;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Session;
use Stripe\Charge;
use Stripe\Stripe;

class ProductController extends Controller
{
    //
    public function  getIndex()
    {
        $products = Product::all();
        return view('shop.index',compact('products'));
    }

    public function  getAddToCart(Request $request, $id)
    {
        $product = Product::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id);
        $request->session()->put('cart', $cart);
        //dd($request->session()->get('cart'));
        return redirect()->route('product.index');

    }
     public function getReduceByOne($id)
     {
         $oldCart = Session::has('cart') ? Session::get('cart') : null;
         $cart = new Cart($oldCart);
         $cart->reduceByOne($id);
         if(count($cart->items) > 0 ){
             Session::put('cart', $cart);
         }else{
             Session::forget('cart');
         }

         //Session::put('cart', $cart);
         return redirect()->route('product.shoppingCart');
     }

     public  function  getRemoveItem($id)
     {
         //Fetch a cart again
         $oldCart = Session::has('cart') ? Session::get('cart') : null;
         $cart = new Cart($oldCart);
         $cart->removeItem($id);

         if(count($cart->items) > 0 ){
             Session::put('cart', $cart);
         }else{
             Session::forget('cart');
         }
         return redirect()->route('product.shoppingCart');
     }
    public function  getCart()
    {
        if (!Session::has('cart')){
            return view ('shop.shopping-cart');
            //return view ('shop.shopping-cart', ['products'=>null]);
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        return view('shop.shopping-cart', ['products' =>$cart->items, 'totalPrice' =>$cart->totalPrice]);
    }

    public  function  getCheckout()
    {
        if (!Session::has('cart')){
            return view ('shop.shopping-cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $total = $cart->totalPrice;
        return view('shop.checkout', ['total'=>$total]);
    }

    public function  postCheckout(Request $request)
    {
        if (!Session::has('cart')){
            return redirect()->route('shop.shopping-cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        Stripe::setApiKey('sk_test_mV0c75C1WoERmJ0Du7NFc9ew'); // Private Key
        try{
          $charge =   Charge::create(array(
                "amount" => $cart->totalPrice * 100,
                "currency" => "gbp",
                "source" => $request->input('stripeToken'), // obtained with Stripe.js
                "description" => "Test Charge"
            ));
          $order  = new Order();
          $order->cart = serialize($cart);
          $order->address =$request->input('address');
          $order->name =$request->input('name');
          $order->payment_id = $charge->id;

          //Relation
            Auth::user()->orders()->save($order);
        }catch(\Exception $e) {
            return redirect()->route('checkout')->with('error' ,  $e->getMessage());
        }

        Session::forget('cart');
        return redirect()->route('product.index')->with('success', 'Successfull purchased product');
    }
}
