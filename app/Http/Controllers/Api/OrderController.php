<?php

namespace App\Http\Controllers\Api;

use App\Helpers\GenerateCodeHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Menu;
use App\Models\MenuPromo;
use App\Models\Order;
use App\Models\OrderDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function getTotalOrder(Request $request) {
        $datas = Order::with(['detail', 'detail.menu' => fn($q) => $q->withTrashed(), 'user' => fn($q) => $q->withTrashed()]);
        if(!is_null($request->date)) {
            $datas = $datas->whereDate('created_at', $request->date == "" ? Carbon::now()->format('Y-m-d') : $request->date)->sum('total');
        } else {
            $datas = $datas->whereDate('created_at', Carbon::now()->format('Y-m-d'))->where('user_id', auth()->user()->id)->sum('total');
        }
        return response()->json([
            'status' => 'success',
            'data' => [
                'total' => $datas
            ]
        ]);
    }
    public function getOrders(Request $request) {
        $orders = [];
        $datas = Order::with(['detail', 'detail.menu' => fn($q) => $q->withTrashed(), 'user' => fn($q) => $q->withTrashed()]);
        if(!is_null($request->date)) {
            $datas = $datas->whereDate('created_at', $request->date == "" ? Carbon::now()->format('Y-m-d') : $request->date)->get()->toArray();
        } else {
            $datas = $datas->whereDate('created_at', Carbon::now()->format('Y-m-d'))->where('user_id', auth()->user()->id)->get()->toArray();
        }

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
                'total' => $data['total'],
                'cashier' => $data['user']['name'],
                'orderDate' => Carbon::createFromDate($data['created_at'])->format('d-m-Y H:i'),
                'discount' => $data['discount']
            ];
        }
        return response()->json([
            'status' => 'success',
            'data' => $orders
        ]);
    }
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
    public function getOrderNotProcess() {
        $orders = [];
        $datas = Order::with(['detail', 'detail.menu' => fn($q) => $q->withTrashed(), 'user' => fn($q) => $q->withTrashed()])->where('status', 'process')
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
                'total' => $data['total'],
                'cashier' => $data['user']['name'],
                'orderDate' => Carbon::createFromDate($data['created_at'])->format('d-m-Y H:i'),
                'discount' => $data['discount']
            ];
        }
        return response()->json([
            'status' => 'success',
            'data' => $orders
        ]);
    }

    public function updateOrder(Request $request, $code) {
        $request->validate([
            'order_detail' => 'required|array',
            'order_detail.*.id' => 'required|exists:order_details,id',
            'order_detail.*.qty' => 'required|integer|min:1',
            'pay' => 'required|integer|min:1',
        ]);
        try {
            DB::beginTransaction();
            $total = 0;
            $totalBeforeDiscount = 0;
            $discount = 0;
            $order = Order::where('code', $code)->first();
            if(is_null($order)) {
                throw new \Exception('Order tidak ditemukan', 404);
            }
            foreach ($request->order_detail as $orderMenu) {
                $detail = OrderDetail::where('id', $orderMenu['id'])->where('order_id', $order->id)->first();
                $detail->qty = $orderMenu['qty'];
                $menu = Menu::find($detail->menu_id);
                $price = $detail->variant === 'hot' ? $menu->hot_price : $menu->ice_price;
                $promo = MenuPromo::where('id', $detail->menu_promo_id)->orderBy('created_at', 'desc')->first();
                if(!is_null($promo)) {
                    $price = $detail->variant === 'hot' ? $promo->hot_price : $promo->ice_price;
                    $discount += $detail->variant === 'hot' ? ($menu->hot_price - $promo->hot_price) * $orderMenu['qty'] : ($menu->ice_price - $promo->ice_price) * $orderMenu['qty'];
                    $totalBeforeDiscount += $detail->variant === 'hot' ? $menu->hot_price * $orderMenu['qty'] : $menu->ice_price * $orderMenu['qty'];
                }
                $detail->total = $price * $orderMenu['qty'];
                $detail->price = $price;
                $detail->save();
                $total += $detail->total;
            }
            $order->update([
                'total' => $total,
                'total_pay' => $request->pay,
                'discount' => $discount,
                'total_before_discount' => $totalBeforeDiscount
            ]);
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil membuat order'
            ], 201);
        } catch (\Throwable $e) {
            Log::error($e);
            DB::rollBack();
            if($e->getCode() === 400) {
                return response()->json([
                    'status' => 'failed',
                    'message' => $e->getMessage()
                ], $e->getCode());
            }
            return response()->json([
                'status' => 'failed',
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        }
    }
    public function createOrder(OrderRequest $request) {
        try {
            DB::beginTransaction();
            $total = 0;
            $orderDetails = [];
            $totalBeforeDiscount = 0;
            $discount = 0;
            foreach ($request->menus as $orderMenu) {
                $promo = MenuPromo::where('menu_id', $orderMenu['id'])->orderBy('created_at', 'desc')->first();


                $menu = Menu::with(['ingredients'])->find($orderMenu['id']);
                foreach ($menu->ingredients as $ingredient) {
                    if($ingredient->ingredient->stock <= 0) {
                        throw new \Exception('Stock bahan baku '.$ingredient->name.' habis', 400);
                    }
                }
                $detail = [
                    'order_id' => null,
                    'menu_promo_id' => null,
                    'menu_id' => $orderMenu['id'],
                    'variant' => $orderMenu['variant'],
                    'qty' => $orderMenu['qty'],
                    'created_at' => null,
                    'updated_at' => null,
                ];
                $price = $orderMenu['variant'] === 'hot' ? $menu->hot_price : $menu->ice_price;
                if (!is_null($promo) && Carbon::createFromDate(Carbon::now()->format('Y-m-d'))->getTimestamp() >= Carbon::createFromDate($promo->start_date)->getTimestamp() && Carbon::createFromDate(Carbon::now()->format('Y-m-d'))->getTimestamp() <= Carbon::createFromDate($promo->end_date)->getTimestamp()) {
                    $detail['menu_promo_id'] = $promo->id;
                    $price = $orderMenu['variant'] === 'hot' ? $promo->hot_price : $promo->ice_price;
                    $discount += $orderMenu['variant'] === 'hot' ? ($menu->hot_price - $promo->hot_price) * $orderMenu['qty'] : ($menu->ice_price - $promo->ice_price) * $orderMenu['qty'];
                    $totalBeforeDiscount += $orderMenu['variant'] === 'hot' ? $menu->hot_price * $orderMenu['qty'] : $menu->ice_price * $orderMenu['qty'];
                }
                $detail['price'] = $price;
                $detail['total'] = $price * $orderMenu['qty'];
                $orderDetails[] = $detail;
                $total += $detail['total'];
            }
            $order = Order::create([
                'code' => GenerateCodeHelper::generateCode('PS', Order::class),
                'discount' => $discount,
                'total_before_discount' => $totalBeforeDiscount,
                'total' => $total,
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
            if($e->getCode() === 400) {
                return response()->json([
                    'status' => 'failed',
                    'message' => $e->getMessage()
                ], $e->getCode());
            }
            return response()->json([
                'status' => 'failed',
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        }
    }

    public function detailOrderData(string $code) {
        $orderItems = [];
        $datas = Order::with(['detail', 'detail.menu' => fn($q) => $q->withTrashed(), 'user' => fn($q) => $q->withTrashed()])->where('code', $code)->first()->toArray();
        foreach ($datas['detail'] as $detail) {
            $item = [
                'id' => $detail['id'],
                'total' => $detail['total'],
                'qty' => $detail['qty'],
                'name' => $detail['menu']['name'],
                'variant' => $detail['variant'],
                'price' => $detail['price'],
            ];
            $orderItems[] = $item;
        }
        return response()->json([
            'status' => 'success',
            'data' => [
                'code' => $datas['code'],
                'payment_type' => $datas['payment_type'],
                'detail' => $orderItems,
                'total' => $datas['total'],
                'cashier' => $datas['user']['name'],
                'orderDate' => Carbon::createFromDate($datas['created_at'])->format('d-m-Y'),
                'orderHour' => Carbon::createFromDate($datas['created_at'])->format('H:i'),
                'discount' => $datas['discount']
            ]
        ]);
    }

    public function detailOrder(string $code) {
        $orderItems = [];
        $datas = Order::with(['detail', 'detail.menu' => fn($q) => $q->withTrashed(), 'user' => fn($q) => $q->withTrashed()])->where('code', $code)->first()->toArray();
        foreach ($datas['detail'] as $detail) {
            $item = [
                'total' => $detail['total'],
                'qty' => $detail['qty'],
                'name' => $detail['menu']['name'],
                'variant' => $detail['variant'],
            ];
            $orderItems[] = $item;
        }
        $pdf = Pdf::loadView('pdf.invoice', [
            'code' => $datas['code'],
            'payment_type' => $datas['payment_type'],
            'detail' => $orderItems,
            'total' => $datas['total'],
            'cashier' => $datas['user']['name'],
            'orderDate' => Carbon::createFromDate($datas['created_at'])->format('d-m-Y'),
            'orderHour' => Carbon::createFromDate($datas['created_at'])->format('H:i'),
            'discount' => $datas['discount']
        ])->setPaper([0,0,360,460], 'potrait');
        return $pdf->download('invoice-'.$datas['code'].'.pdf');
    }
}
