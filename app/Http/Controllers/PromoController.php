<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuPromo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index() {
        return view('promo.index', [
            'promos' => MenuPromo::filter(\request(['search']))->paginate(10)
        ]);
    }

    public function create() {
        return view('promo.create', [
            'menus' => Menu::select(['id', 'name'])->orderBy('name')->get(),
        ]);
    }

    public function edit(MenuPromo $promo) {
        return view('promo.edit', [
            'promo' => $promo
        ]);
    }

    public function detail(MenuPromo $promo) {
        return view('promo.detail', [
            'promo' => $promo
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'menu_id' => 'required|integer|exists:menus,id',
            'hot_price' => 'nullable|string',
            'ice_price' => 'nullable|string',
            'start_date' => 'required|date|date_format:Y-m-d',
            'end_date' => 'required|date|date_format:Y-m-d'
        ]);
        if(strtotime($request->end_date) < strtotime($request->start_date)) {
            return redirect()->back()->with('failed', 'Tanggal berakhir tidak boleh lebih kecil dari mulai');
        }

        MenuPromo::create([
            'menu_id' => $request->menu_id,
            'name' => $request->name,
            'hot_price' => join("",explode(".",$request->hot_price ?? "0")),
            'ice_price' => join("",explode(".",$request->ice_price ?? "0")),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);
        return redirect()->route('promos')->with('success', 'Berhasil membuat promo');
    }

    public function update(Request $request, MenuPromo $promo) {
        $request->validate([
            'name' => 'required|string',
            'hot_price' => 'nullable|string',
            'ice_price' => 'nullable|string',
            'start_date' => 'required|date|date_format:Y-m-d',
            'end_date' => 'required|date|date_format:Y-m-d'
        ]);
        if(strtotime($request->end_date) < strtotime($request->start_date)) {
            return redirect()->back()->with('failed', 'Tanggal berakhir tidak boleh lebih kecil dari mulai');
        }
        $promo->update([
            'name' => $request->name,
            'name' => $request->name,
            'hot_price' => join("",explode(".",$request->hot_price ?? "0")),
            'ice_price' => join("",explode(".",$request->ice_price ?? "0")),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);
        return redirect()->route('promos')->with('success', 'Berhasil update promo');
    }

    public function delete(MenuPromo $promo) {
        $promo->delete();
        return redirect()->route('promos')->with('success', 'Berhasil delete promo ' . $promo->name);
    }
}
