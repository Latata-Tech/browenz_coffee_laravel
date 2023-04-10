<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function findAll() {
        $data = Category::select(['id', 'name'])->orderBy('name')->get()->toArray();
        $data[] = ['id' => 0, 'name' => 'Semua'];
        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }
}
