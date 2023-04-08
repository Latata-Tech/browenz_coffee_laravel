<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'discount' => 'required|integer|min:0',
            'menus' => 'required|array',
            'menus.*.id' => 'required|exists:menus,id',
            'menus.*.qty' => 'required|integer|min:1',
            'menus.*.variant' => 'required|string|in:hot,ice',
            'pay' => 'required|integer|min:1',
            'payment_type' => 'required|string'
        ];
    }
}
