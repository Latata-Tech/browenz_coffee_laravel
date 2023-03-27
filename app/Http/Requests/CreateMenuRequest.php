<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMenuRequest extends FormRequest
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
            'name' => 'required|string|size:255',
            'category_id' => 'required|integer|exists:category,id',
            'hot_price' => 'required|integer|min:0',
            'ice_price' => 'required|integer|min:0',
            'ingredients' => 'required|array',
            'photo' => 'required|image|size:1024',
            'status' => 'required|boolean'
        ];
    }
}
