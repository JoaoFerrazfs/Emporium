<?php

namespace App\Http\Controllers;

use App\Http\Requests\Products\ProductsRequest;
use App\Repositories\ProductRepository;
use App\Http\Transformers\Product as ProductTransformer;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly ProductTransformer $productTransformer,
    ) {
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
            'image' => saveImage($request) ?? "default.jpg",
        ];

        return $this->productRepository->saveProduct($input) ?
            view('admin.products.productsList', ['products' => $this->productRepository->getAllProducts()]) :
            view('admin.products.productsList', ['products' => $this->productRepository->getAllProducts()])
                ->with(['msg' => 'Erro ao cadastrar produto']);
    }

    public function myProducts(): View
    {
        return view('admin.products.productsList', ['products' => $this->productRepository->getAllProducts()]);
    }

    public function editProducts(int $productId): View
    {
        if (!$product = $this->productRepository->first($productId)) {
            return $this->myProducts();
        }

        return view(
            'admin.products.productEdit',
            [
                'product' => $this->productTransformer->transformProduct($product)
            ]
        );
    }

    public function deleteProducts(int $productId): View
    {
        $product = $this->productRepository->first($productId);

        return $product->delete() ?
            view('admin.products.productsList', ['products' => $this->productRepository->getAllProducts()]) :
            view('admin.products.productsList', ['products' => $this->productRepository->getAllProducts()])
                ->with(['msg' => 'Erro ao cadastrar produto']);
    }

    public function update(ProductsRequest $request): View
    {
        $product = $this->productRepository->first($request['id']);
        $formData = $request->all();
        $input = [
            'name' => $formData['name'],
            'description' => $formData['description'],
            'ingredients' => $formData['ingredients'],
            'stock' => $formData['stock'],
            'validate' => $formData['validate'],
            'price' => $formData['price'],
            'status' => $formData['status'] ?? false ? 'disponivel' : 'indisponivel',
            'image' => saveImage($request) ?? $product->image,
        ];

        return $product->update($input) ?
            view('admin.products.productsList', ['products' => $this->productRepository->getAllProducts()]) :
            view('admin.products.productsList', ['products' => $this->productRepository->getAllProducts()])
                ->with(['msg' => 'Erro ao cadastrar produto']);
    }

    public function index(): View
    {
        $products = $this->productRepository->findAllAvailableProducts();
        return view('ecommerce.products.productsList', ['products' => $products]);
    }

    public function viewProduct(int $productId): View
    {
        $product = $this->productRepository->first($productId);

        return view('ecommerce.products.productPage', ['product' => $product]);
    }
}
