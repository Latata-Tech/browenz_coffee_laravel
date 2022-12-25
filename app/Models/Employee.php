<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeFilter($query, $filter)
    {
        $query->when($filter['search'] ?? false, function ($query, $search) {
            return $query->whereHas('user', function ($query) use ($search) {
                    $query->whereRaw('lower(email) like ?', ['%' . trim(strtolower( $search)). '%'])
                        ->orWhereRaw('lower(name) like ?', ['%' . trim(strtolower( $search)). '%']);
                });
        });
    }

    public function delete()
    {
        $this->user()->delete();
        return parent::delete();
    }
}
