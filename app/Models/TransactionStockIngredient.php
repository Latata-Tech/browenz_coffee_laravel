<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionStockIngredient extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function ingredient() {
        return $this->belongsTo(Ingredient::class, 'ingredient_id', 'id');
    }

    public function histories() {
        return $this->hasMany(IngredientStockHistory::class, 'transaction_stock_ingredient_id', 'id');
    }
}
