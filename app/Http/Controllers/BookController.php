<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = $request->input('title');
        $filter = $request->input('filter', '');

        try {
            $books = $this->bookService->getBookQuery($title, $filter);

            return view('books.index', ['books' => $books]);
        } catch (\Exception $e) {
            return back()->withErrors('獲取書籍列表時發生錯誤：'.$e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('books.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $book = $this->bookService->createBook($request);

            return redirect()->route('books.show', $book)
                ->with('success', '書籍建立成功！');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->withErrors('建立書籍時發生錯誤：'.$e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        try {
            $bookWithDetails = $this->bookService->getBookById($book->id);

            if (! $bookWithDetails) {
                return redirect()->route('books.index')
                    ->withErrors('找不到指定的書籍。');
            }

            return view('books.show', [
                'book' => $bookWithDetails,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('books.index')
                ->withErrors('獲取書籍詳情時發生錯誤：'.$e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        return view('books.form', [
            'book' => $book,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        try {
            $updated = $this->bookService->updateBook($book, $request);

            if ($updated) {
                return redirect()->route('books.show', $book)
                    ->with('success', '書籍更新成功！');
            } else {
                return back()->withErrors('更新書籍時發生錯誤。')->withInput();
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->withErrors('更新書籍時發生錯誤：'.$e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        try {
            $deleted = $this->bookService->deleteBook($book);

            if ($deleted) {
                return redirect()->route('books.index')
                    ->with('success', '書籍刪除成功！');
            } else {
                return back()->withErrors('刪除書籍時發生錯誤。');
            }
        } catch (\Exception $e) {
            return back()->withErrors('刪除書籍時發生錯誤：'.$e->getMessage());
        }
    }
}
