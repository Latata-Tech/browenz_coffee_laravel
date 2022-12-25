<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:150',
            'email' => 'required|email:rfc',
            'phone_number' => 'required|string|min:11|max:13',
            'address' => 'required|string|max:255',
            'birth' => 'required|date_format:Y-m-d'
        ];
    }
}
