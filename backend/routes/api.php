<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('api')->group(function () {
    // List all books with optional search
    Route::get('/books', [BookController::class, 'index']);

    // Borrow a book by ID
    Route::post('/books/{id}/borrow', [BookController::class, 'borrow']);

    // Return a book by ID
    Route::post('/books/{id}/return', [BookController::class, 'return']);

    // List all borrowed books
    Route::get('/books/borrowed', [BookController::class, 'borrowed']);
});
