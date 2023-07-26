<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() {
        $order = Order::whereDate('created_at', Carbon::now()->format('Y-m-d'))->get();
        $totalMonth = Order::whereMonth('created_at', Carbon::now()->format('m'))->sum('total');
        return view('admin.index', [
            'totalDaily' => $order->sum('total'),
            'orders' => $order->count(),
            'totalMonthly' => $totalMonth,
            'bestSellers' => OrderDetail::with(['menuTrashed'])->select(DB::raw('sum(qty) as totalOrder, menu_id'))->groupBy('menu_id')->orderBy('totalorder', 'DESC')->get()
        ]);
    }
}
