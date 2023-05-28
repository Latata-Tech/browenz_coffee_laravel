<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionStock extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, $filter) {
        if(isset($filter['type'])) {
            if($filter['type'] == 'monthly') {
                $query->when($filter['filter'] ?? false, function ($query, $filter) {
                    return $query->whereMonth('created_at', $filter);
                });
            } else {
                $query->when($filter['filter'] ?? false, function ($query, $filter) {
                    return $query->whereYear('created_at', $filter);
                });
            }
        }
        $query->when($filter['search'] ?? false, function ($query, $filter) {
           return $query->whereRaw('LOWER(code) LIKE ?', ['%' . $filter .'%'])
               ->orWhere('transaction_date', 'like', '%' . $filter . '%');
        });
        return $query;
    }

    public function detail() {
        return $this->hasMany(TransactionStockIngredient::class, 'transaction_stock_id', 'id');
    }
}
