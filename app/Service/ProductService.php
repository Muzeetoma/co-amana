<?php
namespace App\Service;

use App\Dto\ApiResponseDto;
use App\Repository\ProductRepository;

class ProductService{

    protected $productRepository;

    public function __construct(ProductRepository $productRepository) {
        $this->productRepository = $productRepository;
    }
    public function getAll($limit){
        try{
            return $this->productRepository->findAll($limit); 
        }catch(\Exception $ex){ 
            return new ApiResponseDto(false, $ex->getMessage(),null);   
        }
    }
}