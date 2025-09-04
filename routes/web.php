<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\BooksController;

Route::get('/', function () {
    return redirect('/books');
});

Route::get('/books', [BooksController::class, 'index'])->name('books.index');
Route::get('/books/{bookId}', [BooksController::class, 'show'])->name('books.show');
Route::get('/books/{bookId}/chapters/{chapterId}', [BooksController::class, 'chapter'])->name('books.chapter');
Route::get('/books/{bookId}/chapters/{chapterId}/verses/{verseId}', [BooksController::class, 'verse'])->name('books.verse');