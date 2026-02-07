<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class Generator
{
    public static function trxNo($modelClass, $prefix, $column = 'no_transaksi')
    {
        $date = now()->format('Ymd'); // Format: 20260203
        
        // Cari nomor terakhir yang punya prefix dan tanggal yang sama
        $lastRecord = $modelClass::where($column, 'LIKE', "$prefix-$date-%")
            ->orderBy($column, 'desc')
            ->first();

        if (!$lastRecord) {
            $number = 1;
        } else {
            // Ambil 4 digit terakhir, lalu tambah 1
            $lastNumber = explode('-', $lastRecord->$column);
            $number = (int) end($lastNumber) + 1;
        }

        // Hasil: PREFIX-YYYYMMDD-0001
        return $prefix . '-' . $date . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}