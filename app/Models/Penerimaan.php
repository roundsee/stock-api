<?php

namespace App\Models;

use App\Helpers\Generator;
use Illuminate\Database\Eloquent\Model;

class Penerimaan extends Model
{
    protected $table = 'penerimaan';
    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function ($penerimaan) {
            // Otomatis isi no_terima sebelum save
            $penerimaan->no_terima = Generator::trxNo(self::class, 'RCP', 'no_terima');
        });
    }
    
public function penerimaanDetails()
{
    // Pastikan nama model detailnya benar (misal: PenerimaanDetail)
    return $this->hasMany(PenerimaanDetail::class, 'penerimaan_id');
}
public function gudang()
    {
        return $this->belongsTo(Gudang::class);
    }
}