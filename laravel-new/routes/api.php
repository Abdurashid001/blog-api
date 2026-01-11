<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminLogController;



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/posts', [PostController::class, 'index'])
        ->name('posts.index');

    Route::post('/posts', [PostController::class, 'store'])
        ->name('posts.store');
});
Route::middleware(['auth:sanctum', 'admin'])
    ->post('/posts', [PostController::class, 'store']);

Route::middleware(['auth:sanctum', 'admin'])
    ->patch('/admins/{id}/revoke', [AdminController::class, 'revoke']);

Route::middleware(['auth:sanctum', 'admin'])
    ->delete('/admins/{id}', [AdminController::class, 'destroy']);

Route::middleware(['auth:sanctum', 'super_admin'])
    ->delete('/admins/{id}', [AdminController::class, 'destroy']);

Route::middleware(['auth:sanctum', 'super_admin'])
    ->get('/admin-logs', [AdminLogController::class, 'index']);


Route::apiResource('posts', PostController::class);
Route::get('/posts/{id}', [PostController::class, 'show']);
Route::put('/posts/{id}', [PostController::class, 'update']);
Route::delete('/posts/{id}', [PostController::class, 'destroy']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('posts', PostController::class);
});

Route::get('/ping', function () {
    return response()->json([
        'status' => 'ok',
    ]);
});



