<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class CategoryProduct extends Controller
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
    public function add_category_product()
    {
        $this->AuthLogin();
    	return view('admin.add_category_product');
    }
    public function all_category_product()
    {
        $this->AuthLogin();
    	$all_category_product = DB::table('category_product')->get();
    	$manage_category_product = view('admin.all_category_product')->with('all_category_product', $all_category_product);
    	return view('admin_layout')->with('admin.all_category_product', $manage_category_product);
    }
    public function save_category_product(Request $request)
    {
        $this->AuthLogin();
    	$data = array();
    	$data['category_name'] = $request->category_product_name;
    	$data['category_desc'] = $request->category_product_description;
    	$data['category_status'] = $request->category_product_status;
    	DB::table('category_product')->insert($data);
    	Session::put('message', 'Add product category successfully');
    	return Redirect::to('add-category-product');
    }
    public function unactive_category_product($category_product_id)
    {
        $this->AuthLogin();
    	DB::table('category_product')->where('category_id', $category_product_id)->update(['category_status'=>1]);
    	Session::put('message', 'Not activated category successfully');
    	return Redirect::to('all-category-product');
    }
    public function active_category_product($category_product_id)
    {
        $this->AuthLogin();
    	DB::table('category_product')->where('category_id', $category_product_id)->update(['category_status'=>0]);
    	Session::put('message', 'Activated category successfully');
    	return Redirect::to('all-category-product');
    }
    public function edit_category_product($category_product_id)
    {
        $this->AuthLogin();
    	$edit_category_product = DB::table('category_product')->where('category_id', $category_product_id)->get();
    	$manage_category_product = view('admin.edit_category_product')->with('edit_category_product', $edit_category_product);
    	return view('admin_layout')->with('admin.edit_category_product', $manage_category_product);
    }
    public function update_category_product(Request $request ,$category_product_id)
    {
        $this->AuthLogin();
    	$data = array();
    	$data['category_name'] = $request->category_product_name;
    	$data['category_desc'] = $request->category_product_description;
    	DB::table('category_product')->where('category_id', $category_product_id)->update($data);
    	Session::put('message', 'Update product category successfully');
    	return Redirect::to('all-category-product');
    }
    public function delete_category_product($category_product_id)
    {
        $this->AuthLogin();
    	DB::table('category_product')->where('category_id', $category_product_id)->delete();
    	Session::put('message', 'Delete product category successfully');
    	return Redirect::to('all-category-product');
    }
    //End function page
    public function show_catalog_home($category_id)
    {
        $cate_product = DB::table('category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('brand')->where('brand_status','0')->orderby('brand_id','desc')->get();
        $category_by_id = DB::table('product')->join('category_product','product.category_id','=','category_product.category_id')->where('product.category_id',$category_id)->get();
        $category_name = DB::table('category_product')->where('category_product.category_id',$category_id)->limit(1)->get();
        return view('pages.catalog.show_catalog')->with('category',$cate_product)->with('brand',$brand_product)->with('category_by_id',$category_by_id)->with('category_name',$category_name);
    }

}
