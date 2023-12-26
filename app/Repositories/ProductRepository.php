<?php

namespace App\Repositories;

use App\Models\Product;
use http\Exception\UnexpectedValueException;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository
{
    public function __construct(
        private readonly Product $product
    ) {
    }

    public function findProductByName(string $term): ?Collection
    {
        $data = $this->product->where('name', 'LIKE', '%' . $term . '%')->get();

        return $data->count() ? $data : null ;
    }

    public function findAllAvailableProducts(): ?Collection
    {
        $result = $this->product->where('status', 'disponivel')->get();
        return $result->count() ? $result : null  ;
    }

    public function findAvailableProductByName(string $term): ?Collection
    {
        return $this->product->where('name', 'LIKE', '%' . $term . '%')->where('status', 'disponivel')->get();
    }

    public function saveProduct(array $input)
    {
        return $this->product->create($input);
    }

    public function first(int $productId): ?Product
    {
        return $this->product->find($productId);
    }

    public function getAllProducts(): Collection
    {
        return  $this->product->all();
    }
}
