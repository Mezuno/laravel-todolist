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
        Route::get('/create', [App\Http\Controllers\TodoListController::class, 'create'])->name('list.create');
        Route::get('/{list}/', [App\Http\Controllers\TodoListController::class, 'show'])->name('list.show');
        Route::post('/', [App\Http\Controllers\TodoListController::class, 'store'])->name('list.store');
        Route::delete('/{list}/delete', [App\Http\Controllers\TodoListController::class, 'delete'])->name('list.delete');
        Route::get('/{list}/edit', [App\Http\Controllers\TodoListController::class, 'edit'])->name('list.edit');
        Route::patch('/{list}/', [App\Http\Controllers\TodoListController::class, 'update'])->name('list.update');

        Route::post('/item/store', [App\Http\Controllers\ListItemController::class, 'storeItem'])->name('item.store');

    });


    Route::group(['prefix' => 'tags'], function() {

        Route::get('/', [App\Http\Controllers\TagController::class, 'index'])->name('tag.index');
        Route::post('/', [App\Http\Controllers\TagController::class, 'store'])->name('tag.store');
        Route::get('/create', [App\Http\Controllers\TagController::class, 'create'])->name('tag.create');
        Route::patch('/{tag}', [App\Http\Controllers\TagController::class, 'update'])->name('tag.update');
        Route::get('/{tag}/edit', [App\Http\Controllers\TagController::class, 'edit'])->name('tag.edit');
        Route::delete('/{tag}/delete', [App\Http\Controllers\TagController::class, 'delete'])->name('tag.delete');

    });

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
