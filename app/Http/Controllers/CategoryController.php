<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function findAll() {
        return view('category.index',[
            'categories' => Category::filter(request(['name']))->select(['id', 'name'])->paginate(15)
        ]);
    }

    public function findById($id) {
        return view('category.detail', [
            'category' => Category::find($id, ['id', 'name', 'description'])
        ]);
    }

    public function create() {
        return view('category.create');
    }

    public function save(Request $request) {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string'
        ]);
        $count = Category::where('name', $request->name)->where('deleted_at', null)->first();
        if(!is_null($count)) {
            return redirect()->back()->with('failed', 'Nama kategori sudah adan');
        }
        Category::create([
            'name' => $request->name,
            'description' => $request->description
        ]);
        return redirect()->route('categories')->with('success', 'Berhasil tambah kategori');
    }

    public function edit(Category $category) {
        return view('category.edit', [
            'category' => $category
        ]);
    }

    public function update(Request $request, Category $category) {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string'
        ]);
        $findName = Category::where('name', $request->name)->first();
        if(!is_null($findName) && $category->id !== $findName->id) {
            return redirect()->back()->with('failed', 'Nama kategori sudah ada');
        }
        $category->update([
            'name' => $request->name,
            'description' => $request->description
        ]);
        return redirect()->route('categories')->with('success', 'Berhasil update kategori');
    }

    public function delete(Category $category) {
        $category->delete();
        return redirect()->route('categories')->with('success', 'Berhasil hapus kategori ' . $category->name);
    }
}
