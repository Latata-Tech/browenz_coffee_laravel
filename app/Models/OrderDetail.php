<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function menu() {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }

    public function menuTrashed() {
        return $this->belongsTo(Menu::class, 'menu_id', 'id')->withTrashed();
    }

    public function promo() {
        return $this->belongsTo(MenuPromo::class, 'menu_promo_id', 'id');
    }
}
