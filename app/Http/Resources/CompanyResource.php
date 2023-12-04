<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'sync_id' => $this->sync_id,
            'code' => $this->code,
            'name' => $this->name,
            'is_active' => $this->is_active
        ];
    }
}
