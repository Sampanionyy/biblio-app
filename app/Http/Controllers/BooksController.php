<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;

class BooksController extends Controller
{
    public function index()
    {
        $bibleId = "a93a92589195411f-01";

        $books = Http::withHeaders([
            'api-key' => env('BIBLE_API_KEY')
        ])->get("https://api.scripture.api.bible/v1/bibles/{$bibleId}/books");

        return Inertia::render('Books', [
            'books' => $books->json()['data'] ?? []
        ]); 
    }
}
