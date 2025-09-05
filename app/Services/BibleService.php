<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class BibleService
{
    private string $bibleId = "a93a92589195411f-01";
    private string $baseUrl = "https://api.scripture.api.bible/v1/bibles";
    private int $cacheDuration = 3600; // 1h

    private function fetch(string $endpoint)
    {
        $cacheKey = "bible_api_" . md5($endpoint);

        return Cache::remember($cacheKey, $this->cacheDuration, function () use ($endpoint) {
            try {
                $response = Http::withHeaders([
                    'api-key' => env('BIBLE_API_KEY')
                ])->timeout(5) // Timeout de 5s
                  ->get("{$this->baseUrl}/{$this->bibleId}/{$endpoint}");

                if ($response->failed()) {
                    Log::warning("Bible API failed: {$endpoint}", [
                        'status' => $response->status(),
                        'body' => $response->body()
                    ]);
                    return null;
                }

                return $response->json()['data'] ?? null;

            } catch (\Exception $e) {
                Log::error("Bible API error: {$endpoint}", [
                    'message' => $e->getMessage()
                ]);
                return null; // Retourne null si erreur réseau ou exception
            }
        });
    }

    public function getBooks(){ 
        return $this->fetch("books"); 
    }
    public function getBook(string $bookId){ 
        return $this->fetch("books/{$bookId}"); 
    }
    public function getChapters(string $bookId){ 
        return $this->fetch("books/{$bookId}/chapters"); 
    }
    public function getChapter(string $chapterId) { 
        return $this->fetch("chapters/{$chapterId}"); 
    }
    public function getVerses(string $chapterId){ 
        return $this->fetch("chapters/{$chapterId}/verses"); 
    }
    public function getVerse(string $verseId){ 
        return $this->fetch("verses/{$verseId}"); 
    }
}
