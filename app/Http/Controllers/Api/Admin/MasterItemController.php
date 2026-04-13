<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterItem;
use Illuminate\Http\Request;

class MasterItemController extends Controller
{
    public function index()
    {
        $items = MasterItem::with('category')
            ->orderBy('item_name')
            ->get();

        return response()->json(['items' => $items]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_code'   => 'required|string|max:50|unique:master_items,item_code',
            'item_name'   => 'required|string|max:255',
            'id_category' => 'required|exists:master_category,id_master_category',
            'unit'        => 'required|string|max:50',
            'description' => 'nullable|string',
        ]);

        $item = MasterItem::create([
            'item_code'   => $request->item_code,
            'item_name'   => $request->item_name,
            'id_category' => $request->id_category,
            'unit'        => $request->unit,
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'Item berhasil ditambahkan.', 'item' => $item->load('category')], 201);
    }

    public function update(Request $request, $id)
    {
        $item = MasterItem::findOrFail($id);

        $request->validate([
            'item_code'   => 'required|string|max:50|unique:master_items,item_code,' . $id . ',id_item',
            'item_name'   => 'required|string|max:255',
            'id_category' => 'required|exists:master_category,id_master_category',
            'unit'        => 'required|string|max:50',
            'description' => 'nullable|string',
        ]);

        $item->update([
            'item_code'   => $request->item_code,
            'item_name'   => $request->item_name,
            'id_category' => $request->id_category,
            'unit'        => $request->unit,
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'Item berhasil diperbarui.', 'item' => $item->load('category')]);
    }

    public function destroy($id)
    {
        $item = MasterItem::findOrFail($id);
        $item->delete();

        return response()->json(['message' => 'Item berhasil dihapus.']);
    }
}