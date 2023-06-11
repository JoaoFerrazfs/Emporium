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

    public function findAllAvailableProducts(): Collection
    {
        return $this->product->where('status', 'disponivel')->get();

    }

    public function findAvailableProductByName(string $term): ?Collection
    {
        return $this->product->where('name', 'LIKE', '%' . $term . '%')->where('status', 'disponivel')->get();

    }
}
