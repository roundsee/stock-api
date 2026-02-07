<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMutasi extends Model
{
    // Nama tabel jika tidak pakai 's' (sesuaikan dengan migration kamu)
    protected $table = 'stock_mutasi'; 

    // Daftar kolom yang boleh diisi lewat Controller
    protected $fillable = [
        'penerimaan_id',
        'pengeluaran_id',
        'item_id',
        'qty'
    ];

    // Relasi ke Item
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}