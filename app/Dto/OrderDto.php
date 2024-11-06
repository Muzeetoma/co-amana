<?php
namespace App\Dto;

class OrderDto
{
    public string $orderNumber;
    public int $userId;
    public int $productId;
    public float $amount;
    public int $quantity;

    public function __construct(string $orderNumber,
                                int $userId, 
                                int $productId,
                                float $amount, 
                                int $quantity)
    {
        $this->orderNumber = $orderNumber;
        $this->userId = $userId;
        $this->productId = $productId;
        $this->amount = $amount;
        $this->quantity = $quantity;
    }
}