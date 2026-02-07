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
        Schema::create('penerimaan_detail', function (Blueprint $table) {
    $table->id();
    $table->foreignId('penerimaan_id')->constrained('penerimaan')->onDelete('cascade');
    $table->foreignId('item_id')->constrained('items'); // Relasi ke tabel barang
    $table->integer('qty');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerimaan');
    }
};