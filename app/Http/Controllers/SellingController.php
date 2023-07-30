<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SellingController extends Controller
{
    public function index(Request $request) {
        $request->validate([
            'search' => 'nullable|string',
            'date_filter' => 'nullable|date|date_format:Y-m-d'
        ]);
        return view('selling.index', [
            'orders' => Order::with('user')->whereDate('created_at', $request->date_filter ?? Carbon::now()->format('Y-m-d'))->filter(request(['search']))->paginate(10),
            'date_filter' => $request->date_filter ?? Carbon::now()->format('Y-m-d')
        ]);
    }

    public function detail($id) {
        $order = Order::with(['detail', 'user', 'detail.promo', 'detail.menu' => fn($q) => $q->withTrashed])->find($id);
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
