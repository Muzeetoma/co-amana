<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Jobs\ProcessOrder;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use Illuminate\Http\Response;


class OrderControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_create_order_with_valid_data()
    {
        Queue::fake();
        
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'price' => 21.30,
        ]);

        $response = $this->actingAs($user)->postJson('/api/order', [
            'product_id' => $product->id,
            'amount' => $product->price,
            'quantity' => 1,
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['success' => true]);

        Queue::assertPushed(ProcessOrder::class, function ($job) use ($user, $product) {
            return $job->orderDto->userId === $user->id &&
                   $job->orderDto->productId === $product->id &&
                   $job->orderDto->amount == 21.30 &&
                   $job->orderDto->quantity == 1;
        });
    }

    public function test_create_order_with_invalid_data()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/order', [
            'product_id' => 9999,
            'amount' => -5,
            'quantity' => -1,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['product_id', 'amount', 'quantity']);
    }

    public function test_create_order_requires_authentication()
    {
        $response = $this->postJson('/api/order', [
            'product_id' => 1,
            'amount' => 21.30,
            'quantity' => 1,
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_get_all_orders_with_search()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create();

        // Create some orders with related products and users
        Order::factory()->count(10)->create(['user_id' => $user->id,'product_id' => $product->id]);
        $product = Product::factory()->create(['name' => 'Special Product']);
        Order::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'order_number' => '1234-5678',
        ]);

        $response = $this->getJson('/api/order/12?searchParam=Special Product');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment(['name' => 'Special Product']);
    }

    public function test_get_all_orders_without_search()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $this->actingAs($user);

        Order::factory()->count(15)->create(['user_id' => $user->id,'product_id' => $product->id]);

        $response = $this->getJson('/api/order/' . 5);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(5, 'data');
    }
}