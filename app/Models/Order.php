<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function detail() {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeFilter($query, $filter) {
        return $query->when($filter['search'] ?? false, function ($query, $filter) {
            return $query->whereRaw('LOWER(code) LIKE ?', ['%' . $filter .'%'])
                ->orWhereHas('user', function ($query) use ($filter) {
                   return $query->whereRaw('LOWER(name) LIKE ?', ['%' . $filter . '%']);
                });
        });
    }
}
