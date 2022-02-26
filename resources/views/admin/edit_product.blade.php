@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Update Product
                        </header>
                            <?php
                                $message = Session::get('message');
                                if($message){
                                    echo "<script>alert('$message');</script>";
                                    Session::put('message', null);
                                }
                            ?>
                        <div class="panel-body">
                            <div class="position-center">
                                @foreach($edit_product as $key => $pro)
                                <form role="form" action="{{URL::to('/update-product/'.$pro->product_id)}}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Product Name</label>
                                    <input type="text" name="product_name" class="form-control" id="exampleInputEmail1" value="{{$pro->product_name}}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Product description</label>
                                    <textarea style="resize: none" rows="5" class="form-control" name="product_description" id="exampleInputPassword1">{{$pro->product_desc}}
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Product Price</label>
                                    <input type="text" name="product_price" class="form-control" id="exampleInputEmail1" value="{{$pro->product_price}}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Product image</label>
                                    <input type="file" name="product_image" class="form-control" id="exampleInputEmail1">
                                    <img src="{{URL::to('public/uploads/product/'.$pro->product_img)}}" width="100" height="100">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Product portfolio</label>
                                        <select name="product_cate" class="form-control input-sm m-bot15">
                                            @foreach($cate_product as $key => $cate)
                                                @if($cate->category_id == $pro->category_id)
                                                  <option selected value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                                @else
                                                  <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Product brands</label>
                                        <select name="product_brand" class="form-control input-sm m-bot15">
                                            @foreach($brand_product as $key => $brand)
                                                @if($cate->category_id == $pro->category_id)
                                                    <option selected value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                                @else
                                                    <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Show</label>
                                        <select name="product_status" class="form-control input-sm m-bot15">
                                            <option value="0">Hidden</option>
                                            <option value="1">Show</option>
                                        </select>
                                </div>
                                <button type="submit" name="update_product" class="btn btn-info">Update</button>
                            </form>
                            @endforeach
                            </div>

                        </div>
                    </section>
            </div>        

</div>
@endsection