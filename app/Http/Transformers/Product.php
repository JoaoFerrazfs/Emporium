<?php

namespace App\Http\Transformers;

use Illuminate\Support\Facades\Storage;
use App\Models\Product as ProductModel;

class Product
{
    public function transformProduct(ProductModel $product): array
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'ingredients' =>  $product->ingredients,
            'stock' =>  $product->stock,
            'validate' =>  $product->validate,
            'price' =>  $product->price,
            'status' => $product->status ,
            'image' => Storage::disk('s3')->url($product->image),
        ];
    }
}
