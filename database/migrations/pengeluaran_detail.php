<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengeluaran_detail', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel header pengeluaran
            $table->foreignId('pengeluaran_id')->constrained('pengeluaran')->onDelete('cascade');
            // Menghubungkan ke tabel barang
            $table->foreignId('item_id')->constrained('items'); 
            $table->integer('qty');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengeluaran_detail');
    }
};