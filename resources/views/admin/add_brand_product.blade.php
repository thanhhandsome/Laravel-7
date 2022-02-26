@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Add Brand Product
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
                                <form role="form" action="{{URL::to('/save-brand-product')}}" method="post">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Brand Name</label>
                                    <input type="text" name="brand_product_name" class="form-control" id="exampleInputEmail1" placeholder="Product Name">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Brand description</label>
                                    <textarea style="resize: none" rows="5" class="form-control" name="brand_product_description" id="exampleInputPassword1" placeholder="brand description">
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Show</label>
                                        <select name="brand_product_status" class="form-control input-sm m-bot15">
                                            <option value="0">Hidden</option>
                                            <option value="1">Show</option>
                                        </select>
                                </div>
                                <button type="submit" name="add_brand_product" class="btn btn-info">Add Brand</button>
                            </form>
                            </div>

                        </div>
                    </section>
            </div>        

</div>
@endsection