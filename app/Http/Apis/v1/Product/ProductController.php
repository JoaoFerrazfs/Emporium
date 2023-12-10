<?php

namespace App\Http\Apis\v1\Product;

use App\Http\Apis\v1\BaseApi;
use App\Http\Requests\Products\ProductsRequest;
use App\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;

class ProductController extends BaseApi
{
    public function __construct(
        private readonly ProductRepository $productRepository,
    ){
    }

    public function store(ProductsRequest $request): JsonResponse
    {
        $input = [
            'name' => $request->name,
            'description' => $request->description,
            'ingredients' => $request->ingredients,
            'stock' => $request->stock,
            'validate' => $request->validate,
            'price' => $request->price,
            'status' => $request->status ?? false ? 'disponivel' : 'indisponivel',
            'image' => saveImage($request) ?? "default.jpg",
        ];

        $product = $this->productRepository->saveProduct($input);

        return $product ?
           $this->response(compact('product')) :
           $this->errorResponse(['error' => 'Error when trying to register a new product']);
    }
}
