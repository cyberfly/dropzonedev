<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'ProductsController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');

// route for State
Route::resource('states','StatesController');

//route for Area
Route::resource('areas','AreasController');

//route for Category
Route::resource('categories','CategoriesController');

//route for SubCategory
Route::resource('subcategories','SubcategoriesController');

//route for Brand
Route::resource('brands','BrandsController');

//route for Listing Type
Route::resource('listingtypes','ListingTypesController');

//route for Products
Route::get('my_products', 'ProductsController@my_products')->name('my_products');
Route::get('products/areas/{state_id}', 'ProductsController@getStateAreas');
Route::get('products/subcategories/{category_id}', 'ProductsController@getCategorySubcategories');
Route::resource('products','ProductsController');


//route for Admin 

Route::group(['prefix' => 'admin','as'=>'admin.'], function () {
    
    //route for Products
    Route::get('products/areas/{state_id}', 'Admin\AdminProductsController@getStateAreas');
    Route::get('products/subcategories/{category_id}', 'Admin\AdminProductsController@getCategorySubcategories');
    Route::resource('products','Admin\AdminProductsController');

    //route for brand

    //route for category


});

