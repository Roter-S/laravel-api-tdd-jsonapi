<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
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
            'type' => 'users',
            'id' => (string)$this->resource->getRouteKey(),
            'attributes' => [
                'id' => $this->resource->id,
                'slug' => $this->resource->slug,
                'name' => $this->resource->name,
                'last_name' => $this->resource->last_name,
                'email' => $this->resource->email,
                'email_verified_at' => $this->resource->email_verified_at,
                'date_of_birth' => $this->resource->date_of_birth,
                'phone_number' => $this->resource->phone_number,
                'status' => $this->resource->status,
                'roles' => $this->resource->roles,
                'instrument_id' => $this->resource->instrument_id,
                'voice_id' => $this->resource->voice_id,
                'entity_id' => $this->resource->entity_id,
                'created_at' => $this->resource->created_at,
                'updated_at' => $this->resource->updated_at,
            ],
            'links' => [
                'self' => route('api.v1.users.show', $this->resource),
            ],
        ];
    }

    public function toResponse($request): JsonResponse
    {
        return parent::toResponse($request)
            ->withHeaders([
                'Location' => route('api.v1.users.show', $this->resource)
            ]);
    }
}
