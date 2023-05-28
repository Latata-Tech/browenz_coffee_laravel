<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ingredient extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function type() {
        return $this->belongsTo(StockType::class, 'stock_type_id', 'id');
    }

    public function scopeFilter($query,  $fitler) {
        $query->when($fitler['search'] ?? false, fn($query, $search) => $query->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%']));
    }
}
