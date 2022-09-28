<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductsController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SubcategoryController;
use App\Http\Controllers\Api\MainCategoryController;
use App\Http\Controllers\Api\AuthController;


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

//Protected routes
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);


//public routes
Route::get('products',[ProductsController::class,'index']);
Route::get('products/{id}',[ProductsController::class,'show']);
Route::get('products/search/{id}',[ProductsController::class,'search']);
Route::get('categories',[CategoryController::class,'index']);
Route::get('categories/{id}',[CategoryController::class,'show']);
Route::get('categories/search/{id}',[CategoryController::class,'search']);
Route::get('subcategories',[SubcategoryController::class,'index']);
Route::get('subcategories/{id}',[SubcategoryController::class,'show']);
Route::get('subcategories/search/{id}',[SubcategoryController::class,'search']);
Route::get('maincategories',[MainCategoryController::class,'index']);
Route::get('maincategories/{id}',[MainCategoryController::class,'show']);
Route::get('maincategories/search/{id}',[MainCategoryController::class,'search']);
Route::get('products/cart/{id}',[ProductsController::class,'addToCart']);



//Protected routes
Route::group(['middleware'=> ['auth:sanctum']], function () { 
    Route::post('/logout',[AuthController::class,'logout']);
});
