<?php

use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('users')->group(function() {
    Route::get('/', [UserController::class, 'index']); // GET /api/users
    Route::post('/', [UserController::class, 'store']); // POST /api/users
    Route::get('{id}', [UserController::class, 'show']); // GET /api/users/{id}
    Route::put('{id}', [UserController::class, 'update']); // PUT /api/users/{id}
    Route::delete('{id}', [UserController::class, 'destroy']); // DELETE /api/users/{id}
});

Route::get('/locations', [LocationController::class, 'index']);
Route::post('/locations', [LocationController::class, 'store']);
Route::get('/locations/{id}', [LocationController::class, 'show']);
Route::put('/locations/{id}', [LocationController::class, 'update']);
Route::delete('/locations/{id}', [LocationController::class, 'destroy']);


