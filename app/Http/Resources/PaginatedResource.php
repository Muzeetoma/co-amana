<?php 
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaginatedResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'current_page' => $this->currentPage(),
            'data' => $this->items(),
            'from' => $this->firstItem(),
            'last_page' => $this->lastPage(),
            'per_page' => $this->perPage(),
            'next_page_url' => $this->nextPageUrl(),
            'to' => $this->lastItem(),
            'total' => $this->total(),
        ];
    }
}
