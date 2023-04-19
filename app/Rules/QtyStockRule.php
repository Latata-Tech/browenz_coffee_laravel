<?php

namespace App\Rules;

use App\Models\Ingredient;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\Rule;

class QtyStockRule implements Rule, DataAwareRule
{
    protected $data;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $key = explode('.', $attribute);
        $ingredientId = $this->data['ingredients'][(int)$key[1]]['id'];
        $ingredient = Ingredient::find($ingredientId);
        if($value > $ingredient->stock && $this->data['type'] == 'out') {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Stok keluar melebihi dari stock yang tersedia';
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
}
