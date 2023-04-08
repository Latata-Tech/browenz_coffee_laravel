<?php

namespace App\Http\Controllers\Api;

use App\Helpers\GenerateCodeHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Menu;
use App\Models\MenuPromo;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function createOrder(OrderRequest $request) {
        try {
            DB::beginTransaction();
            $total = 0;
            $orderDetails = [];
            foreach ($request->menus as $orderMenu) {
                $promo = MenuPromo::where('menu_id', $orderMenu['id'])
                    ->where('start_date', '>=', Carbon::now()->format('Y-m-d'))
                    ->where('end_date', '<=', Carbon::now()->format('Y-m-d'))->first();

                $menu = Menu::find($orderMenu['id']);
                $detail = [
                    'order_id' => null,
                    'menu_id' => $orderMenu['id'],
                    'variant' => $orderMenu['variant'],
                    'qty' => $orderMenu['qty'],
                ];
                if($orderMenu['variant'] === 'hot') {
                    $price = is_null($promo) ? $menu->hot_price : $promo->hot_price;
                } else {
                    $price = is_null($promo) ? $menu->ice_price : $promo->ice_price;
                }
                $detail['price'] = $price;
                $detail['total'] = $price * $orderMenu['qty'];
                $detail['menu_promo_id'] = is_null($promo) ? null : $promo->id;
                $orderDetails[] = $detail;
                $total += $detail['total'];
            }
            $order = Order::create([
                'code' => GenerateCodeHelper::generateCode('ps', Order::class),
                'discount' => $request->discount,
                'total_before_discount' => $total,
                'total' => $total - $request->discount,
                'total_pay' => $request->pay,
                'user_id' => auth()->user()->id,
                'payment_type' => $request->payment_type
            ]);
            for($i = 0; $i < count($orderDetails); $i++) {
                $orderDetails[$i]['order_id'] = $order->id;
            }
            OrderDetail::insert($orderDetails);
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil membuat order'
            ], 201);
        } catch (\Throwable $e) {
            Log::error($e);
            DB::rollBack();
            return response()->json([
                'status' => 'failed',
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        }
    }
}
