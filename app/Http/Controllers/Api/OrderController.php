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
    public function setStatusDone(string $code) {
        $order = Order::where('code', $code)->first();
        if(is_null($order)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Order tidak ditemukan'
            ], 404);
        }

        if($order->status === 'done') {
            return response()->json([
                'status' => 'failed',
                'message' => 'Order sudah selesai'
            ], 400);
        }

        $order->update(['status' => 'done']);
        return response()->json(['status' => 'success', 'message' => 'Order berhasil diselesaikan']);
    }
    public function getOrder() {
        $orders = [];
        $datas = Order::with('detail', 'detail.menu')->where('status', 'process')
            ->get()
            ->toArray();
        foreach ($datas as $data) {
            $orderItems = [];
            foreach ($data['detail'] as $detail) {
                $item = [
                    'total' => $detail['total'],
                    'qty' => $detail['qty'],
                    'name' => $detail['menu']['name'],
                    'variant' => $detail['variant'],
                ];
                $orderItems[] = $item;
            }
            $orders[] = [
                'code' => $data['code'],
                'payment_type' => $data['payment_type'],
                'detail' => $orderItems,
                'total' => $data['total']
            ];
        }
        return response()->json([
            'status' => 'success',
            'data' => $orders
        ]);
    }
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
                    'created_at' => null,
                    'updated_at' => null,
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
                'code' => GenerateCodeHelper::generateCode('PS', Order::class),
                'discount' => $request->discount,
                'total_before_discount' => $total,
                'total' => $total - $request->discount,
                'total_pay' => $request->pay,
                'user_id' => auth()->user()->id,
                'payment_type' => $request->payment_type,
                'status' => 'process'
            ]);
            for($i = 0; $i < count($orderDetails); $i++) {
                $orderDetails[$i]['order_id'] = $order->id;
                $orderDetails[$i]['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
                $orderDetails[$i]['updated_at'] = $orderDetails[$i]['created_at'];
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
