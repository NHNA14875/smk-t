<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KartuController;
use App\Http\Controllers\AkunController;

// --- RUTE GUEST ---
Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

// --- RUTE TERPROTEKSI ---
Route::middleware('auth')->group(function () {

    // Semua role
    Route::get('/input', function () {
        return view('kartu.input');
    });
    Route::post('/input', [KartuController::class, 'simpan']);

    // CS dan Admin
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

    // Admin only — Manajemen Akun
    Route::get('/akun',                    [AkunController::class, 'index']);
    Route::post('/akun',                   [AkunController::class, 'store']);
    Route::put('/akun/{id}',               [AkunController::class, 'update']);
    Route::patch('/akun/{id}/toggle',      [AkunController::class, 'toggleActive']);
});