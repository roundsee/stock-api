<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\GudangController;
use App\Http\Controllers\Api\PenerimaanController;
use App\Http\Controllers\Api\AuthController; // Kita akan buat ini
use App\Http\Controllers\Api\PengeluaranController;
 use App\Http\Controllers\Api\StockReportController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');




// Route Public (Untuk Login)
Route::post('/login', [AuthController::class, 'login']);

// Route Protected (Harus Login/Bawa Token)
Route::middleware('auth:sanctum')->group(function () {
    
    Route::post('/register-staff', [AuthController::class, 'registerStaff']);

    // Master Items
    Route::get('/items', [ItemController::class, 'index']);
    Route::post('/items', [ItemController::class, 'store']);
    Route::get('/items/stock-report', [ItemController::class, 'stockReport']);

    // Master Gudang
    Route::get('/gudangs', [GudangController::class, 'index']);
    Route::post('/gudangs', [GudangController::class, 'store']);

    // // Transaksi
     Route::post('/penerimaan', [PenerimaanController::class, 'store']);



    Route::post('/pengeluaran', [PengeluaranController::class, 'store']);     

   
Route::get('/stock-logs', [StockReportController::class, 'StockLog']);
Route::get('/stock-report', [StockReportController::class, 'index']);
Route::get('/stock-history/{itemId}', [StockReportController::class, 'history']);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});