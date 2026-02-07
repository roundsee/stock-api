<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengeluaranDetail extends Model
{
    protected $table = 'pengeluaran_detail';
    protected $guarded = [];

    // Relasi balik ke Header
    public function pengeluaran(): BelongsTo
    {
        return $this->belongsTo(Pengeluaran::class, 'pengeluaran_id');
    }

    // Relasi ke barang (Sangat penting untuk menampilkan nama barang di Flutter)
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}