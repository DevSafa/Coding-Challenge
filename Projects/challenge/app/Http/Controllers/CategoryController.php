<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\GetDataServiceInterface;

class CategoryController extends Controller
{
    /**
     * @var App\Interfaces\Services\GetDataServiceInterface
     */
    protected $getDataService = null;

    /**
     * create a new Instance of CategoryController
     */
    public function __construct(GetDataServiceInterface $getDataService)
    {
        $this->getDataService = $getDataService;
    }
    /**
     * get all categories
     *
     * @return void
     */
    public function index()
    {
        $categories =  $this->getDataService->getCategories();
        return $categories;
    }

    /**
     * get products of a specific category
     *
     * @param int $id
     *
     * @return void
     */
    public function filter(int $id)
    {
        $products = $this->getDataService->getProductsByCategory($id);
        return $products;
    }
}
