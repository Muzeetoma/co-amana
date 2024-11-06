<?php
namespace App\Service;

use App\Dto\ApiResponseDto;
use App\Dto\OrderDto;
use App\Models\Order;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use GuzzleHttp\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\Log;

class OrderService{

    protected $orderRepository;
    protected $productRepository;

    public function __construct(OrderRepository $orderRepository,
                                ProductRepository $productRepository) {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
    }

    public function validateOrder(OrderDto $orderDto){
        try{
            $product = $this->productRepository->getById($orderDto->productId);

            $priceExpected = $product->price * $orderDto->quantity;
    
            if($orderDto->amount < $priceExpected ){
                throw new InvalidArgumentException("The amount paid is not up to the worth of the item");
            }
    
            $data = [
                'user_id'=> $orderDto->userId,
                'product_id'=> $orderDto->productId,
                'amount'=>  $orderDto->amount ,
                'quantity'=> $orderDto->quantity,
            ];

            return new ApiResponseDto(true, "Product has been added to queue",$data);
        }catch(\Exception $ex){
            return new ApiResponseDto(false, $ex->getMessage(),null);   
        }
    }

    public function create(OrderDto $orderDto){
        try{
            
            $order = new Order();
            $order->amount = $orderDto->amount;
            $order->user_id = $orderDto->userId;
            $order->product_id = $orderDto->productId;
            $order->order_number = $orderDto->orderNumber;
            $order->quantity = $orderDto->quantity;

            $order->save();
            Log::info("Order saved");
                
        }catch(\Exception $ex){
            Log::error("Order could not be saved : " . $ex->getMessage());
        }        
    }

    public function getAll($limit, ?string $search){
        try{
            return $this->orderRepository->findAll($limit, $search); 
        }catch(\Exception $ex){ 
            return new ApiResponseDto(false, $ex->getMessage(),null);   
        }
    }
}