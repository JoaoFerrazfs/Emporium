<?php

namespace App\Http\Apis\v1\Product;

use App\Http\Apis\Requests\v1\Products\ProductRequest;
use App\Models\Product;

class ProductSearchController
{
    public function search(ProductRequest $request)
    {
        $term = $request->get('term');

        $result = Product::where('name', 'LIKE', '%' . $term . '%')->get();

        return response()->json(['data' => $result->toArray()]);
    }
}
