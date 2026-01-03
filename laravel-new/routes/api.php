<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/posts', [PostController::class, 'index'])
        ->name('posts.index');

    Route::post('/posts', [PostController::class, 'store'])
        ->name('posts.store');
});
Route::middleware(['auth:sanctum', 'admin'])
    ->post('/posts', [PostController::class, 'store']);


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



