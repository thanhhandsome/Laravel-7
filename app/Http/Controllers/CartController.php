<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
use Cart;
session_start();

class CartController extends Controller
{
    public function save_cart(Request $request){

    	$productId = $request->productid_hidden;
    	$quantity = $request->qty;

    	$product_info = DB::table('product')->where('product_id',$productId)->first();

    	$data['id'] = $product_info->product_id;
    	$data['qty'] = $quantity;
    	$data['name'] = $product_info->product_name;
    	$data['price'] = $product_info->product_price;
    	$data['weight'] = $product_info->product_price;
    	$data['options']['image'] = $product_info->product_img;
    	Cart::add($data);
    	return Redirect::to('/show-cart');
    	
    }
    public function show_cart(){
    	$cate_product = DB::table('category_product')->where('category_status','0')->orderby('category_id','desc')->get();
    	$brand_product = DB::table('brand')->where('brand_status','0')->orderby('brand_id','desc')->get();
    	return view('pages.cart.show_cart')->with('category',$cate_product)->with('brand',$brand_product);
    }

    public function delete_cart($rowId){
    	Cart::update($rowId, 0);
    	return Redirect::to('/show-cart');
    }

    public function update_cart_qty(Request $request){
    	$rowId = $request->rowId_cart;
    	$qty = $request->quantity_cart;
    	Cart::update($rowId, $qty);
    	return Redirect::to('/show-cart');
    }
}
