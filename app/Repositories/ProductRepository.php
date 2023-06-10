<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository
{
    public function __construct(Product $product)
    {
        $this->product = $product ;
    }

    public function findProductByName(string $term): ?Collection
    {
        $data = $this->product->where('name', 'LIKE', '%' . $term . '%')->get();

        return !$data->first() ? null: $data ;

    }
}
