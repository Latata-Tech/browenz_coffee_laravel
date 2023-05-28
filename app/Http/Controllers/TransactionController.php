<?php

namespace App\Http\Controllers;

use App\Helpers\GenerateCodeHelper;
use App\Models\Ingredient;
use App\Models\IngredientStockHistory;
use App\Models\TransactionStock;
use App\Models\TransactionStockIngredient;
use App\Rules\CheckDuplicateIngredient;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class TransactionController extends Controller
{
    public function index(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $request->validate([
            'search' => 'nullable|string',
            'type' => 'nullable|string',
            'filter' => 'nullable|string'
        ]);
        return view('transactions.index', [
            'ingredient_transactions' => TransactionStock::with('detail')->filter(\request(['search', 'type', 'filter']))->orderBy('transaction_date')->paginate(10)
        ]);
    }

    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('transactions.create', [
            'ingredients' => Ingredient::with('type')->get(),
        ]);
    }

    public function detail(TransactionStock $transaction): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('transactions.detail', [
            'ingredients' => Ingredient::with('type')->get(),
            'ingredient_transactions' => $transaction,
        ]);
    }

    public function edit($id): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('transactions.edit', [
            'ingredients' => Ingredient::with('type')->get(),
            'ingredient_transactions' => TransactionStock::with('detail')->find($id),
        ]);
    }

    public function update(Request $request, TransactionStock $transaction): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
                'date' => 'required|date|date_format:Y-m-d',
                'ingredient_id' => 'required|array',
                'ingredient_id.*' => ['required', 'exists:ingredients,id'],
                'qties' => ['required', 'array'],
                'qties.*' => 'required|integer|min:0',
                'description' => 'required|string'
            ]
        );
        if(count($request->ingredient_id) != count(array_unique($request->ingredient_id))) {
            return redirect()->back()->with('failed', 'Terdapat bahan baku yang duplikat');
        }
        try {
            DB::beginTransaction();
            $transaction->update([
                'transaction_date' => $request->date,
                'description' => $request->description
            ]);
            for ($i = 0; $i < count($request->ingredient_id); $i++) {
                $transIngredient = TransactionStockIngredient::where('transaction_stock_id', $transaction->id)
                    ->where('ingredient_id', $request->ingredient_id[$i])->first();
                if (is_null($transIngredient)) {
                    $this->addTransactionIngredient([
                        'ingredient_id' => $request->ingredient_id[$i],
                        'qty' => $request->qties[$i],
                        'transaction_id' => $transaction->id,
                        'transaction_code' => $transaction->code
                    ], $request->type);
                } else {
                    $stock = $request->qties[$i] - $transIngredient->qty;
                    $transIngredient->update(['qty', $request->qties[$i]]);
                    $history = [
                        'ingredient_id' => $transIngredient->ingredient->id,
                        'prev_stock' => $transIngredient->ingredient->stock,
                        'stock_type_id' => $transIngredient->ingredient->type->id,
                        'transaction_stock_ingredient_id' => $transIngredient->id
                    ];
                    if ($request->type === 'in') {
                        $transIngredient->ingredient->increment('stock', $stock);
                        $history['description'] = 'Update masuk bahan baku';
                    } else {
                        if ($stock < 0) $transIngredient->ingredient->increment('stock', abs($stock));
                        else $transIngredient->ingredient->decrement('stock', $stock);
                        $history['description'] = 'Update keluar bahan baku';
                    }
                    $history['stock'] = $transIngredient->ingredient->stock;
                    IngredientStockHistory::create($history);
                }
            }
            DB::commit();
            return redirect()->route('transactions')->with('success', 'Berhasil update transaksi bahan baku ' . $transaction->code);
        } catch (Throwable $e) {
            Log::error($e);
            DB::rollBack();
            return redirect()->back()->with('failed', 'Terjadi kesalahan pada server');
        }
    }

    public function delete(TransactionStock $transaction): \Illuminate\Http\RedirectResponse
    {
        try {
            DB::beginTransaction();
            foreach ($transaction->detail as $ingredientTransaction) {
                $history = [
                    'ingredient_id' => $ingredientTransaction->ingredient_id,
                    'prev_stock' => $ingredientTransaction->ingredient->stock,
                    'stock_type_id' => $ingredientTransaction->ingredient->type->id,
                    'description' => 'Hapus transaksi bahan baku'
                ];
                if ($transaction->type === 'in') {
                    $ingredientTransaction->ingredient->decrement('stock', $ingredientTransaction->qty);
                } else {
                    $ingredientTransaction->ingredient->increment('stock', $ingredientTransaction->qty);
                }
                $history['stock'] = $ingredientTransaction->ingredient->stock;
                IngredientStockHistory::create($history);
                $ingredientTransaction->delete();
            }
            $transaction->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Berhasil hapus transaksi bahan baku dengan code transaksi : ' . $transaction->code);
        } catch (Throwable $e) {
            Log::error($e);
            DB::rollBack();
            return redirect()->back()->with('failed', 'Terjadi kesalahan pada server');
        }

    }

    public function addTransactionIngredient($data, $type): void
    {
        $ingredient = Ingredient::find($data['ingredient_id']);
        $transaction = TransactionStockIngredient::create([
            'ingredient_id' => $ingredient->id,
            'qty' => $data['qty'],
            'stock_type_id' => $ingredient->type->id,
            'transaction_stock_id' => $data['transaction_id']
        ]);
        $history = [
            'ingredient_id' => $ingredient->id,
            'prev_stock' => $transaction->ingredient->stock,
            'stock_type_id' => $transaction->ingredient->type->id,
            'transaction_stock_ingredient_id' => $transaction->id
        ];
        if ($type === 'in') $ingredient->increment('stock', $transaction->qty);
        else $ingredient->decrement('stock', $transaction->qty);
        $history['stock'] = $ingredient->stock;
        $history['description'] = 'Tambah keluar bahan baku ' . $data['transaction_code'];
        IngredientStockHistory::created($history);
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'date' => 'required|date|date_format:Y-m-d',
            'type' => 'required|in:in,out',
            'ingredient_id' => 'required|array',
            'ingredient_id.*' => ['required', 'exists:ingredients,id'],
            'qties' => ['required', 'array'],
            'qties.*' => 'required|integer|min:0',
            'description' => 'required|string'
        ]);
        if(count($request->ingredient_id) != count(array_unique($request->ingredient_id))) {
            return redirect()->back()->with('failed', 'Terdapat bahan baku yang duplikat');
        }
        try {
            DB::beginTransaction();
            $transaction = TransactionStock::create([
                'transaction_date' => $request->date,
                'type' => $request->type,
                'code' => GenerateCodeHelper::generateCode('TS', TransactionStock::class),
                'description' => $request->description
            ]);
            for ($i = 0; $i < count($request->ingredient_id); $i++) {
                $ingredient = Ingredient::find($request->ingredient_id[$i]);
                if ($request->type == 'out') {
                    if ($request->qties[$i] > $ingredient->stock) {
                        throw new Exception('Quantity ' . $ingredient->name . ' yang keluar melebih dari yang tersedia', 400);
                    }
                }
                $transactionIngredient = [
                    'ingredient_id' => $ingredient->id,
                    'qty' => $request->qties[$i],
                    'stock_type_id' => $ingredient->type->id,
                    'transaction_stock_id' => $transaction->id
                ];
                $detail = TransactionStockIngredient::create($transactionIngredient);
                $history = [
                    'ingredient_id' => $ingredient->id,
                    'prev_stock' => $ingredient->stock,
                    'stock_type_id' => $ingredient->type->id,
                    'transaction_stock_ingredient_id' => $detail->id
                ];
                if ($request->type == 'out') {
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
        } catch (Throwable $e) {
            Log::error($e);
            DB::rollBack();
            if ($e->getCode() == 400) {
                return redirect()->back()->with('failed', $e->getMessage());
            }
            return redirect()->back()->with('failed', 'Terjadi kesalahan pada server');
        }
    }
}
