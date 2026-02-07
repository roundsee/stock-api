<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('stock_log', function (Blueprint $table) {
    $table->id();
    $table->foreignId('item_id')->constrained('items');
    $table->foreignId('gudang_id')->constrained('gudang');
    $table->string('referensi_no'); // No Terima / No Keluar / No Adj
    $table->enum('jenis', ['masuk', 'keluar', 'adjustment']);
    $table->integer('qty');
    $table->integer('stok_awal');
    $table->integer('stok_akhir');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_log');
    }
};
