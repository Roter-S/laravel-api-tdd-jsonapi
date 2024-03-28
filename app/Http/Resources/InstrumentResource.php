<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstrumentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'instruments',
            'id' => (string)$this->resource->getRouteKey(),
            'attributes' => [
                'slug' => $this->resource->slug,
                'name' => $this->resource->name,
                'type' => $this->resource->type,
            ],
            'links' => [
                'self' => route('api.v1.instruments.show', $this->resource),
            ],
        ];
    }

    public function toResponse($request): JsonResponse
    {
        return parent::toResponse($request)
            ->withHeaders([
                'Location' => route('api.v1.instruments.show', $this->resource)
            ]);
    }
}
