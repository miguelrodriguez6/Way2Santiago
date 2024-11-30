<?php

use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\StageCommentsController;
use App\Http\Controllers\Api\StageController;
use App\Http\Controllers\Api\StageParticipantsController;
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

Route::prefix('locations')->group(function() {
    Route::get('/', [LocationController::class, 'index']); // GET /api/locations
    Route::post('/', [LocationController::class, 'store']); // POST /api/locations
    Route::get('{id}', [LocationController::class, 'show']); // GET /api/locations/{id}
    Route::put('{id}', [LocationController::class, 'update']); // PUT /api/locations/{id}
    Route::delete('{id}', [LocationController::class, 'destroy']); // DELETE /api/locations/{id}
});

Route::prefix('stages')->group(function() {
    Route::get('/', [StageController::class, 'index']); // GET /api/stages
    Route::post('/', [StageController::class, 'store']); // POST /api/stages
    Route::get('{id}', [StageController::class, 'show']); // GET /api/stages/{id}
    Route::put('{id}', [StageController::class, 'update']); // PUT /api/stages/{id}
    Route::delete('{id}', [StageController::class, 'destroy']); // DELETE /api/stages/{id}
});

Route::prefix('stage-comments')->group(function() {
    Route::get('/', [StageCommentsController::class, 'index']); // GET /api/stage-comments
    Route::post('/', [StageCommentsController::class, 'store']); // POST /api/stage-comments
    Route::get('{id}', [StageCommentsController::class, 'show']); // GET /api/stage-comments/{id}
    Route::put('{id}', [StageCommentsController::class, 'update']); // PUT /api/stage-comments/{id}
    Route::delete('{id}', [StageCommentsController::class, 'destroy']); // DELETE /api/stage-comments/{id}
});

Route::prefix('participants')->group(function() {
    Route::get('/', [StageParticipantsController::class, 'index']); // GET /api/participants
    Route::post('/', [StageParticipantsController::class, 'store']); // POST /api/participants
    Route::get('{id}', [StageParticipantsController::class, 'show']); // GET /api/participants/{id}
    Route::put('{id}', [StageParticipantsController::class, 'update']); // PUT /api/participants/{id}
    Route::delete('{id}', [StageParticipantsController::class, 'destroy']); // DELETE /api/participants/{id}
});

