<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class SellingController extends Controller
{
    public function index(Request $request) {
        $request->validate([
            'search' => 'nullable|string'
        ]);
        return view('selling.index', [
            'orders' => Order::with('user')->filter(request(['search']))->paginate(10)
        ]);
    }

    public function detail($id) {
        $order = Order::with('detail', 'user', 'detail.promo', 'detail.menu')->find($id);
        $codePromo = '';
        foreach ($order->detail as $detail) {
            if(!is_null($detail->menu_promo_id)) $codePromo .= $detail->promo->name . ',';
        }
        $codePromo = rtrim($codePromo, ',');
        return view('selling.detail', [
            'order' => $order,
            'details' => $order->detail,
            'codePromo' => $codePromo
        ]);
    }
}
