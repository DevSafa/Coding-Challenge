<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/categories',[CategoryController::class,"index"]);
Route::post('/products',[ProductController::class,"store"]);
Route::get('/products',[ProductController::class,"index"]);
Route::get('/category/products/{id}',[CategoryController::class,"getProducts"])
    ->whereNumber('id');


