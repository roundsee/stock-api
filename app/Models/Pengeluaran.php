<?php

namespace App\Models;

use App\Helpers\Generator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengeluaran extends Model
{
    protected $table = 'pengeluaran';
    protected $fillable = ['tgl_keluar', 'gudang_id', 'user_id', 'no_keluar', 'keterangan'];
    protected static function booted()
{

    static::creating(function ($pengeluaran) {
        $pengeluaran->no_keluar = Generator::trxNo(self::class, 'ISU', 'no_keluar');
    });
}
public function gudang(): BelongsTo
    {
        return $this->belongsTo(Gudang::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
public function PengeluaranDetail(): HasMany
    {
        return $this->hasMany(PengeluaranDetail::class, 'pengeluaran_id');
    }
}
