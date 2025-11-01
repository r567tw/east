<?php

namespace App\Services;

use App\Repositories\BookRepository;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BookService
{
    protected $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * 根據條件取得書籍
     */
    public function getBookQuery(?string $title, ?string $filter): Collection
    {
        if ($title) {
            return $this->bookRepository->findByTitle($title);
        }

        $data = cache()->remember('book_list:' . $filter, 3600, function () use ($filter) {
            return match ($filter) {
                'highest_review_count' => $this->bookRepository->getHighestReviewCount(),
                'highest_rating_avg' => $this->bookRepository->getHighestRatingAvg(),
                default => $this->bookRepository->getBooksByLatest()
            };
        });

        return $data;
    }

    /**
     * 建立新書籍
     */
    public function createBook(Request $request): Book
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
        ]);

        return $this->bookRepository->createBook(
            $validated['title'],
            $validated['author'],
        );
    }

    /**
     * 取得單一書籍（包含快取）
     */
    public function getBookById(int $id): ?Book
    {
        $cache_key = 'book:' . $id;

        return cache()->remember($cache_key, 3600, function () use ($id) {
            return $this->bookRepository->findByIdWithReviews($id);
        });
    }

    /**
     * 更新書籍
     */
    public function updateBook(Book $book, Request $request): bool
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
        ]);

        // 清除快取
        cache()->forget('book:' . $book->id);

        return $this->bookRepository->updateBook($book, $validated);
    }

    /**
     * 刪除書籍
     */
    public function deleteBook(Book $book): bool
    {
        // 清除快取
        cache()->forget('book:' . $book->id);

        return $this->bookRepository->deleteBook($book);
    }
}
