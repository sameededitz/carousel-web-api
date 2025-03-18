<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'avatar' => $this->avatar,
            'role' => $this->role,
            'registration_date' => $this->created_at->format('Y-m-d H:i:s'), // Using created_at
            'last_login' => $this->last_login ? $this->last_login->format('Y-m-d H:i:s') : null,
            'ai_creations' => $this->ai_creations,
            'active_plan' => $this->whenLoaded('activePlan'),
            'referral_code' => $this->referral_code,
        ];        
    }
}
