<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\TransactionController;
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

Route::apiResource('customers', CustomerController::class);

Route::delete('customers/{customer}/forceDestroy', [CustomerController::class, 'forceDestroy'])->name('customers.forceDestroy');

Route::post('/transaction/start', [TransactionController::class, 'startTransaction']);
Route::post('/transaction/update', [TransactionController::class, 'updateTransactionStep']);
Route::get('/transaction/resume', [TransactionController::class, 'resumeTransaction']);
Route::post('/transaction/complete', [TransactionController::class, 'completeTransaction']);
Route::post('/transaction/cancel', [TransactionController::class, 'cancelTransaction']);


Route::apiResource('projects', ProjectController::class);

Route::get('projects/{id}/tasks', [TaskController::class, 'index']);
Route::post('projects/{id}/tasks', [TaskController::class, 'store']);
Route::get('projects/{id}/tasks/{taskId}', [TaskController::class, 'show']);
Route::put('projects/{id}/tasks/{taskId}', [TaskController::class, 'update']);
Route::delete('projects/{id}/tasks/{taskId}', [TaskController::class, 'destroy']);


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('logout', [AuthController::class, 'logout']);
});
