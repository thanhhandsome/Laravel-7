<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
use Cart;
session_start();

class CheckoutController extends Controller
{
    public function AuthLogin()
    {
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function login_checkout(){
    	$cate_product = DB::table('category_product')->where('category_status','0')->orderby('category_id','desc')->get();
    	$brand_product = DB::table('brand')->where('brand_status','0')->orderby('brand_id','desc')->get();

    	return view('pages.checkout.login_checkout')->with('category',$cate_product)->with('brand',$brand_product);
    }

    public function add_users(Request $request){
    	$data = array();
    	$data['name'] = $request->user_name;
    	$data['email'] = $request->user_email;
    	$data['password'] = md5($request->user_password);
    	$data['address'] = $request->user_address;
    	$data['phone'] = $request->user_phone;

    	$user_id = DB::table('users')->insertGetId($data);
    	Session::put('user_id',$user_id);
    	Session::put('name',$request->user_name);
    	return Redirect::to('/checkout');
    }

    public function checkout(){
    	$cate_product = DB::table('category_product')->where('category_status','0')->orderby('category_id','desc')->get();
    	$brand_product = DB::table('brand')->where('brand_status','0')->orderby('brand_id','desc')->get();

    	return view('pages.checkout.show_checkout')->with('category',$cate_product)->with('brand',$brand_product);
    }

    public function save_checkout_user(Request $request)
    {
    	$data = array();
    	$data['shipping_name'] = $request->shipping_name;
    	$data['shipping_email'] = $request->shipping_email;
    	$data['shipping_address'] = $request->shipping_address;
    	$data['shipping_phone'] = $request->shipping_phone;
    	$data['shipping_notes'] = $request->shipping_notes;

    	$shipping_id = DB::table('shipping')->insertGetId($data);
    	Session::put('shipping_id',$shipping_id);
    	return Redirect::to('/payment');
    }

    public function payment(){
        $cate_product = DB::table('category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('brand')->where('brand_status','0')->orderby('brand_id','desc')->get();
        return view('pages.checkout.payment')->with('category',$cate_product)->with('brand',$brand_product);
    }

    public function logout_checkout(){
    	Session::flush();
    	return Redirect::to('/login-checkout');
    }

    public function login_user(Request $request){
    	$email = $request->email_account;
    	$password = md5($request->password_account);
    	$result = DB::table('users')->where('email', $email)->where('password', $password)->first();
    	if($result){
    		Session::put('user_id',$result->user_id);
    		return Redirect::to('/checkout');
    	}
    	else{
    		return Redirect::to('/login-checkout');
    	}
    }

    public function order_place(Request $request){
        $data = array();
        $data['payment_method'] = $request->payment_options;
        $data['payment_status'] = 'Đang chờ xử lí';
        $payment_id = DB::table('payment')->insertGetId($data);

        $order_data = array();
        $order_data['user_id'] = Session::get('user_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = Cart::subtotal();
        $order_data['order_status'] = 'Đang chờ xử lí';
        $order_id = DB::table('order')->insertGetId($order_data);


        $content = Cart::content();
        foreach ($content as $v_content) {
            $order_d_data['order_id'] = $order_id;
            $order_d_data['product_id'] = $v_content->id;
            $order_d_data['product_name'] = $v_content->name;
            $order_d_data['price'] = $v_content->price;
            $order_d_data['product_qty'] = $v_content->qty;
            DB::table('order_details')->insert($order_d_data);
        }
        if($data['payment_method']==1){
            echo 'ATM card payment';
        }
        else{
            $cate_product = DB::table('category_product')->where('category_status','0')->orderby('category_id','desc')->get();
            $brand_product = DB::table('brand')->where('brand_status','0')->orderby('brand_id','desc')->get();
            Cart::destroy();
            return view('pages.checkout.handcash')->with('category',$cate_product)->with('brand',$brand_product);
        }
        

        //return Redirect::to('/payment');
    }

    public function manage_order(){
        $this->AuthLogin();
        $all_order = DB::table('order')->join('users','order.user_id','=','users.user_id')->select('order.*','users.name')->orderby('order.order_id','desc')->get();
        $manage_order = view('admin.manage_order')->with('all_order', $all_order);
        return view('admin_layout')->with('admin.manage_order', $manage_order);
    }

    public function view_order($orderId){
        $this->AuthLogin();
        $order_by_id = DB::table('order')->join('users','order.user_id','=','users.user_id')->join('shipping','order.shipping_id','=','shipping.shipping_id')->join('order_details','order.order_id','=','order_details.order_id')->select('order.*','users.*','shipping.*','order_details.*')->first();
        $manage_order_by_id = view('admin.view_order')->with('order_by_id', $order_by_id);
        return view('admin_layout')->with('admin.view_order', $manage_order_by_id);
    }
}
