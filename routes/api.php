<?php

use Illuminate\Http\Request;
use App\Http\Controllers\BarangC;
use App\Http\Controllers\TransaksiC;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::apiResource('/barang', BarangC::class);
Route::apiResource('/transaksi', TransaksiC::class);
