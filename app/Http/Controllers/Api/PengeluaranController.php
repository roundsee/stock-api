<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengeluaran;
use App\Models\StockMutasi;
use App\Models\StockLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengeluaranController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'gudang_id'  => 'required|exists:gudang,id',
            'keterangan' => 'nullable|string',
            'items'      => 'required|array',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.qty'     => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($request) {
            // 1. Simpan Header Pengeluaran
            $pengeluaran = Pengeluaran::create([
                'tgl_keluar' => now(),
                'gudang_id'  => $request->gudang_id,
                'user_id'    => auth()->id(),
                'keterangan' => $request->keterangan,
            ]);

            foreach ($request->items as $item) {
                 $pengeluaran->PengeluaranDetail()->create([
                    'item_id' => $item['item_id'],
                    'qty' => $item['qty'],
                ]);
                // 2. Simpan Detail Mutasi
                StockMutasi::create([
                    'pengeluaran_id' => $pengeluaran->id,
                    'item_id'        => $item['item_id'],
                    'qty'            => $item['qty'],
                ]);

                // 3. Update Log Stok
                $lastLog = StockLog::where('item_id', $item['item_id'])
                    ->where('gudang_id', $request->gudang_id)
                    ->latest()
                    ->first();

                $stokAwal = $lastLog ? $lastLog->stok_akhir : 0;

                StockLog::create([
                    'item_id'      => $item['item_id'],
                    'gudang_id'    => $request->gudang_id,
                    'referensi_no' => $pengeluaran->no_keluar,
                    'jenis'        => 'keluar',
                    'qty'          => $item['qty'],
                    'stok_awal'    => $stokAwal,
                    'stok_akhir'   => $stokAwal - $item['qty'],
                ]);
            }

            return response()->json([
                'status'  => 'success',
                'message' => 'Pengeluaran barang berhasil dicatat',
                'data'    => $pengeluaran->load('PengeluaranDetail')
            ], 201);
        });
    }
}