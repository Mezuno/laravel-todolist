<?php

use App\Http\Controllers\ListItemController;
use App\Http\Controllers\TodoListController;
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

Route::post('check', [ListItemController::class, 'check']);
Route::post('uncheck', [ListItemController::class, 'uncheck']);
Route::post('item/update', [ListItemController::class, 'update']);
Route::post('item/{itemId}/image/update', [ListItemController::class, 'updateImage']);
Route::post('item/delete', [ListItemController::class, 'delete']);
Route::post('/item/{item}/remove-image/', [ListItemController::class, 'removeImage']);
Route::post('/todolist/{list}/share/', [TodoListController::class, 'share']);
