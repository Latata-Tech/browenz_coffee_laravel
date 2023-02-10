<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function scopeFilter($query, $filter) {
        $query->when($filter['name'] ?? false, fn($query, $filter) =>
            $query->where('name', 'like', '%'.$filter.'%')
        );
    }
}
