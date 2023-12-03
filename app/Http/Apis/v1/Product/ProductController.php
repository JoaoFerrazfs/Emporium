<?php

namespace App\Http\Apis\v1\Product;

use App\Http\Requests\Products\ProductsRequest;
use App\Http\Transformers\Product as ProductTransformer;
use App\Repositories\ProductRepository;
use Illuminate\Contracts\View\View;

class ProductController
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly DateTime $dateTime,
        private readonly ProductTransformer $productTransformer,

    ){

    }

    public function store(ProductsRequest $request): View
    {
        $formData = $request->all();
        $input = [
            'name' => $formData['name'],
            'description' => $formData['description'],
            'ingredients' => $formData['ingredients'],
            'stock' => $formData['stock'],
            'validate' => $formData['validate'],
            'price' => $formData['price'],
            'status' => $formData['status'] ?? false ? 'disponivel' : 'indisponivel',
            'image' => $this->saveImage($request) ?? "default.jpg",
        ];

        return $this->productRepository->saveProduct($input) ?
            view('admin.products.productsList', ['products' => $this->productRepository->getAllProducts()]) :
            view('admin.products.productsList', ['products' => $this->productRepository->getAllProducts()])->with(['msg' => 'Erro ao cadastrar produto']);
    }
}
