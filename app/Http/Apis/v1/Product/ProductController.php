<?php

namespace App\Http\Apis\v1\Product;

use App\Http\Apis\Transformers\v1\Product\ProductTransformer;
use App\Http\Apis\v1\BaseApi;
use App\Http\Requests\Products\ProductsRequest;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class ProductController extends BaseApi
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly ProductTransformer $transformer
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

    public function listAvailableProducts():JsonResponse
    {
        if(!$data = $this->productRepository->findAllAvailableProducts()) {
            return $this->responseNotFound();
        }

        $data = $this->transformer->transform($data);

        return  $this->response($data);
    }

    public function getProductById(string $id):JsonResponse
    {
        if(!$product = $this->productRepository->first($id)) {
            return $this->responseNotFound();
        }

        $productCollection = New Collection([$product]);

        $data = $this->transformer->transform($productCollection);

        return  $this->response($data);
    }

}
