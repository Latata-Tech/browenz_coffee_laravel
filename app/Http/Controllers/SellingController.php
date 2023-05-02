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
}
