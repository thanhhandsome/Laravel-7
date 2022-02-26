<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class HomeController extends Controller
{
    public function index(){

    	$cate_product = DB::table('category_product')->where('category_status','0')->orderby('category_id','desc')->get();
    	$brand_product = DB::table('brand')->where('brand_status','0')->orderby('brand_id','desc')->get();
        // $products = DB::table('product')->paginate(2);
    	// $all_product = DB::table('product')->join('category_product','category_product.category_id','=','product.category_id')->join('brand','brand.brand_id','=','product.brand_id')->orderby('product.product_id','desc')->get();
    	$all_product = DB::table('product')->where('product_status','0')->orderby('product_id','desc')->limit(6)->get();
    	return view('pages.home')->with('category',$cate_product)->with('brand',$brand_product)->with('all_product',$all_product);
    }

    public function search(Request $request){

    	$cate_product = DB::table('category_product')->where('category_status','0')->orderby('category_id','desc')->get();
    	$brand_product = DB::table('brand')->where('brand_status','0')->orderby('brand_id','desc')->get();
    	$keywords = $request->key_words;
    	// $all_product = DB::table('product')->join('category_product','category_product.category_id','=','product.category_id')->join('brand','brand.brand_id','=','product.brand_id')->orderby('product.product_id','desc')->get();
    	// $all_product = DB::table('product')->where('product_status','0')->orderby('product_id','desc')->limit(4)->get();
    	$search_product = DB::table('product')->where('product_name','like','%'.$keywords.'%')->orwhere('product_desc','like','%'.$keywords.'%')->paginate(2)->get();
        // $category_product = Category::paginate(4);
    	return view('pages.product.search')->with('category',$cate_product)->with('brand',$brand_product)->with('search_product', $search_product);
    }
    // public function phan_trang(){

    //     $product = DB::table('product')->where('product_name')->panigate(2)->get();
    //     // $brand_product = DB::table('brand')->where('brand_status','0')->orderby('brand_id','desc')->get();

    //     // $all_product = DB::table('product')->join('category_product','category_product.category_id','=','product.category_id')->join('brand','brand.brand_id','=','product.brand_id')->orderby('product.product_id','desc')->get();
    //     // $all_product = DB::table('product')->where('product_status','0')->orderby('product_id','desc')->limit(6)->get();
    //     return view('pages.home')->with('product',$product);
    // }
}
