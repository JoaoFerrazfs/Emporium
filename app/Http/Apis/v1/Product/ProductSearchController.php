<?php

namespace App\Http\Apis\v1\Product;

use App\Http\Apis\Requests\v1\Products\ProductRequest;
use App\Http\Apis\Transformers\v1\Product\ProductTransformer;
use App\Http\Apis\v1\BaseApi;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductSearchController extends BaseApi
{
    public function __construct(Product $product, ProductTransformer $transformer)
    {
        $this->product = $product;
        $this->transformer = $transformer;
    }

    public function search(ProductRequest $request):JsonResponse
    {
        $term = $request->get('term');

        $data = $this->product->where('name', 'LIKE', '%' . $term . '%')->get();

        $data = $this->transformer->transform($data);

        return $this->response($data);
    }
}

