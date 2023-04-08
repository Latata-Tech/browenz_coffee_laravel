<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    function getMenu(Request $request) {
        $request->validate([
            'search' => 'nullable|string',
            'category' => 'nullable|integer|exist:category,id'
        ]);
        $data = Menu::with('category')->filter(request(['search', 'category']))->orderBy('name')->paginate(15)->toArray();
        $menus = [];
        foreach ($data['data'] as $menu) {
            $menu['photo'] = Storage::disk('public')->url($menu['photo']);
            $menus[] = $menu;
        }
        $data['data'] = $menus;
        return response()->json($data);
    }
}
