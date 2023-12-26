<?php

namespace App\Http\Apis\v1\Product;

use Admin\reports\products\Job;
use App\Http\Apis\v1\BaseApi;
use App\Repositories\ProductRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class ProductReportsController extends BaseApi
{
    public function __construct(
        private readonly ProductRepository $productRepository,
    ) {
    }

    public function exportProducts(): JsonResponse
    {
        if (!$products = $this->productRepository->findAllAvailableProducts()) {
            return $this->responseNotFound();
        }

        try {
            $job = new Job($products, uniqid('products_report_'));
            dispatch($job);

            $link = Storage::url($job->fullPath);

            return $this->response(compact('link'));
        } catch (Exception $exception) {
            return $this->errorResponse([$exception->getMessage()]);
        }
    }
}
