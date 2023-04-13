<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function dashboard() {
        $orders = Order::whereDate('created_at', Carbon::now()->format('Y-m-d'))->get();
        $orderStatus = $orders->countBy(function($value) {
            return $value->status;
        })->toArray();
        return response()->json([
            'status' => 'success',
            'data' => [
                'total_earning' => $orders->sum((function($value) {
                    return $value->total;
                })),
                'total_order' => $orders->count(),
                'order_done' => $orderStatus['done'],
                'order_process' => $orderStatus['process']
            ]
        ]);
    }
}
