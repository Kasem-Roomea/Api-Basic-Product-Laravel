<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(["namespace"=>"App\Http\Controllers"] , function()
{
    Route::post('/product', 'productsController@index');
    Route::post('/registers' ,'productsController@registers' );
    Route::post('/login' ,'productsController@login' );
});

Route::group(["namespace"=>"App\Http\Controllers","middleware"=>["auth:sanctum"]] , function()
{
    Route::post('/product/search/{id}', 'productsController@searchProduct');
    Route::post('/product/add', 'productsController@AddProduct');
    Route::post('/product/update/{id}', 'productsController@updateProduct');
    Route::post('/product/delete/{id}', 'productsController@destroyProduct');
    Route::post('/logout' ,'productsController@logout' );
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
