<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;

class BooksController extends Controller
{
    private $bibleId = "a93a92589195411f-01";

    public function index()
    {
        $books = Http::withHeaders([
            'api-key' => env('BIBLE_API_KEY')
        ])->get("https://api.scripture.api.bible/v1/bibles/{$this->bibleId}/books");

        return Inertia::render('Books/Index', [
            'books' => $books->json()['data'] ?? []
        ]); 
    }

    public function show($bookId)
    {
        $book = Http::withHeaders([
            'api-key' => env('BIBLE_API_KEY')
        ])->get("https://api.scripture.api.bible/v1/bibles/{$this->bibleId}/books/{$bookId}");

        $chapters = Http::withHeaders([
            'api-key' => env('BIBLE_API_KEY')
        ])->get("https://api.scripture.api.bible/v1/bibles/{$this->bibleId}/books/{$bookId}/chapters");

        return Inertia::render('Books/Show', [
            'book' => $book->json()['data'] ?? null,
            'chapters' => $chapters->json()['data'] ?? []
        ]);
    }

    public function chapter($bookId, $chapterId)
    {
        $book = Http::withHeaders([
            'api-key' => env('BIBLE_API_KEY')
        ])->get("https://api.scripture.api.bible/v1/bibles/{$this->bibleId}/books/{$bookId}");

        $chapter = Http::withHeaders([
            'api-key' => env('BIBLE_API_KEY')
        ])->get("https://api.scripture.api.bible/v1/bibles/{$this->bibleId}/chapters/{$chapterId}");

        $verses = Http::withHeaders([
            'api-key' => env('BIBLE_API_KEY')
        ])->get("https://api.scripture.api.bible/v1/bibles/{$this->bibleId}/chapters/{$chapterId}/verses");

        return Inertia::render('Books/Chapter', [
            'book' => $book->json()['data'] ?? null,
            'chapter' => $chapter->json()['data'] ?? null,
            'verses' => $verses->json()['data'] ?? []
        ]);
    }

    public function verse($bookId, $chapterId, $verseId)
    {
        $book = Http::withHeaders([
            'api-key' => env('BIBLE_API_KEY')
        ])->get("https://api.scripture.api.bible/v1/bibles/{$this->bibleId}/books/{$bookId}");

        $chapter = Http::withHeaders([
            'api-key' => env('BIBLE_API_KEY')
        ])->get("https://api.scripture.api.bible/v1/bibles/{$this->bibleId}/chapters/{$chapterId}");

        $verse = Http::withHeaders([
            'api-key' => env('BIBLE_API_KEY')
        ])->get("https://api.scripture.api.bible/v1/bibles/{$this->bibleId}/verses/{$verseId}");

        return Inertia::render('Books/Verse', [
            'book' => $book->json()['data'] ?? null,
            'chapter' => $chapter->json()['data'] ?? null,
            'verse' => $verse->json()['data'] ?? null
        ]);
    }
}