@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Add Category Product
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
                                <form role="form" action="{{URL::to('/save-category-product')}}" method="post">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Product Name</label>
                                    <input type="text" name="category_product_name" class="form-control" id="exampleInputEmail1" placeholder="Product Name">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Category description</label>
                                    <textarea style="resize: none" rows="5" class="form-control" name="category_product_description" id="exampleInputPassword1" placeholder="Category description">
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Show</label>
                                        <select name="category_product_status" class="form-control input-sm m-bot15">
                                            <option value="0">Hidden</option>
                                            <option value="1">Show</option>
                                        </select>
                                </div>
                                <button type="submit" name="add_category_product" class="btn btn-info">Add</button>
                            </form>
                            </div>

                        </div>
                    </section>
            </div>        

</div>
@endsection