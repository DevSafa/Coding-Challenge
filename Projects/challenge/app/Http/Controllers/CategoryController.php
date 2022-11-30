<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\GetDataServiceInterface;
use Illuminate\Http\Exceptions\HttpResponseException;
use Throwable;

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
     * @return array
     */
    public function index(): array
    {
        try {
            $categories =  $this->getDataService->getCategories();
        } catch(Throwable $e) {
            throw new HttpResponseException(
                response()->json([
                    'messages' => array(["Server Error"])
                ], 500)
            );
        }
        return $categories;
    }

    /**
     * get products of a specific category
     *
     * @param int $id
     *
     * @return array
     */
    public function filter(int $id): array
    {
        try {
            $products = $this->getDataService->getProductsByCategory($id);
        } catch(Throwable $e) {
            throw new HttpResponseException(
                response()->json([
                    'messages' => array(["Server Error"])
                ], 500)
            );
        }
        return $products;
    }
}
