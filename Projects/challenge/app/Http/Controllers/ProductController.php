<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\GetDataServiceInterface;
use App\Interfaces\Services\ProductCreationServiceInterface;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

class ProductController extends Controller
{
    /**
     * @var App\Interfaces\Services\GetDataServiceInterface
     */
    protected $getDataService = null;

    /**
     * @var App\Interfaces\Services\GetDataServiceInterface
     */
    protected $productCreationService = null;

    /**
     * create a new Instance of ProductController
     */
    public function __construct(
        GetDataServiceInterface $getDataService,
        ProductCreationServiceInterface $productCreationService
    ) {
        $this->getDataService = $getDataService;
        $this->productCreationService = $productCreationService;
    }

    /**
     * get all products
     *
     * @return array
     */
    public function index(): array
    {
        try {
            $products = $this->getDataService->getProducts();
        } catch(Throwable $e) {
            throw new HttpResponseException(
                response()->json([
                    'messages' => array(["Server Error"])
                ], 500)
            );
        }
        return $products;
    }

    /**
     * store a product
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function store(Request $request): HttpResponse
    {
        $values = $request->all();
        try {
            $this->productCreationService->validateData($values, false);
            $product = $this->productCreationService->storeProduct($values);
        } catch(Throwable $e) {
            if ($e instanceof ValidationException) {
                throw new HttpResponseException(
                    response()->json([
                        'messages' => $e->errors()
                    ], 400)
                );
            } else {
                throw new HttpResponseException(
                    response()->json([
                        'messages' => array(["Server Error"])
                    ], 500)
                );
            }
        }
        return response("product created", 201)
            ->header('Content-Type', 'application/json');
    }
}
