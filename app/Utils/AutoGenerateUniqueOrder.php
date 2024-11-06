<?php
namespace App\Utils;

use App\Repository\OrderRepository;

class AutoGenerateUniqueOrder{

    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository) {
        $this->orderRepository = $orderRepository;
    }
    
    public function autoGenerateUniqueOrderNumber()
    {
        $orderNumber = null;
        
        do {
            $orderNumber = random_int(1000, 9999) . '-' . random_int(1000, 9999);
        } while (!empty($this->orderRepository->findByOrderNumber($orderNumber)));
    
        return $orderNumber;
    }
    
}