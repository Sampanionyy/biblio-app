<?php

namespace App\Http\Controllers;

use App\Services\BibleService;
use Inertia\Inertia;

class BooksController extends Controller
{
    private BibleService $bibleService;

    public function __construct(BibleService $bibleService)
    {
        $this->bibleService = $bibleService;
    }

    /** Liste des livres */
    public function index()
    {
        $books = $this->bibleService->getBooks();
        return Inertia::render('Books/Index', [
            'books' => $books ?? []
        ]);
    }

    /** Détails d'un livre + ses chapitres */
    public function show(string $bookId)
    {
        return Inertia::render('Books/Show', [
            'book' => $this->bibleService->getBook($bookId),
            'chapters' => $this->bibleService->getChapters($bookId) ?? []
        ]);
    }

    /** Détails d'un chapitre + ses versets */
    public function chapter(string $bookId, string $chapterId)
    {
        return Inertia::render('Books/Chapter', [
            'book' => $this->bibleService->getBook($bookId),
            'chapter' => $this->bibleService->getChapter($chapterId),
            'verses' => $this->bibleService->getVerses($chapterId) ?? []
        ]);
    }

    /** Détails d'un verset précis */
    public function verse(string $bookId, string $chapterId, string $verseId)
    {
        return Inertia::render('Books/Verse', [
            'book' => $this->bibleService->getBook($bookId),
            'chapter' => $this->bibleService->getChapter($chapterId),
            'verse' => $this->bibleService->getVerse($verseId)
        ]);
    }
   
    public function search($bookId = null)
    {
        $query = request()->query('query', '');
        $results = $this->bibleService->searchVerses($query);

        return Inertia::render('Books/Search', [
            'query' => $query,
            'results' => $results
        ]);
    }
}
