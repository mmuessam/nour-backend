<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(Category::orderBy('name')->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'slug'   => 'required|string|unique:categories',
            'name'   => 'required|string',
            'icon'   => 'nullable|string',
            'color'  => 'nullable|string',
            'bg'     => 'nullable|string',
            'target' => 'nullable|integer|min:0',
        ]);

        $category = Category::create($data);
        return response()->json($category, 201);
    }

    public function show(string $id)
    {
        $category = Category::with('cases')->findOrFail($id);
        return response()->json($category);
    }

    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);
        $data = $request->validate([
            'name'   => 'sometimes|string',
            'icon'   => 'nullable|string',
            'color'  => 'nullable|string',
            'bg'     => 'nullable|string',
            'target' => 'nullable|integer|min:0',
        ]);
        $category->update($data);
        return response()->json($category);
    }

    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(['message' => 'تم الحذف']);
    }
}
