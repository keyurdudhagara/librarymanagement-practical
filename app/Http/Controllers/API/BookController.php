<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

// modela
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $cacheKey = 'books_list';

       
        $books = Cache::remember($cacheKey, 600, function () {
            return Book::paginate(10);
        });
        
        return response()->json(['message' => 'All book retrived sucess fully', 'books' => $books]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'nullable|string',
            'isbn' => 'required|string|unique:books',
            'published_year' => 'nullable|integer',
            'total_copies' => 'required|integer|min:1',
        ]);

        $data['available_copies'] = $data['total_copies'];

        $book = Book::create($data);

        Cache::forget('books_list');
        

        return response()->json(['message' => 'Book added sucess fully', 'book' => $book], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
        $cacheKey = "book_{$id}";

        // Cache each book for 10 minutes(600 sec)
        $book = Cache::remember($cacheKey, 600, function () use ($id) {
            return Book::findOrFail($id);
        });
        return response()->json($book);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $book = Book::findOrFail($id);

        $data = $request->validate([
            'title' => 'sometimes|string|max:255',
            'author' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'isbn' => 'sometimes|string|unique:books,isbn,' . $book->id,
            'published_year' => 'nullable|integer',
            'total_copies' => 'sometimes|integer|min:1',
            'available_copies' => 'sometimes|integer|min:0',
        ]);

        $book->update($data);

        Cache::forget('books_list');
        Cache::forget("book_{$id}");

        return response()->json(['message' => 'Book updated sucessfully', 'book' => $book]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $book = Book::findOrFail($id);
        $book->delete();

        Cache::forget('books_list');
        Cache::forget("book_{$id}");

        
        return response()->json(['message' => 'Book deleted sucessfully']);
    }
}
