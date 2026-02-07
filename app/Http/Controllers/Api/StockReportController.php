<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\StockLog;
use Illuminate\Http\Request;

class StockReportController extends Controller
{
    public function index(Request $request)
    {
$query = Item::query();

    // Filter berdasarkan Nama atau Kode (jika ada request dari Flutter)
    if ($request->has('search')) {
        $query->where('item_name', 'like', '%' . $request->search . '%')
              ->orWhere('item_code', 'like', '%' . $request->search . '%');
    }

    // Filter berdasarkan Tipe (Produk/Bahan)
    if ($request->has('item_type')) {
        $query->where('item_type', $request->item_type);
    }

    $report = $query->with(['stockLogs' => function($q) {
        $q->latest();
    }, 'stockLogs.gudang'])->get()->map(function($item) {
        $lastLog = $item->stockLogs->first();
        
        return [
            'id' => $item->id,
            'item_code' => $item->item_code,
            'item_name' => $item->item_name,
            'item_type' => $item->item_type, // "Produk" atau "Bahan"
            'unit' => $item->unit,
            'current_stock' => $lastLog ? (int)$lastLog->stok_akhir : 0,
            'gudang_id' => $lastLog ? $lastLog->gudang_id : null,
            'gudang_name' => $lastLog && $lastLog->gudang ? $lastLog->gudang->nama_gudang : 'Belum ada mutasi',
            'last_update' => $lastLog ? $lastLog->created_at->format('Y-m-d H:i') : '-'
        ];
    });

    return response()->json($report);
    }
public function StockLog(){
    
    return response()->json([
        'status' => 'success',
        'data' => StockLog::with('item')->latest()->get()
    ]);

}
    public function history($itemId)
    {
        // Detail riwayat (Buku Stok) untuk satu item spesifik
        $history = StockLog::where('item_id', $itemId)
            ->with('gudang')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($history);
    }
}