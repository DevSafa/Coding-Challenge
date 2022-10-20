<?php

namespace App\Http\Controllers;


use App\Models\Product;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct(ProductRepositoryInterface $productRepositoryInterface)
    {
        $this->productRepository = $productRepositoryInterface;
    }

    public function products()
    {        
        return $this->productRepository->products();
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'name' => 'required|string|unique:products',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric',
            'category' => 'required|exists:categories,id',
            //image :The file under validation must be an image (jpeg, png, bmp, or gif)
            'image' => 'required|image|unique:products'
        ]);
       
        if ($validator->fails())
            return false;
        else
            return $this->productRepository->store($request);
    }



}
