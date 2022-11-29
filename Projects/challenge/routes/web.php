<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/categories', [CategoryController::class,"index"]);
Route::get('/filter/{id}', [CategoryController::class,"filter"])
    ->whereNumber('id');
// ->where([
    //     'id' => implode('|', config('categories'))
// ]);

Route::get('/products', [ProductController::class,"index"]);
Route::post('/create', [ProductController::class,"store"]);
