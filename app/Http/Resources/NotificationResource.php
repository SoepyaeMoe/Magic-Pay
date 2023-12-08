<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class NotificationResource extends JsonResource
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
            'title' => Str::limit($this->data['title'], 20, '...'),
            'message' => Str::limit($this->data['message'], 100, '...'),
            'read' => $this->read_at == null ? 'unread' : 'read',
            'data_time' => $this->created_at->format('d-M-Y H:i:s'),
        ];
    }
}
