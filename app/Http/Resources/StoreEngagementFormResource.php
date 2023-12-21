<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreEngagementFormResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'contact' => $this->contact,
            'store_name' => $this->store_name,
            'leader' => $this->leader,
            'date' => $this->created_at,
            
            'objectives' => explode(',', $this->objectives),
            'strategies' => explode(',', $this->strategies),
            'activities' => explode(',', $this->activities),
            'findings' => explode(',', $this->findings),
            'notes' => explode(',', $this->notes),

            'e_signature' => $this->e_signature,
            'is_update' => $this->is_update,
            'is_active' => $this->is_active
        ];
    }
}
