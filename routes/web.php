<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KartuController;

// --- RUTE GUEST (Belum Login) ---
Route::get('/', function () { 
    return view('login'); 
})->name('login');

Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

// --- RUTE SISTEM TERPROTEKSI ---
Route::middleware('auth')->group(function () {
    
    // 1. Akses Universal (Bisa diakses Satpam, CS, dan Admin)
    Route::get('/input', function () { 
        return view('kartu.input'); 
    });
    Route::post('/input', [KartuController::class, 'simpan']);
    
    // 2. Akses Khusus CS dan Admin
    Route::get('/dashboard', function () {
        if (!in_array(auth()->user()->role, ['cs', 'admin'])) abort(403);
        return app(KartuController::class)->dashboard();
    });

    Route::post('/kartu/{id}/status', function (Request $request, $id) {
        if (!in_array(auth()->user()->role, ['cs', 'admin'])) abort(403);
        return app(KartuController::class)->updateStatus($request, $id);
    });

    Route::get('/arsip', function () {
        if (!in_array(auth()->user()->role, ['cs', 'admin'])) abort(403);
        return app(KartuController::class)->arsip();
    });

    Route::get('/rekap', function () {
        if (!in_array(auth()->user()->role, ['cs', 'admin'])) abort(403);
        return app(KartuController::class)->rekap();
    });

    // 3. Akses Super Khusus Admin
    Route::get('/akun', function () {
        if (auth()->user()->role !== 'admin') abort(403);
        return view('kartu.akun');
    });
});