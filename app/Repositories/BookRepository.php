<?php

namespace App\Repositories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BookRepository
{
    /**
     * 取得所有書籍
     */
    public function getBooksByLatest(): Collection
    {
        return Book::withAvgRating()
            ->withReviewsCount()
            ->latest()
            ->get();
    }

    /**
     * 根據標題搜尋書籍
     */
    public function findByTitle(string $title): Collection
    {
        return Book::where('title', 'like', '%' . $title . '%')
            ->withAvgRating()
            ->withReviewsCount()
            ->latest()
            ->get();
    }

    public function getHighestReviewCount(): Collection
    {
        return Book::withAvgRating()
            ->withReviewsCount()
            ->orderByDesc('reviews_count')
            ->get();
    }

    public function getHighestRatingAvg(): Collection
    {
        return Book::withAvgRating()
            ->withReviewsCount()
            ->orderByDesc('reviews_avg_rating')
            ->get();
    }


    /**
     * 建立新書籍
     */
    public function createBook(string $title, string $author): Book
    {
        $book = new Book();
        $book->title = $title;
        $book->author = $author;
        $book->save();
        return $book;
    }

    /**
     * 根據 ID 查找書籍
     */
    public function findById(int $id): ?Book
    {
        return Book::find($id);
    }

    /**
     * 根據 ID 查找書籍（包含評論）
     */
    public function findByIdWithReviews(int $id): ?Book
    {
        return Book::with(['reviews' => function ($query) {
            return $query->latest();
        }])
            ->withCount('reviews')
            ->withAvgRating()
            ->find($id);
    }

    /**
     * 更新書籍
     */
    public function updateBook(Book $book, array $data): bool
    {
        $book->title = $data['title'] ?? $book->title;
        $book->author = $data['author'] ?? $book->author;
        return $book->save();
    }

    /**
     * 刪除書籍
     */
    public function deleteBook(Book $book): bool
    {
        return $book->delete();
    }
}
