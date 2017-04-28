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
    public function index()
    {
        $products = Product::all();

        return view('products.index',compact('products'));         
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

        $product->save();

        //selepas berjaya simpan, kembali ke senarai product

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
