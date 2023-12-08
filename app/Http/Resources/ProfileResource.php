<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'balance' => number_format($this->wallet->amount, 2) . ' MMK',
            'account_number' => $this->wallet->account_number,
            'qr_resource' => $this->phone,
            'unread_noti_count' => $this->unreadNotifications()->count(),
            'profile_pic' => "https: //ui-avatars.com/api/?name=" . $this->name . "&background=random",

        ];
    }
}
