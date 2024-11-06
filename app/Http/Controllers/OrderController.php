<?php
namespace App\Http\Controllers;

use App\Dto\ApiResponseDto;
use App\Dto\OrderDto;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Resources\PaginatedResource;
use App\Jobs\ProcessOrder;
use App\Service\OrderService;
use App\Utils\AutoGenerateUniqueOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class OrderController{
    protected $orderService;
    protected $autogenerateUniqueOrderNumber;

    public function __construct(OrderService $orderService,
                                AutoGenerateUniqueOrder $autogenerateUniqueOrderNumber) {
        $this->autogenerateUniqueOrderNumber = $autogenerateUniqueOrderNumber;
        $this->orderService = $orderService;
    }
    public function create(CreateOrderRequest $createOrderRequest){
        try{
            $validatedData = $createOrderRequest->validated();

            $orderNumber = $this->autogenerateUniqueOrderNumber->autoGenerateUniqueOrderNumber();

            $orderDTO = new OrderDto(
                $orderNumber,
                Auth::id(),
                $validatedData['product_id'],
                $validatedData['amount'],
                $validatedData['quantity']
            );

            $validatedOrderResponse = $this->orderService->validateOrder($orderDTO);

            if($validatedOrderResponse->success){
                ProcessOrder::dispatch($orderDTO);
            }

            return response()->json($validatedOrderResponse);

        }catch(\Exception $ex){
            return new ApiResponseDto(false, $ex->getMessage(),null);   
        }
    }

    public function getAll(Request $request,int $limit = 5){
        $searchParam = $request->input("searchParam");
        $orders = $this->orderService->getAll($limit,$searchParam);
        return new PaginatedResource($orders);
    }
}