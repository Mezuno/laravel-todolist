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

Route::post('check', [\App\Http\Controllers\ListItemController::class, 'check']);
Route::post('uncheck', [\App\Http\Controllers\ListItemController::class, 'uncheck']);
Route::post('item/update', [\App\Http\Controllers\ListItemController::class, 'update']);
Route::post('item/{itemId}/image/update', [\App\Http\Controllers\ListItemController::class, 'updateImage']);
Route::post('item/delete', [\App\Http\Controllers\ListItemController::class, 'delete']);
