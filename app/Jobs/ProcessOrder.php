<?php

namespace App\Jobs;

use App\Dto\OrderDto;
use App\Service\OrderService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;

class ProcessOrder implements ShouldQueue
{
    use Dispatchable, Queueable;

    /**
     * Create a new job instance.
     */
    public $orderDto;

    public function __construct(OrderDto $orderDto)
    {
        $this->orderDto = $orderDto;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $orderService = app(OrderService::class);

        $orderService->create($this->orderDto);
    }
}
