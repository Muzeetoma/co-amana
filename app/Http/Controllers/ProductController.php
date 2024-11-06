<?php
namespace App\Http\Controllers;

use App\Http\Resources\PaginatedResource;
use App\Service\ProductService;

class ProductController{

    protected $productService;
    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }

    public function getAll(int $limit = 5){
        $products = $this->productService->getAll($limit);
        return new PaginatedResource($products);
    }
}