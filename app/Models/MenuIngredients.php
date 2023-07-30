<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuIngredients extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_id',
        'ingredient_id'
    ];

    public function menu() {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }

    public function ingredient() {
        return $this->belongsTo(Ingredient::class, 'ingredient_id', 'id');
    }
}
