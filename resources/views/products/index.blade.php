@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            

            <div class="panel panel-primary">
                <div class="panel-heading">Search Product</div>

                <div class="panel-body">

                    <form action="{{ route('products.index') }}" method="GET" >
                        

                    <div class="row">
                        
                        <div class="col-md-3">

                            <div class="form-group">
                                {!! Form::label('search_state', 'State') !!}   
                                {!! Form::select('search_state', $states, Request::get('search_state'), ['placeholder' => 'Select State','class'=>'form-control', 'id'=>'state_id']); !!}
                            </div>
                            
                        </div>

                        <div class="col-md-3">

                        <div class="form-group">
                            {!! Form::label('search_category', 'Category') !!}   
                            {!! Form::select('search_category', $categories, Request::get('search_category'), ['placeholder' => 'Select Category','class'=>'form-control', 'id'=>'category_id']); !!}
                        </div>
                            
                        </div>

                        <div class="col-md-3">

                        <div class="form-group">
                            {!! Form::label('search_brand', 'Brand') !!}   
                            {!! Form::select('search_brand', $brands, Request::get('search_brand'), ['placeholder' => 'Select Brand','class'=>'form-control']); !!}
                        </div>
                            
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('search_anything', 'By Product Name/Desc') !!}
                                {!! Form::text('search_anything',Request::get('search_anything'),['class'=>'form-control']);  !!} 
                            </div>
                        </div>

                        <div class="col-md-1">

                            <div class="form-group" style="padding-top:27px;">

                                <button type="submit" class="btn btn-success">Search</button>
                            </div>
                            
                        </div>

                    </div>

                    <!-- row untuk search by area and subcategory -->

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                               
                               {!! Form::label('search_area', 'Area') !!}   
                               {!! Form::select('search_area', [], null, ['placeholder' => 'Select Area','class'=>'form-control','id'=>'area_id']); !!}


                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                
                                {!! Form::label('search_subcategory', 'SubCategory') !!}   
                                {!! Form::select('search_subcategory', [], null, ['placeholder' => 'Select SubCategory','class'=>'form-control','id'=>'subcategory_id']); !!}

                            </div>
                        </div>
                    </div>


                    </form> 


                </div>
            </div>    



            <div class="panel panel-warning">
                <div class="panel-heading">Manage Products</div>

                <div class="panel-body">

                    <a href="{{ route('products.create') }}" class="btn btn-warning">Create Product</a>
                    
                    <table class="table table-bordered table-hover table-striped">
                        
                        <thead>
                            <tr>
                                <th>Product Title</th>
                                <th>Product Description</th>
                                <th>Price</th>
                                <th>Location</th>
                                <th>Condition</th>
                                <th>Category</th>
                                <th>User</th>
                                <th>Brand</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($products as $product)
                            
                            <tr>
                                <td>
                                    {{ $product->product_name }}
                                </td>
                                <td>
                                    {{ $product->product_description }}
                                </td>
                                <td>
                                    {{ $product->product_price }}
                                </td>
                                <td>
                                    {{ $product->area->area_name }}, {{ $product->area->state->state_name }}
                                </td>
                                <td>
                                    {{ $product->condition }}
                                </td>
                                <td>
                                    {{ $product->subcategory->subcategory_name }}
                                </td>
                                <td>
                                    {{ $product->user->name or '' }}
                                </td>
                                <td>
                                    {{ $product->brand->brand_name }}
                                </td>
                                <td>
                                    <a href="{{ route('products.edit',$product->id) }}" class="btn btn-info">Edit</a>
                                </td>
                            </tr>

                            @endforeach


                        </tbody>

                    </table>

                    <!-- pagination link -->
                    {{ $products->appends(Request::except('page'))->links() }}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

<script type="text/javascript">
    

$( document ).ready(function() {

    //bila pengguna select state, panggil ajax function getarea by state

    $( "#state_id" ).change(function() {
      
      //dapatkan value state yang kita pilih
      var state_id = $(this).val();

      getStateAreas(state_id);
    
    });

    //bila pengguna click pada pagination, reload balik areas based on selected state

    var selected_state_id = '{{ Request::get('search_state') }}';

    // console.log(selected_state_id);

    //kalau ada selected state_id, kita panggil balik function ajax dapatkan area

    if (selected_state_id.length>0) {
        
        getStateAreas(selected_state_id);

    };

    //ajax function get areas by state

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
            var selected_area_id = '{{ Request::get('search_area') }}';

            if (selected_area_id.length>0) {
                //pilih balik area based on previous selected are
                $('#area_id').val(selected_area_id);
            };

          });


    }

    //bila pengguna pilih category

    $( "#category_id" ).change(function() {
      
      //dapatkan value state yang kita pilih
      var category_id = $(this).val();

      getCategorySubcategories(category_id);
    
    });

    //bila pengguna click pada pagination, reload balik subcategories based on selected category

    var selected_category_id = '{{ Request::get('search_subcategory') }}';

    if (selected_category_id.length>0) {
        
        getCategorySubcategories(selected_category_id);

    };

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
          var selected_subcategory_id = '{{ Request::get('search_subcategory') }}';

          if (selected_subcategory_id.length>0) {
              //pilih balik subcategory based on previous selected are
              $('#subcategory_id').val(selected_subcategory_id);
          };

        });

    }

});    

</script>


@endsection
