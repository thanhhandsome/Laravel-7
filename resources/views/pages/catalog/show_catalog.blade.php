@extends('welcome')
@section('content')
<div class="features_items"><!--features_items-->
                    @foreach($category_name as $key => $catalog)
                        <h2 class="title text-center">{{$catalog->category_name}}</h2>
                    @endforeach
                        @foreach($category_by_id as $key => $product)
                        <a href="{{URL::to('/product-details/'.$product->product_id)}}">
                            <div class="col-sm-4">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                            <div class="productinfo text-center">
                                                <img src="{{URL::to('public/uploads/product/'.$product->product_img)}}" alt="" />
                                                <h2>{{number_format($product->product_price).' '.'VND'}}</h2>
                                                <p>{{$product->product_name}}</p>
                                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                            </div>
                                    </div>
                                    <div class="choose">
                                        <ul class="nav nav-pills nav-justified">
                                            <li><a href="#"><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
                                            <li><a href="#"><i class="fa fa-plus-square"></i>Add to compare</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach                     
</div><!--/recommended_items-->
@endsection