<?php 
namespace App\Repository;

use App\Models\Product;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\InvalidArgumentException;

class ProductRepository{

    public function findAll(int $limit){
        try
        {
        return Product::paginate($limit);
        }catch(\Exception $ex){
            Log::error("Error while retrieving products: " . $ex->getMessage());
            return new InvalidArgumentException("Could not retrieve resoureces");
        }
    }

    public function getById($id){
        return Product::find($id);
    }
}