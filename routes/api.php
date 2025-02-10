<?php

use Illuminate\Support\Facades\Route;
use App\Models\Role;

Route::get('/', function () {
    return response()->json([
        'message' => 'Welcome to E-Food API'
    ]);
});

Route::get("/roles", function () {
    $roles = Role::all();

    return response()->json([
        "success" => true,
        "data" => [
            "roles" => $roles
        ]
    ]);
});
//Load Route file on specific path
Route::prefix('admin')->name('admin')->group(base_path('routes/admin.php'));
Route::prefix('merchant')->name('merchant')->group(base_path('routes/merchant.php'));
Route::prefix('driver')->name('driver')->group(base_path('routes/driver.php'));
Route::prefix('client')->name('client')->group(base_path('routes/client.php'));
