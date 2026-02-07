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
Schema::create('stock_mutasi', function (Blueprint $table) {
    $table->id();
    // Menghubungkan ke header (bisa null salah satu tergantung jenis transaksi)
    $table->foreignId('penerimaan_id')->nullable()->constrained('penerimaan')->onDelete('cascade');
    $table->foreignId('pengeluaran_id')->nullable()->constrained('pengeluaran')->onDelete('cascade');
    
    $table->foreignId('item_id')->constrained('items');
    $table->integer('qty');
    $table->timestamps();
});    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_mutasi');
    }
};
