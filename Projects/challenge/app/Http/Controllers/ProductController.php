<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\GetDataServiceInterface;
use App\Interfaces\Services\ProductCreationServiceInterface;
use App\Validators\ProductCreationValidator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Validation\ValidationException;
use PhpParser\ErrorHandler\Throwing;
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
     * @return void
     */
    public function index()
    {
        $products = $this->getDataService->getProducts();
        return $products;
    }

    /**
     * store a product
     *
     * @param Illuminate\Http\Request $request
     *
     * @return void
     */
    public function store(Request $request)
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
        return response($product, 201)
            ->header('Content-Type', 'application/json');
    }
}
