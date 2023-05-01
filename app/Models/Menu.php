<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function ingredients(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MenuIngredients::class, 'menu_id', 'id');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function promo() {
        return $this->hasMany(MenuPromo::class, 'menu_id', 'id');
    }

    public function order() {
        return $this->hasMany(OrderDetail::class, 'menu_id', 'id');
    }

    public function scopeFilter($query, $filter) {
        $query->when($filter['search'] ?? false, function($query, $filter) {
           return $query->whereRaw("LOWER(name) LIKE ?", ['%'.$filter.'%'])
               ->orWhereRelation('category', 'name', 'like', '%'.$filter.'%');
        });

        $query->when($filter['category'] ?? false, function ($query, $filter) {
            return $query->where('category_id', $filter);
        });

        return $query;
    }

    public function delete()
    {
        $this->ingredients()->delete();
        return parent::delete();
    }
}
