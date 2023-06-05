<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListItemController;
use App\Http\Controllers\TagController;
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

        Route::get('/', [TodoListController::class, 'index'])->name('list.index');
        Route::get('/create', [TodoListController::class, 'create'])->name('list.create');
        Route::get('/{list}/', [TodoListController::class, 'show'])->name('list.show');
        Route::post('/', [TodoListController::class, 'store'])->name('list.store');
        Route::delete('/{list}/delete', [TodoListController::class, 'delete'])->name('list.delete');
        Route::get('/{list}/edit', [TodoListController::class, 'edit'])->name('list.edit');
        Route::patch('/{list}/', [TodoListController::class, 'update'])->name('list.update');

        Route::post('/{list}/', [ListItemController::class, 'store'])->name('item.store');
    });


    Route::group(['prefix' => 'tags'], function() {

        Route::get('/', [TagController::class, 'index'])->name('tag.index');
        Route::post('/', [TagController::class, 'store'])->name('tag.store');
        Route::get('/create', [TagController::class, 'create'])->name('tag.create');
        Route::patch('/{tag}', [TagController::class, 'update'])->name('tag.update');
        Route::get('/{tag}/edit', [TagController::class, 'edit'])->name('tag.edit');
        Route::delete('/{tag}/delete', [TagController::class, 'delete'])->name('tag.delete');

    });

});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
