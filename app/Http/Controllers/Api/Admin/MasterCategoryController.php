<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterCategory;
use Illuminate\Http\Request;

class MasterCategoryController extends Controller
{
    public function index()
    {
        $categories = MasterCategory::withCount('masterItems as items_count')
            ->orderBy('name')
            ->get();

        return response()->json(['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:master_category,name',
            'description' => 'nullable|string',
        ]);

        $category = MasterCategory::create([
            'name'        => $request->name,
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'Kategori berhasil ditambahkan.', 'category' => $category], 201);
    }

    public function update(Request $request, $id)
    {
        $category = MasterCategory::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255|unique:master_category,name,' . $id . ',id_master_category',
            'description' => 'nullable|string',
        ]);

        $category->update([
            'name'        => $request->name,
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'Kategori berhasil diperbarui.', 'category' => $category]);
    }

    public function destroy($id)
    {
        $category = MasterCategory::findOrFail($id);
        $category->delete();

        return response()->json(['message' => 'Kategori berhasil dihapus.']);
    }
}