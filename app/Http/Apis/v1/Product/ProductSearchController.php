<?php

namespace App\Http\Apis\v1\Product;

use App\Http\Apis\Requests\v1\Products\ProductRequest;
use App\Http\Apis\Transformers\v1\Product\ProductTransformer;
use App\Http\Apis\v1\BaseApi;
use App\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;

class ProductSearchController extends BaseApi
{
    public function __construct(
        private readonly ProductRepository  $productRepository,
        private readonly ProductTransformer $transformer
    ) {
    }

    public function search(ProductRequest $request): JsonResponse
    {

        $term = $request->get('term');

        if (!$data = $this->productRepository->findProductByName($term)) {
            return $this->responseNotFound();
        }

        $data = $this->transformer->transform($data);

        return $this->response($data);
    }
}
