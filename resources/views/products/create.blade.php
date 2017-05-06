@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">Create Product</div>

                <div class="panel-body">

                  <!-- papar validation error  -->

                  @if($errors->all())

                  <div class="alert alert-danger" role="alert">

                        <p>Validation Error. Please fix this error below:</p>

                        <ul>
                        @foreach ($errors->all() as $message)
                          <li>{{ $message }}</li>
                        @endforeach
                        </ul>  

                  </div>

                  @endif 


                  <!-- tambah form kat sini -->

                  {!! Form::open(['route' => 'products.store', 'files' => true ]) !!}

                  <div class="form-group {{ $errors->has('category_id') ? 'has-error' : false }} ">
                      {!! Form::label('category_id', 'Category') !!}   
                      {!! Form::select('category_id', $categories, null, ['placeholder' => 'Select Category','class'=>'form-control','id'=>'category_id']); !!}
                  </div>

                  <div class="form-group {{ $errors->has('subcategory_id') ? 'has-error' : false }} ">
                      {!! Form::label('subcategory_id', 'SubCategory') !!}   
                      {!! Form::select('subcategory_id', [], null, ['placeholder' => 'Select SubCategory','class'=>'form-control','id'=>'subcategory_id']); !!}
                  </div>

                  <div class="form-group {{ $errors->has('state_id') ? 'has-error' : false }} ">
                      {!! Form::label('state_id', 'State') !!}   
                      {!! Form::select('state_id', $states, null, ['placeholder' => 'Select State','class'=>'form-control','id'=>'state_id']); !!}
                  </div>

                  <div class="form-group {{ $errors->has('area_id') ? 'has-error' : false }} ">
                      {!! Form::label('area_id', 'Area') !!}   
                      {!! Form::select('area_id', [], null, ['placeholder' => 'Select Area','class'=>'form-control','id'=>'area_id']); !!}
                  </div>

                  <div class="form-group {{ $errors->has('brand_id') ? 'has-error' : false }} ">
                      {!! Form::label('brand_id', 'Brand') !!}   
                      {!! Form::select('brand_id', $brands, null, ['placeholder' => 'Select Brand','class'=>'form-control']); !!}
                  </div>
                    
                  <!-- product_name textfield -->
                  <div class="form-group {{ $errors->has('product_name') ? 'has-error' : false }} ">  
                  
                      {!! Form::label('product_name', 'Product Name') !!}
                      {!! Form::text('product_name','',['class'=>'form-control']);  !!}

                  </div>

                  <!-- product_description textarea -->
                  <div class="form-group {{ $errors->has('product_description') ? 'has-error' : false }} ">  
                      {!! Form::label('product_description', 'Product Description') !!}
                      {!! Form::textarea('product_description','',['class'=>'form-control']);  !!}
                  </div>

                  <!-- product_price textfield -->
                  <div class="form-group {{ $errors->has('product_price') ? 'has-error' : false }} ">  
                      {!! Form::label('product_price', 'Product Price') !!}
                      {!! Form::number('product_price','',['class'=>'form-control']);  !!}
                  </div>

                  <div class="form-group {{ $errors->has('condition') ? 'has-error' : false }} ">
                      {!! Form::label('condition', 'Condition') !!}
                      {!! Form::radio('condition', 'new', true);  !!} New
                      {!! Form::radio('condition', 'used', false);  !!} Used
                  </div>

                  <div class="form-group {{ $errors->has('product_image') ? 'has-error' : false }}">
                      {!! Form::label('product_image', 'Product Image') !!}
                      {!! Form::file('product_image') !!}
                  </div>

                  <div class="form-group">
                      
                      <button type="submit" class="btn btn-primary">Submit</button>

                      <a href="{{ route('my_products') }}" class="btn btn-default">Cancel</a>

                  </div>


                  {!! Form::close() !!}

                  <!-- tutup form kat sini -->

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')

<script type="text/javascript">
    
    $( document ).ready(function() {
        
        //dapatkan previous selected state_id bila validation error

        var selected_state_id = '{{ old('state_id') }}';

        //kalau ada selected state_id, kita panggil balik function ajax dapatkan area

        if (selected_state_id.length>0) {
            
            getStateAreas(selected_state_id);

        };

        var selected_category_id = '{{ old('category_id') }}';

        if (selected_category_id.length>0) {
            
            getCategorySubcategories(selected_category_id);

        };

        function getStateAreas(state_id){

          //define route untuk hantar id state ke controller, grab data area

          var ajax_url = '/products/areas/' + state_id;

          //dapatkan areas data dari Controller menggunakan Ajax

          $.get( ajax_url, function( data ) {
            
            // dah dapat data, kosongkan dulu dropdown area dan tambah Select Area

            $('#area_id').empty().append('<option value="">Select Area</option');

            // loop data untuk hasilkan senarai option baru bagi dropdown

            $.each(data, function(area_id,area_name){
            
                $('#area_id').append('<option value='+area_id+'>'+area_name+'</option');
            });

            //dapatkan previous selected area if there is form validation error
            var selected_area_id = '{{ old('area_id') }}';

            if (selected_area_id.length>0) {
                //pilih balik area based on previous selected are
                $('#area_id').val(selected_area_id);
            };

          });


        }

        function getCategorySubcategories(category_id){

            //hantar id state ke controller, grab data area

            var ajax_url = '/products/subcategories/' + category_id;

            $.get( ajax_url, function( data ) {
              
              // console.log(data);

              $('#subcategory_id').empty().append('<option value="">Select SubCategory</option');

              $.each(data, function(subcategory_id,subcategory_name){
              
                  $('#subcategory_id').append('<option value='+subcategory_id+'>'+subcategory_name+'</option');
              });

              //dapatkan previous selected subcategory if there is form validation error
              var selected_subcategory_id = '{{ old('subcategory_id') }}';

              if (selected_subcategory_id.length>0) {
                  //pilih balik subcategory based on previous selected are
                  $('#subcategory_id').val(selected_subcategory_id);
              };

            });

        }

        //bila setiap kali pengguna tukar State, buat function di bawah

        $( "#state_id" ).change(function() {
          
          //dapatkan value state yang kita pilih
          var state_id = $(this).val();

          getStateAreas(state_id);
        
        });

        $( "#category_id" ).change(function() {
          
          //dapatkan value state yang kita pilih
          var category_id = $(this).val();

          getCategorySubcategories(category_id);
        
        });


    });


</script>

@endsection
