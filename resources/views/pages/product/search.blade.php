@extends('welcome')
@section('content')
<div class="features_items"><!--features_items-->
                        <h2 class="title text-center">Search Results</h2>
                        <!-- <h2>Found {{count($search_product)}} products</h2> -->
                        @foreach($search_product as $key => $product)
                            <div class="col-sm-4">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                            <div class="productinfo text-center">
                                                <img src="{{URL::to('public/uploads/product/'.$product->product_img)}}" alt="" />
                                                <h2>{{number_format($product->product_price).' '.'VND'}}</h2>
                                                <p>{{$product->product_name}}</p>
                                                <a href="{{URL::to('/product-details/'.$product->product_id)}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                            </div>
                                            <!-- <div class="product-overlay">
                                                <div class="overlay-content">
                                                    <h2>$56</h2>
                                                    <p>Easy Polo Black Edition</p>
                                                    <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                                </div>
                                            </div> -->
                                    </div>
                                    <!-- <div class="choose">
                                        <ul class="nav nav-pills nav-justified">
                                            <li><a href="#"><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
                                            <li><a href="#"><i class="fa fa-plus-square"></i>Add to compare</a></li>
                                        </ul>
                                    </div> -->
                                </div>
                            </div>
                        @endforeach
                        <div class="block_center block_paginate">
                            {{$products->withQueryString()->link()}}
                        </div>
                        
</div><!--/recommended_items-->
@endsection