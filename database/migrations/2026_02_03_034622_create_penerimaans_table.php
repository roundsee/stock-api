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
        Schema::create('penerimaan', function (Blueprint $table) {
    $table->id();
    $table->string('no_terima')->unique(); // Contoh: RCP-20260001
    $table->date('tgl_terima');
    $table->text('keterangan')->nullable();
    $table->string('supplier')->nullable();
    $table->foreignId('gudang_id')->constrained('gudang');
    $table->foreignId('user_id')->constrained('users');
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
