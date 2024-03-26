<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DescriptionController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PaymentController;


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

Route::middleware('auth:sanctum')->group( function () {
    Route::post('logout',[UserController::class,'logout']);

    // Product Route 
    Route::post('addproduct',[ProductController::class,'addProduct']);

    // Description Routes
    Route::post('add-description',[DescriptionController::class,'addDescription']);
    Route::post('update-description/{id}',[DescriptionController::class,'updateDescription']);

    // Stock Route
    Route::post('addstock',[StockController::class,'addStock']);
    Route::post('updatestock/{id}',[StockController::class,'updateStock']);

    // Payment Route
        Route::post('addpayment',[PaymentController::class,'addPayment']);

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// User API's Routes
Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);

// Customer API's Routes
Route::post('cregister',[CustomerController::class,'register']);
Route::post('clogin',[CustomerController::class,'login']);
Route::get('clist',[CustomerController::class,'customerList']);
Route::delete('deletecustomer/{id}',[CustomerController::class,'deleteCustomer']);


// Product API's Routes
Route::get('list',[ProductController::class,'list']);
Route::get('product/{id}',[ProductController::class,'getProduct']);
Route::get('search/{key}',[ProductController::class,'search']);

// Product Description API's Routes
Route::get('descriptionlist',[DescriptionController::class,'descriptionList']);
Route::get('getdescription/{id}',[DescriptionController::class,'getDescription']);
Route::delete('delete/{id}',[DescriptionController::class,'delete']);

// Stock API's Routes
Route::get('stocklist',[StockController::class,'stockList']);
Route::get('getstock/{id}',[StockController::class,'getStock']);
Route::get('getstock/{id}',[StockController::class,'getStock']);
Route::delete('deletestock/{id}',[StockController::class,'deleteStock']);

//Payment API's Routes
Route::get('paymentlist',[PaymentController::class,'paymentList']);
