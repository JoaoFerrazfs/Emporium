<?php

namespace Admin\reports\products;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class Processor
{
    public function process(Collection $products): array
    {
        $data = [];

        /**
         * @var Collection|Product[] $products
         */
        foreach ($products as $product) {
            $productAttributes = $product->getAttributes();
             unset($productAttributes['image']);
            $data[] = array_values($productAttributes);
        }


       return $this->addHeaders($data);
    }

    private function addHeaders(array $data): array
    {
        return array_merge([Product::REPORTS_FIELDS], $data);
    }
}
