<?php
namespace App\Http\Controllers;

use App\Service\OrderService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AppController{
    protected $orderService;

    const DEFAULT_PAGINATED_NUMBER = 10;

    public function __construct(OrderService $orderService) {
        $this->orderService = $orderService;
    }

    public function index(Request $request){
        $searchParam = $request->input("searchParam");
        $orders = $this->orderService->getAll(self::DEFAULT_PAGINATED_NUMBER, $searchParam);
        return Inertia::render('Index',[
            'orders' => $orders
        ]);
    }
}