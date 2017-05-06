@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">View Product</div>

                <div class="panel-body">


                  <!-- tambah form kat sini -->

                  {!! Form::open() !!}

                  <h2>{{ $product->product_name }}</h2>

                  <div class="form-group">
                    
                    @if(!empty($product->product_image))
                      <img src="{{ asset('storage/uploads/'.$product->product_image) }}" class="img-responsive">
                    @endif

                  </div>

                  <!-- product_description textarea -->
                  <div class="form-group {{ $errors->has('product_description') ? 'has-error' : false }} ">  
                      {!! Form::label('product_description', 'Product Description') !!}
                      {!! Form::textarea('product_description',$product->product_description,['class'=>'form-control']);  !!}
                  </div>

                  <div class="form-group {{ $errors->has('category_id') ? 'has-error' : false }} ">
                      {!! Form::label('category_id', 'Category') !!}   
                      {!! Form::text('category_name',$product->subcategory->category->category_name,['class'=>'form-control']);  !!}
  
                  </div>

                  <div class="form-group {{ $errors->has('subcategory_id') ? 'has-error' : false }} ">
                      {!! Form::label('subcategory_name', 'SubCategory') !!}   
                      {!! Form::text('subcategory_name',$product->subcategory->subcategory_name,['class'=>'form-control']);  !!}
                  </div>

                  <div class="form-group {{ $errors->has('state_id') ? 'has-error' : false }} ">
                      {!! Form::label('state_name', 'State') !!}   
                      {!! Form::text('state_name',$product->area->state->state_name,['class'=>'form-control']);  !!}
                  </div>

                  <div class="form-group {{ $errors->has('area_id') ? 'has-error' : false }} ">
                      {!! Form::label('area_name', 'Area') !!}   
                      {!! Form::text('area_name',$product->area->area_name,['class'=>'form-control']);  !!}
                  </div>

                  <div class="form-group {{ $errors->has('brand_id') ? 'has-error' : false }} ">
                      {!! Form::label('brand_name', 'Brand') !!}   
                      {!! Form::text('brand_name',$product->brand->brand_name,['class'=>'form-control']);  !!}

                  </div>

                  

                  <!-- product_price textfield -->
                  <div class="form-group {{ $errors->has('product_price') ? 'has-error' : false }} ">  
                      {!! Form::label('product_price', 'Product Price') !!}
                      {!! Form::number('product_price',$product->product_price,['class'=>'form-control']);  !!}
                  </div>

                  <div class="form-group {{ $errors->has('condition') ? 'has-error' : false }} ">
                      {!! Form::label('condition', 'Product Condition') !!}
                      {!! Form::text('condition',$product->condition,['class'=>'form-control']);  !!}
                  </div>

                  


                  {!! Form::close() !!}

                  <!-- tutup form kat sini -->

                </div>
            </div>
        </div>
    </div>
</div>
@endsection



