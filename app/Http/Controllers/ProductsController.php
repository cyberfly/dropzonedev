<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Brand;
use App\State;
use App\Category;
use App\Area;
use App\Subcategory;
use App\Http\Requests\CreateProductRequest;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //eager loading relationship to prevent multiple db queries

        $products = Product::with('brand','subcategory','area','user');

        //conditional searching

        //if user type in textbox search by product name / product description

        if (!empty($request->search_anything)) {

            $search_anything = $request->search_anything;

            $products = $products->where(function ($query) use ($search_anything) {
                            $query->orWhere('product_name', 'like', '%'.$search_anything.'%')
                                ->orWhere('product_description', 'like' ,'%'.$search_anything.'%');
                        });
        }

        //search by state


        if (!empty($request->search_state)) {
            
            $search_state = $request->search_state;

            $products = $products->whereHas('area', function ($query) use ($search_state) {
                $query->where('state_id', $search_state);
            });

        }

        //search by category


        if (!empty($request->search_category)) {
            
            $search_category = $request->search_category;

            $products = $products->whereHas('subcategory', function ($query) use ($search_category) {
                $query->where('category_id', $search_category);
            });

        }

        //search by brand


        if (!empty($request->search_brand)) {
            $search_brand = $request->search_brand;
            $products = $products->whereBrandId($search_brand);
        }

        //search by area

        if (!empty($request->search_area)) {
            $search_area = $request->search_area;
            $products = $products->whereAreaId($search_area);
        }

        //search by subcategory

        if (!empty($request->search_subcategory)) {
            $search_subcategory = $request->search_subcategory;
            $products = $products->whereSubcategoryId($search_subcategory);
        }

        //sort by latest product

        $products = $products->orderBy('id','desc');

        //paginate the data

        $products = $products->paginate(5);

        //load additional data for searching

        $brands = Brand::pluck('brand_name','id');

        $categories = Category::pluck('category_name','id');
        
        $states = State::pluck('state_name','id');

        return view('products.index',compact('products','brands','categories','states'));         
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::pluck('brand_name','id');
        $states = State::pluck('state_name','id');
        $categories = Category::pluck('category_name','id');

        return view('products.create',compact('brands','states','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        $product = new Product;

        $product->product_name = $request->product_name;
        $product->product_description = $request->product_description;
        $product->product_price = $request->product_price;
        $product->brand_id = $request->brand_id;
        $product->area_id = $request->area_id;
        $product->subcategory_id = $request->subcategory_id;
        $product->condition = $request->condition;

        //dapatkan current user id
        $product->user_id = auth()->id();


        //if have file to upload


        if ($request->hasFile('product_image')) {

            $path = $request->product_image->store('public/uploads');

            //save product image name
            $product->product_image = $request->product_image->hashName();
            
        }


        $product->save();

        //selepas berjaya simpan, set success message

        flash('Product successfully inserted')->success();

        //kembali ke senarai product

        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //dapatkan maklumat produk sedia ada
        $product = Product::find($id);

        $brands = Brand::pluck('brand_name','id');
        $states = State::pluck('state_name','id');
        $categories = Category::pluck('category_name','id');

        //get area based on previously selected state

        $areas = $this->getStateAreas($product->area->state_id);
        $subcategories = $this->getCategorySubcategories($product->subcategory->category_id);

        return view('products.edit',compact('brands','states','categories','product','areas','subcategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->product_name = $request->product_name;
        $product->product_description = $request->product_description;
        $product->product_price = $request->product_price;
        $product->brand_id = $request->brand_id;
        $product->area_id = $request->area_id;
        $product->subcategory_id = $request->subcategory_id;
        $product->condition = $request->condition;

        //if have file to upload

        if ($request->hasFile('product_image')) {

            $path = $request->product_image->store('public/uploads');

            //save product image name
            $product->product_image = $request->product_image->hashName();
            
        }

        $product->save();

        //selepas berjaya simpan, set success message

        flash('Product successfully updated')->success();

        //kembali ke senarai product

        return redirect()->route('products.edit',$product->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        flash('Product successfully deleted')->success();

        return redirect()->route('products.index');


    }

    //return areas for state

    public function getStateAreas($state_id)
    {
        $areas = Area::whereStateId($state_id)->pluck('area_name','id');

        return $areas;
    }

    //return subcategory for Category

    public function getCategorySubcategories($category_id)
    {
        $subcategories = Subcategory::whereCategoryId($category_id)->pluck('subcategory_name','id');

        return $subcategories;
    }
}
