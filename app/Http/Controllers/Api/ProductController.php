<?php

namespace App\Http\Controllers\Api;

use Log;
use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends ApiController
{
    private $responseData;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->responseData = [
            'code'    => 'custom error code for all validations',
            'message' => 'custom error message for all validations',
        ];
    }

    /**
     * get product list
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function getProducts(Request $request): JsonResponse
    {
        $products = Product::paginate(5);

        $responseData = [
            'code'       => 200,
            'message'    => 'Success',
            'pagination' => [
                'total'         => $products->total(),
                'per_page'      => $products->perPage(),
                'current_page'  => $products->currentPage(),
                'last_page'     => $products->lastPage(),
                'from'          => $products->firstItem(),
                'to'            => $products->lastItem()
            ],
            'data' => $products
        ];
        
        return response()->json($responseData, 200);
    }

}