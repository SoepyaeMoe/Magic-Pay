<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class transferConfirm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'to_phone' => 'required|min:9|starts_with:09,01',
            'amount' => 'required',
            'hash_value' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'to_phone.required' => 'Invalid number',
            'to_phone.min' => 'Invalid number',
            'to_phone.starts_with' => 'Invalid number, Please fill valid number.e.g 09.., 01.. etc...',
        ];
    }
}
