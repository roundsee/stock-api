<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class PenerimaanDetail extends Model
{
    protected $guarded = [];
    protected $table = 'penerimaan_detail';
    public function item()
    {
        // Supaya di Flutter bisa panggil item_name
        return $this->belongsTo(Item::class, 'item_id');
    }
}