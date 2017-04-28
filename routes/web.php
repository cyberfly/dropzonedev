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

Route::get('/', function () {
    return view('welcome');
});

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
Route::get('products/areas/{state_id}', 'ProductsController@getStateAreas');
Route::get('products/subcategories/{category_id}', 'ProductsController@getCategorySubcategories');
Route::resource('products','ProductsController');

