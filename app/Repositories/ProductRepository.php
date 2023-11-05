<?php

namespace App\Repositories;

use App\Models\Product;
use http\Exception\UnexpectedValueException;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository
{
    public function __construct(
        private readonly Product $product
    ){
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

    public function saveProduct(array $input):bool
    {
        return (bool) $this->product->create($input);
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
