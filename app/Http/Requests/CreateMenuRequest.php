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
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
            'hot_price' => 'required_if:ice_price,null|string|min:0',
            'ice_price' => 'required_if:hot_price,null|string|min:0',
            'ingredient_id' => 'required|array',
            'ingredient_id.*' => 'exists:ingredients,id',
            'photo' => 'required|image',
            'status' => 'required|boolean'
        ];
    }
}
