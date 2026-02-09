<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $items = Item::when($search, function($query) use ($search) {
            $query->where('item_name', 'LIKE', "%$search%")
                  ->orWhere('item_code', 'LIKE', "%$search%");
        })->get();

        return response()->json($items);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'item_code' => 'required|unique:items,item_code',
            'item_name' => 'required',
            'item_type' => 'required',
            'unit'      => 'required',
        ]);

        $item = Item::create($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Item berhasil ditambahkan',
            'data' => $item
        ], 201);
    }
public function stockReport()
{
    // Mengambil semua item beserta log stok terakhirnya
    $items = \App\Models\Item::with(['stockLogs' => function($query) {
        $query->latest();
    }])->get()->map(function($item) {
        $lastLog = $item->stockLogs->first();
        return [
            'id'            => $item->id,
            'item_code'     => $item->item_code,
            'item_name'     => $item->item_name,
            'item_type'     => $item->item_type,
            'unit'          => $item->unit,
            'current_stock' => $lastLog ? (int)$lastLog->stok_akhir : 0,
            'last_update'   => $lastLog ? $lastLog->created_at->format('Y-m-d H:i') : '-',
        ];
    });

    return response()->json($items);
}    
}