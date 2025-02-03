<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'Welcome to E-Food API'
    ]);
});

//Load Route file on specific path
Route::prefix('admin')->group(base_path('routes/admin.php'));
Route::prefix('merchant')->group(base_path('routes/merchant.php'));
Route::prefix('driver')->group(base_path('routes/driver.php'));
Route::prefix('client')->group(base_path('routes/client.php'));
