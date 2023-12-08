<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->data['title'],
            'message' => $this->data['message'],
            'deep_link' => $this->data['deep_link'],
            'date_time' => $this->created_at->format('d-M-Y H:i:s'),
        ];
    }
}
