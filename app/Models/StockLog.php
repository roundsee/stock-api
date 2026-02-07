<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockLog extends Model
{
    protected $table = 'stock_log';
    protected $fillable = [
        'item_id', 'gudang_id', 'referensi_no', 
        'jenis', 'qty', 'stok_awal', 'stok_akhir'
    ];

    /**
     * Relasi ke Gudang (Log ini milik gudang mana?)
     */
    public function gudang(): BelongsTo
    {
        return $this->belongsTo(Gudang::class, 'gudang_id', 'id');
    }

    /**
     * Relasi ke Item (Log ini milik item mana?)
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }
}