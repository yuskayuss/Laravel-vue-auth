<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// 🔓 Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// 🔐 Authenticated Routes
Route::middleware('auth:sanctum')->group(function () {
    // ✅ Siapa saya (data user aktif)
    Route::get('/me', [AuthController::class, 'me']);

    // ✅ Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // ✅ User bisa lihat profil sendiri
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // 👑 Admin-only Routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', function () {
            return response()->json([
                'message' => 'Selamat datang di Dashboard Admin!',
                'data' => [
                    'laporan_keuangan' => [],
                    'total_transaksi' => 123456,
                ],
            ]);
        });

        // Tambah route admin lainnya di sini
    });

    // 👤 User-only Routes
    Route::middleware('role:user')->group(function () {
        Route::get('/user/dashboard', function () {
            return response()->json([
                'message' => 'Selamat datang di Dashboard User!',
                'data' => [
                    'transaksi_saya' => [],
                    'saldo' => 150000,
                ],
            ]);
        });

        // Tambah route user lainnya di sini
    });
});
