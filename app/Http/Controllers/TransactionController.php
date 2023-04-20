<?php

namespace App\Http\Controllers;

use App\Helpers\GenerateCodeHelper;
use App\Models\Ingredient;
use App\Models\IngredientStockHistory;
use App\Models\TransactionStock;
use App\Models\TransactionStockIngredient;
use App\Rules\QtyStockRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    public function index(Request $request) {
        $request->validate([
            'search' => 'nullable|string'
        ]);
        return  view('transactions.index', [
            'ingredient_transactions' => TransactionStock::with('ingredients')->filter(\request(['search']))->orderBy('transaction_date')->paginate(10)
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
        $request->validate([
            'date' => 'required|date|date_format:Y-m-d',
            'type' => 'required|in:in,out',
            'ingredient_id' => 'required|array',
            'ingredient_id.*' => 'required|exists:ingredients,id',
            'qties' => ['required', 'array'],
            'qties.*' => 'required|integer|min:0',
            'description' => 'required|string'
        ]);
        try {
            DB::beginTransaction();
            $transaction = TransactionStock::create([
                'transaction_date' => $request->date,
                'type' => $request->type,
                'code' => GenerateCodeHelper::generateCode('TS', TransactionStock::class),
                'description' => $request->description
            ]);
            for($i = 0; $i < count($request->ingredient_id); $i++) {
                $ingredient = Ingredient::find($request->ingredient_id[$i]);
                if($request->type == 'out') {
                    if($request->qties[$i] > $ingredient->stock) {
                        throw new \Exception('Quantity ' . $ingredient->name . ' yang keluar melebih dari yang tersedia', 400);
                    }
                }
                $transactionIngredient = [
                    'ingredient_id' => $ingredient->id,
                    'qty' => $request->qties[$i],
                    'stock_type_id' => $ingredient->type->id,
                    'transaction_stock_id' => $transaction->id
                ];
                TransactionStockIngredient::create($transactionIngredient);
                $history = [
                    'ingredient_id' => $ingredient->id,
                    'prev_stock' => $ingredient->stock,
                    'stock_type_id' => $ingredient->type->id,
                ];
                if($request->type == 'out') {
                    $ingredient->decrement('stock', $request->qties[$i]);
                    $history['description'] = 'Keluar';
                } else {
                    $ingredient->increment('stock', $request->qties[$i]);
                    $history['description'] = 'Masuk';
                }
                $history['stock'] = $ingredient->stock;
                IngredientStockHistory::create($history);
            }
            DB::commit();
            return redirect()->route('transactions')->with('success', 'Berhasil tambah transaksi stok');
        } catch (\Throwable $e) {
            Log::error($e);
            DB::rollBack();
            if($e->getCode() == 400) {
                return redirect()->back()->with('failed', $e->getMessage());
            }
            return redirect()->back()->with('failed', 'Terjadi kesalahan pada server');
        }
    }
}
