<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Penerimaan;
use App\Models\StockMutasi;
use App\Models\StockLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenerimaanController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input dari Flutter
        $request->validate([
            'gudang_id' => 'required|exists:gudang,id',
            'items' => 'required|array', // Array berisi item_id dan qty
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($request) {
            // 1. Simpan Header (Auto-number dipicu oleh Booted di Model)
            $penerimaan = Penerimaan::create([
                'tgl_terima' => now(),
                'gudang_id' => $request->gudang_id,
                'user_id' => auth()->id(), // Sementara hardcode, nanti pakai auth()->id()
                'supplier' => $request->supplier,
            ]);

            foreach ($request->items as $item) {
                $penerimaan->PenerimaanDetail()->create([
                    'item_id' => $item['item_id'],
                    'qty' => $item['qty'],
                ]);
                // 2. Simpan ke Stock Mutasi (Detail)
                StockMutasi::create([
                    'penerimaan_id' => $penerimaan->id,
                    'item_id' => $item['item_id'],
                    'qty' => $item['qty'],
                ]);

                // 3. Update Stock Log (Untuk Tampilan Buku Stok)
                // Ambil stok terakhir untuk hitung saldo
                $lastLog = StockLog::where('item_id', $item['item_id'])
                    ->where('gudang_id', $request->gudang_id)
                    ->latest()
                    ->first();

                $stokAwal = $lastLog ? $lastLog->stok_akhir : 0;

                StockLog::create([
                    'item_id' => $item['item_id'],
                    'gudang_id' => $request->gudang_id,
                    'referensi_no' => $penerimaan->no_terima,
                    'jenis' => 'masuk',
                    'qty' => $item['qty'],
                    'stok_awal' => $stokAwal,
                    'stok_akhir' => $stokAwal + $item['qty'],
                ]);
            }

            return response()->json([
                'message' => 'Penerimaan berhasil disimpan',
                'data' => $penerimaan->load('PenerimaanDetail') // Jika ada relasi
            ], 201);
        });
    }
}