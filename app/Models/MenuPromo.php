<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuPromo extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function menu() {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }

    public function scopeFilter($query, $filter) {
        return $query->when($filter['search'] ?? false, function($query, $filter) {
            return $query->whereRaw("LOWER(name) LIKE ?", ['%'.strtolower($filter).'%']);
        });
    }
}
