<?php

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

Route::post('check', [\App\Http\Controllers\TodoListController::class, 'check']);
Route::post('uncheck', [\App\Http\Controllers\TodoListController::class, 'uncheck']);
Route::post('item/update', [\App\Http\Controllers\TodoListController::class, 'updateItem']);
Route::post('item/delete', [\App\Http\Controllers\TodoListController::class, 'deleteItem']);
