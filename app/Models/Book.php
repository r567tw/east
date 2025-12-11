<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * 取得書籍的平均評分
     */
    public function scopeWithAvgRating(Builder $query): Builder
    {
        return $query->withAvg('reviews', 'rating');
    }

    /**
     * 取得書籍的評論數量
     */
    public function scopeWithReviewsCount(Builder $query): Builder
    {
        return $query->withCount('reviews');
    }

    /**
     * 根據標題搜尋
     */
    public function scopeSearchByTitle(Builder $query, string $title): Builder
    {
        return $query->where('title', 'like', '%'.$title.'%');
    }

    /**
     * 根據作者搜尋
     */
    public function scopeSearchByAuthor(Builder $query, string $author): Builder
    {
        return $query->where('author', 'like', '%'.$author.'%');
    }

    /**
     * 取得評分
     */
    public function getAverageRatingAttribute(): float
    {
        return $this->reviews()->avg('rating') ?: 0;
    }

    /**
     * 取得評論數量
     */
    public function getReviewsCountAttribute(): int
    {
        return $this->reviews()->count();
    }

    protected static function booted()
    {
        static::saved(fn (Book $book) => cache()->forget('book:'.$book->id));
        static::deleted(fn (Book $book) => cache()->forget('book:'.$book->id));
    }
}
