<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ingredient\CreateRequest;
use App\Http\Requests\Ingredient\UpdateRequest;
use App\Models\Ingredient;
use App\Models\StockType;

class IngredientController extends Controller
{
    public function index()
    {
        $ingredients = Ingredient::with('type')->filter(request(['search']))->orderBy('name', 'asc')->paginate(10);
        return view('ingredients.index', [
            'ingredients' => $ingredients,
        ]);
    }

    public function create()
    {
        return view('ingredients.create', [
            'stock_types' => StockType::select(['id', 'name'])->get(),
        ]);
    }

    public function store(CreateRequest $request)
    {
        Ingredient::create($request->validated());
        return redirect()->back()->with('success', 'Berhasil tambah data bahan baku baru');
    }

    public function detail(Ingredient $ingredient) {
        $data = [
            'name' => $ingredient->name,
            'stock' => $ingredient->stock,
            'min_stock' => $ingredient->min_stock,
            'stock_type' => $ingredient->type->name,
            'description' => $ingredient->description,
        ];
        return view('ingredients.detail', [
            'ingredient' => $data
        ]);
    }

    public function edit(Ingredient $ingredient)
    {
        return view('ingredients.edit', [
            'ingredient' => $ingredient,
            'stock_types' => StockType::select(['id', 'name'])->get(),
        ]);
    }

    public function update(UpdateRequest $request, Ingredient $ingredient)
    {
        $isNameExist = Ingredient::where('name', $request->name)->first();
        if(!is_null($isNameExist) && $ingredient->id !== $isNameExist->id) {
            return redirect()->back()->with('errorUnique', 'Nama sudah ada');
        }
        $ingredient->update($request->validated());
        return redirect()->back()->with('success', 'Berhasil update data bahan baku ' . $ingredient->name);
    }

    public function delete(Ingredient $ingredient)
    {
        $data = $ingredient;
        $ingredient->delete();
        return redirect()->back()->with('success', 'Berhasil hapus data bahan baku ' . $data->name);
    }
}
