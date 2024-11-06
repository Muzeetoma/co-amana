<?php 
namespace App\Repository;

use App\Models\Order;

class OrderRepository{

    public function findByOrderNumber($orderNumber){
        return Order::where('order_number',$orderNumber)->first();
    }

    public function findAll(int $limit, ?string $search)
    {
        return Order::with([
                'user:id,fullname',
                'product:id,name'
            ])
            ->when($search, function ($query, $search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('fullname', 'like', "%{$search}%");
                })->orWhereHas('product', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                })->orWhere('order_number', 'like', "%{$search}%");
            })
            ->paginate($limit);
    }
    
}