<?php

namespace App\Http\Apis\v1\Product;

use Admin\reports\products\Job;
use App\Http\Apis\v1\BaseApi;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Storage;

class ProductReportsController extends BaseApi
{
    public function __construct(
        private readonly ProductRepository $productRepository,
    ){
    }

    public function exportProducts() {
        if(!$products = $this->productRepository->findAllAvailableProducts()) {
            return $this->responseNotFound();
        }

        $id = $this->createId();
        $job = new Job($products, $id);
        dispatch($job);

        return $this->response([
            'link' => Storage::url($job->fullPath)
        ]);

    }

    private function createId(): string
    {
       return uniqid('products_report_');
    }

}
