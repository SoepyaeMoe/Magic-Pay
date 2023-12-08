<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $source_type = '';
        $amount = '';
        $color = '';
        if ($this->type == 1) { //type = 1 => income
            $source_type = 'From';
            $amount = '+' . number_format($this->amount) . " MMK";
            $color = "green";
        }
        if ($this->type == 2) { //type = 2 => expense

            $source_type = 'To';
            $amount = '-' . number_format($this->amount) . " MMK";
            $color = "red";
        }

        return [
            'trx_id' => $this->trx_id,
            'amount' => $amount,
            'source_type' => $source_type,
            'source_name' => $this->sourceUser ? $this->sourceUser->name : '-',
            'source_phone' => $this->sourceUser ? $this->sourceUser->phone : '-',
            'type' => $this->type,
            'date_time' => $this->created_at->format('d-M-Y H:i:s'),
            'color' => $color,
        ];
    }
}
