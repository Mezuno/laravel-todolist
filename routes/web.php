<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TodoListController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('main');
});

Route::middleware('auth')->group(function () {

    Route::group(['prefix' => 'todolist'], function() {

        Route::get('/', [App\Http\Controllers\TodoListController::class, 'index'])->name('list.index');
        Route::get('/{list}/', [App\Http\Controllers\TodoListController::class, 'show'])->name('list.show');
        Route::delete('/{list}/delete', [App\Http\Controllers\TodoListController::class, 'delete'])->name('list.delete');
        Route::get('/{list}/edit', [App\Http\Controllers\TodoListController::class, 'edit'])->name('list.edit');
        Route::patch('/{list}/', [App\Http\Controllers\TodoListController::class, 'update'])->name('list.update');
        Route::post('/item/store', [App\Http\Controllers\TodoListController::class, 'storeItem'])->name('item.store');

    });

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
