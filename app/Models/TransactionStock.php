<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionStock extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, $filter) {
        return $query->when($filter['search'] ?? false, function ($query, $filter) {
           return $query->where('code', 'like', '%' . $filter .'%')
               ->orWhere('transaction_date', 'like', '%' . $filter . '%');
        });
    }

    public function ingredients() {
        return $this->hasMany(TransactionStockIngredient::class, 'transaction_stock_id', 'id');
    }
}
