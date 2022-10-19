<?php

use App\Http\Controllers\Category;
use App\Http\Controllers\Product;
use Illuminate\Support\Facades\Route;

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

Route::get('/categories',[Category::class , 'categories']);
Route::get('/main_categories',[Category::class , 'parents']);
Route::get('/sub_categories/{id}',[Category::class , 'children']);
Route::get('/category/parent/{id}',[Category::class , 'parent']);
Route::get('/category/products/{id}',[Category::class , 'products']);

Route::get('/products',[Product::class , 'products']);
Route::post('/create',[Product::class , 'create']);