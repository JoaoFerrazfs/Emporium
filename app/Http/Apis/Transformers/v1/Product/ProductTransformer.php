<?php

namespace App\Http\Apis\Transformers\v1\Product;

use Illuminate\Database\Eloquent\Collection;

class ProductTransformer
{
    public function transform(Collection $products): array
    {
        foreach ($products as $product) {
            $transformedProducts[] = [
                'name' => $product->name ,
                'description' => $product->description,
                'price' => $product->price,
                'image' => $product->image,
                'status' => $product->status,
                'stock' => $product->stock ,
                'validate' => $product-> validate,
                'ingredients' => $product->ingredients,
            ];
        }

        return $transformedProducts ?? [];
    }

}
