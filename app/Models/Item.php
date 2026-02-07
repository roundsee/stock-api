<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    protected $table = 'items';
    protected $fillable = ['item_code', 'item_name','item_type', 'unit'];

    /**
     * Relasi ke StockLog (Satu Item punya banyak catatan log stok)
     */
    public function stockLogs(): HasMany
    {
        return $this->hasMany(StockLog::class, 'item_id', 'id');
    }
}