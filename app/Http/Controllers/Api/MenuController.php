<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuPromo;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    function getMenu(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string',
            'category' => 'nullable|integer|exists:categories,id'
        ]);
        $data = Menu::with('category')->filter(request(['search', 'category']))->orderBy('name')->toArray();
        $menus = [];
        foreach ($data['data'] as $menu) {
            $promo = MenuPromo::where('menu_id', $menu['id'])->orderBy('created_at', 'desc')->first();
            if (!is_null($promo) && Carbon::createFromDate(Carbon::now()->format('Y-m-d'))->getTimestamp() >= Carbon::createFromDate($promo->start_date)->getTimestamp() && Carbon::createFromDate(Carbon::now()->format('Y-m-d'))->getTimestamp() <= Carbon::createFromDate($promo->end_date)->getTimestamp()) {
                $menu['promo_hot_price'] = $promo->hot_price;
                $menu['promo_ice_price'] = $promo->ice_price;
            } else {
                $menu['promo_hot_price'] = 0;
                $menu['promo_ice_price'] = 0;
            }
            $menu['photo'] = Storage::disk('public')->url($menu['photo']);
            $menus[] = $menu;
        }
        $data['data'] = $menus;
        return response()->json($data);
    }
}
