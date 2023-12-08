<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionDetailResource extends JsonResource
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
        $type = '';
        if ($this->type == 1) {
            $source_type = 'From';
            $amount = '+' . number_format($this->amount, 2) . ' MMK';
            $type = 'Income';
            $color = 'green';
        }
        if ($this->type == 2) {
            $source_type = 'To';
            $amount = '-' . number_format($this->amount, 2) . ' MMK';
            $color = 'red';
            $type = 'Expense';
        }
        return [
            'amount' => $amount,
            'source_type' => $source_type,
            'source_name' => $this->sourceUser ? $this->sourceUser->name : '-',
            'source_phone' => $this->sourceUser ? $this->sourceUser->phone : '-',
            'trx_id' => $this->trx_id,
            'ref_no' => $this->ref_no,
            'type' => $type, //1 => income, 2 => expense
            'description' => $this->description,
            'data_time' => $this->created_at->format('d-M-Y H:i:s'),
        ];
    }
}
