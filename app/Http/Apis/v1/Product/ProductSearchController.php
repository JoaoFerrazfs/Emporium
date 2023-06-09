<?php

namespace App\Http\Apis\v1\Product;

use App\Http\Apis\Requests\v1\Products\ProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductSearchController
{
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function search(ProductRequest $request):JsonResponse
    {
        $term = $request->get('term');
        $result = $this->product->where('name', 'LIKE', '%' . $term . '%')->get();


        return response()->json(['data' => $result->toArray()]);
    }
}
