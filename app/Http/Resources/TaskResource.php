<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => (string)$this->id,
            'attributes' => [
                'name' => (string) $this->name,
                'description' => (string) $this->description,
                'priority' => (string) $this->priority,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ],
            'relationships' => [
                'id' => (string) $this->user->id,
                'user name' => $this->user->name,
                'user email' => $this->user->email
            ]
        ];
    }
}
