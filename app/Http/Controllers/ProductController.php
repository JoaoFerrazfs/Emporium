<?php

namespace App\Http\Controllers;

use App\Http\Requests\Products\ProductsRequest;
use App\Repositories\ProductRepository;
use App\Models\Product;
use Admin\contents\Image;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    private Image $image;
    private ProductRepository $productRepository;

    public function __construct(Image $image, ProductRepository $productRepository)
    {
        $this->image = $image;
        $this->productRepository = $productRepository;
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
            'image' => $this->image->saveLocalImage($request) ?? "default.jpg",
        ];

        return $this->productRepository->saveProduct($input) ?
            view('admin.products.productsList', ['products' => Product::all()]) :
            view('admin.products.productsList', ['products' => Product::all()])->with(['msg' => 'Erro ao cadastrar produto']);
    }

    public function myProducts(): View
    {
        return view('admin.products.productsList', ['products' => $this->productRepository->getAllProducts()]);
    }

    public function editProducts(int $productId): View
    {
        return view(
            'admin.products.productEdit',
            [
                'product' => $this->productRepository->first((int)$productId)
            ]
        );
    }

    public function deleteProducts(int $productId): View
    {
        $product = $this->productRepository->first($productId);

        return $product->delete() ?
            view('admin.products.productsList', ['products' => $this->productRepository->getAllProducts()]) :
            view('admin.products.productsList', ['products' => $this->productRepository->getAllProducts()])->with(['msg' => 'Erro ao cadastrar produto']);

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
            'image' => $this->image->saveLocalImage($request) ?? $product->image,
        ];

        return $product->update($input) ?
            view('admin.products.productsList', ['products' => $this->productRepository->getAllProducts()]) :
            view('admin.products.productsList', ['products' => $this->productRepository->getAllProducts()])->with(['msg' => 'Erro ao cadastrar produto']);
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
