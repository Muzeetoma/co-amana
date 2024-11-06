<?php
namespace App\Dto;

class ProductResponseDto{
    public $userId;
    public $productId;
    public $amount;
    public $quantity;

    public function __construct(int $userId, int $productId, float $amount, int $quantity)
    {
        $this->userId = $userId;
        $this->productId = $productId;
        $this->amount = $amount;
        $this->quantity = $quantity;
    }

}