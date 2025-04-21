<?php

use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MovieController::class, 'index'])->name('movies');
Route::get('/create', [MovieController::class, 'create'])->name('movie.create');
Route::post('/save', [MovieController::class, 'save'])->name('movie.save');
Route::get('{movie}/edit', [MovieController::class, 'edit'])->name('movie.edit');
Route::put('/{movie}/update', [MovieController::class, 'update'])->name('movie.update');
Route::delete('/{movie}/delete', [MovieController::class, 'delete'])->name('movie.delete');
