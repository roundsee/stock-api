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
        // Ambil stok terbaru per item di setiap gudang
        $report = Item::with(['stockLogs' => function($query) {
            $query->latest();
        }])->get()->map(function($item) {
            $lastLog = $item->stockLogs->first();
            return [
                'id' => $item->id,
                'item_code' => $item->item_code,
                'item_name' => $item->item_name,
                'item_type' => $item->item_type,
                'unit' => $item->unit,
                'current_stock' => $lastLog ? $lastLog->stok_akhir : 0,
                'last_update' => $lastLog ? $lastLog->created_at->format('Y-m-d H:i') : '-'
            ];
        });

        return response()->json($report);
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