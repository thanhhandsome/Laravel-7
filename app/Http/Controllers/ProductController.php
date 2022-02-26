<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class ProductController extends Controller
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
    public function add_product()
    {
    	$this->AuthLogin();
    	$cate_product = DB::table('category_product')->orderby('category_id','desc')->get();
    	$brand_product = DB::table('brand')->orderby('brand_id','desc')->get();
    	return view('admin.add_product')->with('cate_product', $cate_product)->with('brand_product', $brand_product);
    }
    public function all_product()
    {
    	$this->AuthLogin();
    	$all_product = DB::table('product')->join('category_product','category_product.category_id','=','product.category_id')->join('brand','brand.brand_id','=','product.brand_id')->orderby('product.product_id','desc')->get();
    	$manage_product = view('admin.all_product')->with('all_product', $all_product);
    	return view('admin_layout')->with('admin.all_product', $manage_product);
    }
    public function save_product(Request $request)
    {
    	$this->AuthLogin();
    	$data = array();
    	$data['product_name'] = $request->product_name;
    	$data['product_desc'] = $request->product_description;
    	$data['product_price'] = $request->product_price;
    	$data['product_img'] = $request->product_image;
    	$data['category_id'] = $request->product_cate;
    	$data['brand_id'] = $request->product_brand;
    	$data['product_status'] = $request->product_status;

    	$get_image = $request->file('product_image');
    	if($get_image){
    		$get_name_image = $get_image->getClientOriginalName();
    		$name_image = current(explode('.', $get_name_image));
    		$new_image = $name_image.'.'.$get_image->getClientOriginalExtension();
    		$get_image->move('public/uploads/product', $new_image);
    		$data['product_img'] = $new_image;
    		DB::table('product')->insert($data);
	    	Session::put('message', 'Add product successfully');
	    	return Redirect::to('add-product');
	    	//rand(0,99)
    	}
    	$data['product_img'] = '';
    	DB::table('product')->insert($data);
    	Session::put('message', 'Add product successfully');
    	return Redirect::to('all-product');
    }
    public function unactive_product($product_id)
    {
    	$this->AuthLogin();
    	DB::table('product')->where('product_id', $product_id)->update(['product_status'=>1]);
    	Session::put('message', 'Not activated successfully');
    	return Redirect::to('all-product');
    }
    public function active_product($product_id)
    {
    	$this->AuthLogin();
    	DB::table('product')->where('product_id', $product_id)->update(['product_status'=>0]);
    	Session::put('message', 'Activated successfully');
    	return Redirect::to('all-product');
    }
    public function edit_product($product_id)
    {
    	$this->AuthLogin();
    	$cate_product = DB::table('category_product')->orderby('category_id','desc')->get();
    	$brand_product = DB::table('brand')->orderby('brand_id','desc')->get();
    	$edit_product = DB::table('product')->where('product_id', $product_id)->get();
    	$manage_product = view('admin.edit_product')->with('edit_product', $edit_product)->with('cate_product', $cate_product)->with('brand_product', $brand_product);
    	return view('admin_layout')->with('admin.edit_product', $manage_product);
    }
    public function update_product(Request $request ,$product_id)
    {
    	$this->AuthLogin();
    	$data = array();
    	$data['product_name'] = $request->product_name;
    	$data['product_desc'] = $request->product_description;
    	$data['product_price'] = $request->product_price;
    	$data['category_id'] = $request->product_cate;
    	$data['brand_id'] = $request->product_brand;
    	$data['product_status'] = $request->product_status;
    	$get_image = $request->file('product_image');

    	if($get_image){
    		$get_name_image = $get_image->getClientOriginalName();
    		$name_image = current(explode('.', $get_name_image));
    		$new_image = $name_image.'.'.$get_image->getClientOriginalExtension();
    		$get_image->move('public/uploads/product', $new_image);
    		$data['product_img'] = $new_image;
    		DB::table('product')->where('product_id', $product_id)->update($data);
	    	Session::put('message', 'Update product successfully');
	    	return Redirect::to('all-product');
	    	//rand(0,99)
    	}
    	DB::table('product')->where('product_id', $product_id)->update($data);
    	Session::put('message', 'Update product successfully');
    	return Redirect::to('all-product');
    }
    public function delete_product($product_id)
    {
    	$this->AuthLogin();
    	DB::table('product')->where('product_id', $product_id)->delete();
    	Session::put('message', 'Delete product successfully');
    	return Redirect::to('all-product');
    }
    //end function
    public function product_details($product_id)
    {
        $cate_product = DB::table('category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('brand')->where('brand_status','0')->orderby('brand_id','desc')->get();

        $details_product = DB::table('product')->join('category_product','category_product.category_id','=','product.category_id')->join('brand','brand.brand_id','=','product.brand_id')->where('product.product_id', $product_id)->get();

        foreach ($details_product as $key => $value) {
            $category_id = $value->category_id;
        }
        $related_product = DB::table('product')->join('category_product','category_product.category_id','=','product.category_id')->join('brand','brand.brand_id','=','product.brand_id')->where('category_product.category_id', $category_id)->whereNotIn('product.product_id', [$product_id])->get();
        return view('pages.product.show_details')->with('category',$cate_product)->with('brand',$brand_product)->with('product_details',$details_product)->with('relate',$related_product);
    }
}
