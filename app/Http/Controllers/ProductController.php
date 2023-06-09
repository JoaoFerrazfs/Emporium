<?php

namespace App\Http\Controllers;

use App\Http\Requests\Products\ProductsRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use Admin\contents\Image;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    private Image $image;

    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    public function store(ProductsRequest $request): RedirectResponse
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
            'image' => $this->image->saveLocalImage($request) ?? "default.jpg" ,
        ];

        Product::create($input);

        return redirect('/admin');
    }

    public function myProducts(): View
    {
        return view('admin.products.productsList', ['products' =>  Product::all()]);
    }

    public function editProducts(string $productId): View
    {
        return view('admin.products.productEdit',
            [
                'product' => Product::find((int)$productId)
            ]
        );
    }

    public function deleteProducts(string $productId): RedirectResponse
    {
        Product::find((int)$productId)->delete();
        return redirect()->back();
    }

    public function update(ProductsRequest $request): RedirectResponse
    {
        $product = Product::find($request['id']);

        $formData = $request->all();


        $input = [
            'name' => $formData['name'],
            'description' => $formData['description'],
            'ingredients' => $formData['ingredients'],
            'stock' => $formData['stock'],
            'validate' => $formData['validate'],
            'price' => $formData['price'],
            'status' => $formData['status'] ?? false ? 'disponivel' : 'indisponivel',
            'image' => $this->image->saveLocalImage($request) ?? $product->image ,
        ];

        $product->update($input);

        return redirect(route('admin.products.list'));
    }

    public function destroy($id): RedirectResponse
    {
        Product::where('id', $id)->delete();
        $user = auth()->user()->_id;
        return redirect('/meusProdutos/' . $user);
    }

    public function index(): View
    {
        $products = Product::where('status', 'disponivel')->get();
        return view('ecommerce.products.productsList', ['products' => $products]);
    }

    public function viewProduct($id): View
    {
        $product = Product::find($id);

        return view('ecommerce.products.productPage', ['product' => $product]);
    }

}
