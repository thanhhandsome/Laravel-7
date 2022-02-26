@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Update Brand Product
                        </header>
                            <?php
                                $message = Session::get('message');
                                if($message){
                                    echo "<script>alert('$message');</script>";
                                    Session::put('message', null);
                                }
                            ?>
                        <div class="panel-body">
                            @foreach($edit_brand_product as $key => $edit_value)
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/update-brand-product/'.$edit_value->brand_id)}}" method="post">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Product Name</label>
                                    <input type="text" value="{{$edit_value->brand_name}}" name="brand_product_name" class="form-control" id="exampleInputEmail1" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">brand description</label>
                                    <textarea style="resize: none" rows="5" class="form-control" name="brand_product_description" id="exampleInputPassword1">{{$edit_value->brand_desc}}
                                    </textarea>
                                </div>
                                <button type="submit" name="update_brand_product" class="btn btn-info">Update</button>
                            </form>
                            </div>
                            @endforeach
                        </div>
                    </section>
            </div>        

</div>
@endsection