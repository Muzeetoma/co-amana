<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class OrderFactory extends Factory
{

    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'order_number' => random_int(1000, 9999) . '-' . random_int(1000, 9999),
            'amount' => random_int(1000,9999),
            'quantity' => 1,
        ];
    }
}
