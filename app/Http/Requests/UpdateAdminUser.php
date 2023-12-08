<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminUser extends FormRequest
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
        $id = $this->route('admin_user');
        return [
            'name' => 'required|max:255',
            'phone' => 'required|unique:admin_users,id,' . $id,
            'email' => 'required|unique:admin_users,id,' . $id,
        ];
    }
}
