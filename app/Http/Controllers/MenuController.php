<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMenuRequest;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Menu;
use App\Models\MenuIngredients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index() {
        return view('menu.index', [
            'menus' => Menu::with('ingredients')->filter(request(['search']))->orderBy('name')->paginate(10),
        ]);
    }

    public function create() {
        return view('menu.create', [
            'categories' => Category::all(['id','name']),
            'ingredients' => Ingredient::all(['id', 'name'])
        ]);
    }

    public function store(CreateMenuRequest $request) {
        try {
            DB::beginTransaction();
            Storage::disk('local')->put('menu/'.$request->file()->getClientOriginalName(), $request->file('photo')->getContent());
            $menu = Menu::create([
                'name' => $request->name,
                'photo' => 'menu/'.$request->file()->getClientOriginalName(),
                'category_id' => $request->category_id,
                'hot_price' => $request->hot_price,
                'ice_price' => $request->ice_price,
                'status' => $request->status,
            ]);
            $values = [];
            foreach ($request->ingredients as $key => $val) {
                $values[] = ['menu_id' => $menu->id, 'ingredient_id' => $val];
            }
            MenuIngredients::insert($values);
            DB::commit();
            return redirect()->route('menus')->with('success', 'Berhasil tambah data menu');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('menus')->with('errors', 'Gagal tambah data menu');
        }
    }

    public function edit() {

    }

    public function update() {

    }

    public function delete() {

    }

    public function detail() {

    }
}
