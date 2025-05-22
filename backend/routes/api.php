<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;

Route::get('/books', [BookController::class, 'index']);
Route::post('/books/{id}/borrow', [BookController::class, 'borrow']);
Route::post('/books/{id}/return', [BookController::class, 'return']);
Route::get('/books/borrowed', [BookController::class, 'borrowed']);
