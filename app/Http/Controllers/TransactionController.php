<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\TransactionStock;
use App\Rules\QtyStockRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request) {
        $request->validate([
            'search' => 'nullable|string'
        ]);
        return  view('transactions.index', [
            'ingredient_transactions' => TransactionStock::with('ingredients')->filter(\request(['search']))->orderBy('date')->paginate(10)
        ]);
    }

    public function create() {
        return view('transactions.create', [
            'ingredients' => Ingredient::with('type')->get(),
        ]);
    }

    public function edit($id) {
        return view('transactions.edit', [
            'ingredients' => Ingredient::select(['name', 'id', 'type.name as type'])->with('type')->get(),
            'ingredient_transactions' => TransactionStock::with('ingredients')->find($id),
        ]);
    }

    public function store(Request $request) {
        try {
            DB::beginTransaction();
            $request->validate([
                'date' => 'required|date|date_format:Y-m-d',
                'type' => 'required|in:in,out',
                'ingredients' => 'required|array',
                'ingredients.*.id' => 'required|exists:ingredients,id',
                'ingredients.*.qty' => ['required', 'integer', 'min:1', new QtyStockRule],
                'description' => 'required|string'
            ]);
            DB::commit();
            return redirect()->route('transactions')->with('success', 'Berhasil tambah transaksi stok');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('failed', 'Terjadi kesalahan pada server');
        }
    }
}
